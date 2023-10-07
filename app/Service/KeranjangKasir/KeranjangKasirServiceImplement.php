<?php

namespace App\Service\KeranjangKasir;

use App\Repository\KeranjangKasir\KeranjangKasirRepository;
use App\Repository\NewStruck\NewStruckRepository;
use App\Repository\Product\ProductRepository;
use App\Repository\ProductJual\ProductJualRepository;
use Illuminate\Support\Facades\Validator;
use stdClass;
use Illuminate\Support\Facades\DB;


class KeranjangKasirServiceImplement implements KeranjangKasirService{

    protected $repository;
    public function __construct(KeranjangKasirRepository $repository, 
                                ProductJualRepository $repo_product_jual,
                                NewStruckRepository $repo_struck,
                                ProductRepository $repo_product)
    {
        $this->repository = $repository;
        $this->repo_product_jual = $repo_product_jual;
        $this->repo_struck = $repo_struck;
        $this->repo_product = $repo_product;
    }

    public function getKerjangServiceById($request)
    {
        $validated = Validator::make($request->all(),[
            'id_keranjang_kasir' => 'required|exists:keranjang_kasirs,id_keranjang_kasir'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
       
        $data = $this->repository->getKeranjangById($request->id_keranjang_kasir);
        return $data;
    }

    public function Add1ProductKeranjangServiceById($request)
    {
        $validated = Validator::make($request->all(),[
            'id_keranjang_kasir' => 'required|exists:keranjang_kasirs,id_keranjang_kasir'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        //get db
        $data_keranjang = $this->repository->getKeranjangById($request->id_keranjang_kasir);
        $data_struck = $this->repo_struck->getStruckById($data_keranjang->struck_id);
        $find_data_product_jual = $this->repo_product_jual->getProductJualById($data_keranjang->product_jual_id);
        $satuan_item_jual = $find_data_product_jual->satuan_berat_item;
        $final_total_decimal_update =  $data_keranjang->total_decimal_buy_for_stock + (1 * $satuan_item_jual);

        if ($data_struck->status == 4) {
           $msg_err = ['status_struck' => 'id struck '.$data_keranjang->struck_id. ' tidak dapat digunakan, generate struck baru'];
           return $msg_err;
        }

        $id_prd = (int) $find_data_product_jual->product_id;
        //$product_jual_all = $this->repo_product_jual->getProductJualByIdProduct($id_prd);
        $current_jumlah_dibeli =  (int) $data_keranjang->jumlah_item_dibeli + 1;
        $cek_same_produc1_transaction = $this->repository->queryCheck1TransationSameProduct($data_keranjang->struck_id);
        
        /** cek kalau 1 transaksi ada 1 product sama totalnya melebihi stock */
        
        if ($cek_same_produc1_transaction != null ) {
            $data_parent_product = $this->repo_product->getProductById($find_data_product_jual->product_id);
            if ($data_parent_product->is_kg == 1) {
                $stock_decimal_after_add = $this->repository->queryCheck1TransationSumStockProduct($data_keranjang->struck_id,$data_parent_product->id_product);
                $final_total = $stock_decimal_after_add[0]->total + (1 * $satuan_item_jual);
                if ($final_total > $data_parent_product->total_kg) {
                    $msg_err = ['msg' =>'1 transaksi ada 1 barang dengan variant berbeda | total : '.$final_total .'', "msg_detail"=> " gagal jumlah barang yang dibeli melebihi stock yang ada"];
                    return $msg_err;
                }
            }
        }
        
     
        //save db
        DB::beginTransaction();
        try{

            //if (count($cek_change_prod) > 0) {
                //ubah product jual
                $change_new_id_produt_jual = $find_data_product_jual->id_product_jual;//$cek_change_prod[0];
                $find_change_prd_jual_new = $this->repo_product_jual->getProductJualById($change_new_id_produt_jual);
                $req_change_prd = new stdClass();
                $req_change_prd->product_jual_id = $change_new_id_produt_jual;
                $req_change_prd->jumlah_item_dibeli = $current_jumlah_dibeli;
                $req_change_prd->harga_tiap_item = $find_change_prd_jual_new->price_sell;
                $req_change_prd->total_harga_item = $find_change_prd_jual_new->price_sell * $current_jumlah_dibeli;
                $req_change_prd->total_decimal_buy_for_stock = $final_total_decimal_update;
                
                
                $update_keranjang =  $this->repository->UpdateKeranjang($req_change_prd,$request->id_keranjang_kasir);
                         

            $total_product_each_item = $this->repository->getTotalPriceAllItemMustPayCount($data_keranjang->struck_id)->total;;   
            $req_struck = new stdClass();
            $req_struck->id = $data_keranjang->struck_id;
            $req_struck->total_harga_dibayar = $total_product_each_item;                                                        
            $update_struck = $this->repo_struck->updateStruckPlusMins1($req_struck);
            //save db
            DB::commit(); //kalau variabel yang direturn tidak  ada maka (undifined), error tidak dilempar ke catch
        }catch (\Exception $e) {
            DB::rollBack();
            $update_keranjang =  false;
        }
        return $update_keranjang;
       

    }

    public function Remove1ProductKeranjangServiceById($request)
    {
        $validated = Validator::make($request->all(),[
            'id_keranjang_kasir' => 'required|exists:keranjang_kasirs,id_keranjang_kasir'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        //get db
        $data_keranjang = $this->repository->getKeranjangById($request->id_keranjang_kasir);
        $data_struck = $this->repo_struck->getStruckById($data_keranjang->struck_id);
        $find_data_product_jual = $this->repo_product_jual->getProductJualById($data_keranjang->product_jual_id);
        $total_product_each_item = $data_struck->total_harga_dibayar - $data_keranjang->harga_tiap_item; //harga yang harus diupdate pada data struck;
        $total_dibeli_setelah_dikurangi = (int) $data_keranjang->jumlah_item_dibeli - 1;  
        if ($data_struck->status == 4) {
            $msg_err = ['status_struck' => 'id struck '.$data_keranjang->struck_id. ' tidak dapat digunakan, generate struck baru'];
           return $msg_err;
        }

        //cek in product jual
        // $id_prd = (int) $find_data_product_jual->product_id;
        // $product_jual_all = $this->repo_product_jual->getProductJualByIdProduct($id_prd);
         $current_jumlah_dibeli_min =  (int) $data_keranjang->jumlah_item_dibeli - 1;
       
        $satuan_item_jual = $find_data_product_jual->satuan_berat_item;
       
        $final_total_decimal_update =  $data_keranjang->total_decimal_buy_for_stock - (1 * $satuan_item_jual);
       
       
        //save db
        DB::beginTransaction();
        try {
            if($total_dibeli_setelah_dikurangi < 1) {
                $this->repository->DeleteKeranjangStruck($request->id_keranjang_kasir);
                $save_keranjang = $this->repository->getKeranjangByStruckId($data_keranjang->struck_id);
            }else{
                //if (count($cek_change_prod) > 0) {
                    //ubah product jual
                    $change_new_id_produt_jual = $find_data_product_jual->id_product_jual;;
                    $find_change_prd_jual_new = $this->repo_product_jual->getProductJualById($change_new_id_produt_jual);
                    $req_change_prd = new stdClass();
                    $req_change_prd->product_jual_id = $change_new_id_produt_jual;
                    $req_change_prd->jumlah_item_dibeli = $current_jumlah_dibeli_min;
                    $req_change_prd->harga_tiap_item = $find_change_prd_jual_new->price_sell;
                    $req_change_prd->total_harga_item = $find_change_prd_jual_new->price_sell * $current_jumlah_dibeli_min;
                    $req_change_prd->total_decimal_buy_for_stock = $final_total_decimal_update;

                    $save_keranjang =  $this->repository->UpdateKeranjang($req_change_prd,$request->id_keranjang_kasir);
                   
                   
               
            }
                

         
           $total_all_price_base_struck_id = $this->repository->getTotalPriceAllItemMustPayCount($data_keranjang->struck_id)->total;
           //$data_struck->total_harga_dibayar - $data_keranjang_after_update->harga_tiap_item;
           $req_struck = new stdClass();
           $req_struck->id = $data_keranjang->struck_id;
           $req_struck->total_harga_dibayar = $total_all_price_base_struck_id;
        
           $cek_struck_in_kasir_exsis = $this->repository->getAllKeranjangByIdKasir($data_keranjang->struck_id);
           if (count($cek_struck_in_kasir_exsis) < 1) {
               //$this->repo_struck->updateStatusStruck($data_keranjang->struck_id,4);
               $this->repo_struck->deleteStruckByIdStruck($data_keranjang->struck_id);
           }else{
               $this->repo_struck->updateStruckPlusMins1($req_struck);
           }                                                       
           DB::commit();
         
        } catch (\Exception $e) {
            DB::rollBack();
            $save_keranjang =  false;
        }
        return $save_keranjang;
       

    }

    public function CreateKeranjangServiceById($request)
    {
        $validated = Validator::make($request->all(),[
            'struck_id' => 'required|exists:new_strucks,id_struck',
            'product_jual_id' => 'required|exists:product_juals,id_product_jual',
            'status' => 'required|integer',
            'jumlah_item_dibeli' => 'integer|nullable'
        ]);

        if ($validated->fails()) {
            return $validated->errors();
        }

        $cekDataStruck = $this->repo_struck->getStruckById($request->struck_id);
        if ($cekDataStruck->status == 4) {
            $msg_err = ['status_struck' => 'id struck '.$request->struck_id. ' tidak dapat digunakan, generate struck baru'];
           return $msg_err;
        }

        $find_data_product_jual = $this->repo_product_jual->getProductJualById($request->product_jual_id);
        //cek stock yang ada dengan yang akan dibeli pelanggan
        if ($find_data_product_jual->productName->is_kg === 1) {
            $stock_gudang = $find_data_product_jual->productName->total_kg;
        }else{
            $stock_gudang = $find_data_product_jual->productName->pcs;
        }
        
        if ((int) $request->jumlah_item_dibeli + 1 > (int) $stock_gudang) {
            $msg_err = ['jumlah_item_dibeli' => 'stock tidak mencukupi, stock digudang ada '.$stock_gudang];
            return $msg_err;
        }
        //jumlah jumlah_item_dibeli = null,  ambil dari start_kg 
        $cek_jumlah_item_dibeli = empty($request->jumlah_item_dibeli) ? 1 : (int) $request->jumlah_item_dibeli;
        $request->jumlah_item_dibeli = $cek_jumlah_item_dibeli;
       
        $find_data_struck = $this->repo_struck->getStruckById($request->struck_id);
        $total_price_item = (int)$find_data_product_jual->price_sell * (int)$request->jumlah_item_dibeli;
        $satuan_item_jual = $find_data_product_jual->satuan_berat_item;
       
        //keranjang
        $request->total_harga_item = $total_price_item;
        $request->harga_tiap_item = $find_data_product_jual->price_sell;
        $request->total_decimal_buy_for_stock = 1 * $satuan_item_jual;
       
        //cek if product & struc id eksis
        $data_keranjang = $this->repository->CekIdProductAndSturckIdInKeranjang($request->product_jual_id,$request->struck_id);
        
       
        DB::beginTransaction();
        //cek transaction, 1 product multi vairant more then stock in wherehouse
        $cek_same_produc1_transac = $this->repository->queryCheck1TransationSameProduct($request->struck_id);
        if ($cek_same_produc1_transac != null ) {
            $data_parent_product = $this->repo_product->getProductById($find_data_product_jual->product_id);
            if ($data_parent_product->is_kg == 1) {
                $stock_decimal_after_add = $this->repository->queryCheck1TransationSumStockProduct($request->struck_id,$data_parent_product->id_product);
                $final_total = $stock_decimal_after_add[0]->total + ($request->jumlah_item_dibeli * $satuan_item_jual);
                 if ($final_total > $data_parent_product->total_kg) {
                     $msg_err = ['msg' =>'gagal 1 transaksi ada 1 barang dengan variant berbeda | total : '.$final_total .'', "msg_detail"=> " gagal jumlah barang yang dibeli melebihi stock yang ada"];
                     return $msg_err;
                 }
            }
        }
         //cek transaction, 1 product multi vairant more then stock in wherehouse
        try{
            if ($data_keranjang != NULL) {
                
                
                //update data keranjang
                $id_keranjang_kasir = $data_keranjang->id_keranjang_kasir;
                $total_decimal_ =  (($data_keranjang->jumlah_item_dibeli + $request->jumlah_item_dibeli) * $satuan_item_jual);
                
                $data_add_keranjang = $this->repository->Add1JumlahKerajang($id_keranjang_kasir,
                                                    (int) $data_keranjang->jumlah_item_dibeli + (int) $request->jumlah_item_dibeli,
                                                    (int) $data_keranjang->total_harga_item + ($data_keranjang->harga_tiap_item * $request->jumlah_item_dibeli),
                                                     $total_decimal_);

            }else{
                $request->id_keranjang_kasir = cek_last_id_keranjang_kasir();// kalau memperlambat bisa dihpus                
                $request->total_decimal_buy_for_stock = $request->jumlah_item_dibeli * $satuan_item_jual;
                $data_add_keranjang = $this->repository->addKeranjang($request);
            }
            
            if ((int)$find_data_struck->total_harga_dibayar > 0) {
                $must_pay = $this->repository->getAllTotalPriceMustPayByIdStruck($request->struck_id);
                $data_update_struck = $this->repo_struck->updateStatusNewStruck($request->struck_id,$must_pay,1);
            }else{
                $data_update_struck = $this->repo_struck->updateStatusNewStruck($request->struck_id,$total_price_item,1);
            }
            DB::commit();
            return $data_add_keranjang;//response bisa diganti paggil api get-view-struck-barang
        }catch(\Exception $e) {
            DB::rollBack();
            return false;
        }

    }

    public function DeleteKeranjangServiceById($request)
    {
        $validated = Validator::make($request->all(),[
            'id_keranjang_kasir' => 'required|exists:keranjang_kasirs,id_keranjang_kasir',
        ]);

        if ($validated->fails()) {
            return $validated->errors();
        }

        $get_keranjang = $this->repository->getKeranjangById($request->id_keranjang_kasir);
        $price_delete = $get_keranjang->total_harga_item;
        $must_pay = $this->repository->getAllTotalPriceMustPayByIdStruck($get_keranjang->struck_id);
        //save db
        DB::beginTransaction();
        try {
            $delete_keranjang = $this->repository->DeleteKeranjangStruck($request->id_keranjang_kasir);
            $cek_struck_in_kasir_exsis = $this->repository->getAllKeranjangByIdKasir($get_keranjang->struck_id);
            if (count($cek_struck_in_kasir_exsis) < 1) {
                $this->repo_struck->deleteStruckByIdStruck($get_keranjang->struck_id);
                $update_total_price_struck = null;
            }else{
                $update_total_price_struck = $this->repo_struck->updateStatusNewStruck($get_keranjang->struck_id,$must_pay-$price_delete,1);
            }
            DB::commit();
            return $update_total_price_struck;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
        
    }

}