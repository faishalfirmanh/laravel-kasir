<?php

namespace App\Service\KeranjangKasir;

use App\Repository\KeranjangKasir\KeranjangKasirRepository;
use App\Repository\NewStruck\NewStruckRepository;
use App\Repository\ProductJual\ProductJualRepository;
use Illuminate\Support\Facades\Validator;
use stdClass;

class KeranjangKasirServiceImplement implements KeranjangKasirService{

    protected $repository;
    public function __construct(KeranjangKasirRepository $repository, 
                                ProductJualRepository $repo_product_jual,
                                NewStruckRepository $repo_struck)
    {
        $this->repository = $repository;
        $this->repo_product_jual = $repo_product_jual;
        $this->repo_struck = $repo_struck;
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
      
        
        if ($data_struck->status == 4) {
           $msg_err = ['status_struck' => 'id struck '.$data_keranjang->struck_id. ' tidak dapat digunakan, generate struck baru'];
           return $msg_err;
        }
        //get db
        //save db
        $update_keranjang = $this->repository->Add1JumlahKerajang($request->id_keranjang_kasir,
                                                                (int) $data_keranjang->jumlah_item_dibeli + 1,
                                                                (int) $data_keranjang->total_harga_item + $data_keranjang->harga_tiap_item);                         
        
        $total_product_each_item = $data_struck->total_harga_dibayar + $data_keranjang->harga_tiap_item; //harga yang harus diupdate pada data struck;   
        $req_struck = new stdClass();
        $req_struck->id = $data_keranjang->struck_id;
        $req_struck->total_harga_dibayar = $total_product_each_item;                                                        
        $update_struck = $this->repo_struck->updateStruckPlusMins1($req_struck);
        //save db
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
        $total_product_each_item = $data_struck->total_harga_dibayar - $data_keranjang->harga_tiap_item; //harga yang harus diupdate pada data struck;
        $total_dibeli_setelah_dikurangi = (int) $data_keranjang->jumlah_item_dibeli - 1;  
        if ($data_struck->status == 4) {
            $msg_err = ['status_struck' => 'id struck '.$data_keranjang->struck_id. ' tidak dapat digunakan, generate struck baru'];
           return $msg_err;
        }
        //get db
        //save db
        if ($total_dibeli_setelah_dikurangi < 1) {
             $this->repository->DeleteKeranjangStruck($request->id_keranjang_kasir);
             $save_keranjang = $this->repository->getKeranjangByStruckId($data_keranjang->struck_id);
        }else{
             $save_keranjang = $this->repository->Add1JumlahKerajang($request->id_keranjang_kasir,
                                                                     (int) $data_keranjang->jumlah_item_dibeli - 1,
                                                                     (int) $data_keranjang->total_harga_item - $data_keranjang->harga_tiap_item
                                                                    );      
        }
                           
        $req_struck = new stdClass();
        $req_struck->id = $data_keranjang->struck_id;
        $req_struck->total_harga_dibayar = $total_product_each_item;

        $cek_struck_in_kasir_exsis = $this->repository->getAllKeranjangByIdKasir($data_keranjang->struck_id);
        if (count($cek_struck_in_kasir_exsis) < 1) {
            //$this->repo_struck->updateStatusStruck($data_keranjang->struck_id,4);
            $this->repo_struck->deleteStruckByIdStruck($data_keranjang->struck_id);
        }else{
            $this->repo_struck->updateStruckPlusMins1($req_struck);
        }                                                       
        //save db
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
        //jumlah jumlah_item_dibeli = null,  ambil dari start_kg 
        $cek_jumlah_item_dibeli = empty($request->jumlah_item_dibeli) ? $find_data_product_jual->start_kg : (int) $request->jumlah_item_dibeli;
        $request->jumlah_item_dibeli = $cek_jumlah_item_dibeli;
       
        $find_data_struck = $this->repo_struck->getStruckById($request->struck_id);
        $total_price_item = (int)$find_data_product_jual->price_sell * (int)$request->jumlah_item_dibeli;
        //keranjang
        $request->total_harga_item = $total_price_item;
        $request->harga_tiap_item = $find_data_product_jual->price_sell;
        //cek if product & struc id eksis
        $data_keranjang = $this->repository->CekIdProductAndSturckIdInKeranjang($request->product_jual_id,$request->struck_id);
        
        $data_all_keranjang = $this->repository->getAllKeranjangByIdKasir($request->struck_id);
        foreach ($data_all_keranjang as $key => $value) {
            //validasi 1 transaksi hanya boleh 1 variant
            $product_exsis =  $this->repo_product_jual->getProductJualById($value->product_jual_id);
            if ($product_exsis->id_product_jual != $find_data_product_jual->id_product_jual) {
                if ($product_exsis->product_id == $find_data_product_jual->product_id) {
                    $msg_err = ['id_keranjang_kasir' => '1 transaksi hanya boleh 1 macam variant'];
                    return $msg_err;
                }
            }
        }
        
        //save to db
        if ($data_keranjang != NULL) {
            $id_keranjang_kasir = $data_keranjang->id_keranjang_kasir;
            $data_add_keranjang = $this->repository->Add1JumlahKerajang($id_keranjang_kasir,
                                                (int) $data_keranjang->jumlah_item_dibeli + (int) $request->jumlah_item_dibeli,
                                                (int) $data_keranjang->total_harga_item + ($data_keranjang->harga_tiap_item * $request->jumlah_item_dibeli));                         
        }else{
            $data_add_keranjang = $this->repository->addKeranjang($request);
        }
        
        if ((int)$find_data_struck->total_harga_dibayar > 0) {
            $must_pay = $this->repository->getAllTotalPriceMustPayByIdStruck($request->struck_id);
            $data_update_struck = $this->repo_struck->updateStatusNewStruck($request->struck_id,$must_pay,1);
        }else{
            $data_update_struck = $this->repo_struck->updateStatusNewStruck($request->struck_id,$total_price_item,1);
        }
       
        return $data_add_keranjang;//response bisa diganti paggil api get-view-struck-barang
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
        $delete_keranjang = $this->repository->DeleteKeranjangStruck($request->id_keranjang_kasir);
        $cek_struck_in_kasir_exsis = $this->repository->getAllKeranjangByIdKasir($get_keranjang->struck_id);
        if (count($cek_struck_in_kasir_exsis) < 1) {
            $this->repo_struck->deleteStruckByIdStruck($get_keranjang->struck_id);
            $update_total_price_struck = null;
        }else{
            $update_total_price_struck = $this->repo_struck->updateStatusNewStruck($get_keranjang->struck_id,$must_pay-$price_delete,1);
        }
        return $update_total_price_struck;
    }

}