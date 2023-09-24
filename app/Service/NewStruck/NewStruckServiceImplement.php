<?php

namespace App\Service\NewStruck;

use App\Repository\KeranjangKasir\KeranjangKasirRepository;
use App\Repository\NewStruck\NewStruckRepository;
use App\Repository\Product\ProductRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class NewStruckServiceImplement implements NewStruckService{

    protected $repository;
    public function __construct(NewStruckRepository $repository, 
                                KeranjangKasirRepository $repository_keranjang,
                                ProductRepository $repository_product)
    {
        $this->repository = $repository;
        $this->repository_keranjang = $repository_keranjang;
        $this->repository_product = $repository_product;
    }

    public function generateNewStruckService()
    {
        $req_id_struck = cek_last_id_struck();
        $data = $this->repository->generateNewStruck($req_id_struck);
        return $data;
    }

    public function getStruckByIdService($request)
    {
        $validated = Validator::make($request->all(),[
            'id_struck' => 'required|exists:new_strucks,id_struck',
        ]);

        if ($validated->fails()) {
            return $validated->errors();
        }
        $get = $this->repository->getStruckById($request->id_struck);
        return $get;

    }

    public function getLastIdStruckService($request)
    {
        //$get_last_id = 
        $get = cek_last_id_struck_helper();// $this->repository->getStruckById($get_last_id);
        return $get;
    }

    //kurangi stock saat 2, input price user bayar,
    public function UpdateDataStruckService($request)
    {  
        $cek_data = cekPriceTotalStruck($request->id_struck) != NULL ? 
                    cekPriceTotalStruck($request->id_struck)->total_harga_dibayar : 0;
        $validated = Validator::make($request->all(),[
            'id_struck' => 'required|exists:new_strucks,id_struck',
            'user_bayar' =>  'required|gte:'.$cek_data,
        ]);
        /**gte = gether than equal atau lebih besar = */
        if ($validated->fails()) {
            return $validated->errors();
        }

        $cekDataStruck = $this->repository->getStruckById($request->id_struck);
        if ($cekDataStruck->status == 4) {
           $msg_status = ['status_struck' => 'id struck '.$request->id_struck. ' tidak dapat digunakan, generate struck baru'];
           return  $msg_status;
        }

        DB::beginTransaction();
        try {
            $update_status_keranjang = $this->repository_keranjang->UpdateStatusKeranjangByStruckId($request->id_struck,2);
            $get_keuntungan = $this->getKeuntunganByIdStruckService($request);
            $save_db = $this->repository->updateInputPriceUserBayar($request->id_struck,2,$request->user_bayar,$get_keuntungan['total_semua_keuntungan']);
            //get all product
            $get_all_keranjang = $this->repository_keranjang->getAllKeranjangByIdKasir($request->id_struck);
            foreach ($get_all_keranjang as $key => $value) {
                $total_buy = $value->total_decimal_buy_for_stock;//(int) $value->jumlah_item_dibeli;->yg dicomment sebelum decimal
                $stock_available = $value->getProduct[0]->is_kg === 1 ?
                    (int) $value->getProduct[0]->total_kg : 
                    (int) $value->getProduct[0]->pcs;
                //cek ketersediaan product tidak melebih,i stock yang ada
                if ($total_buy > $stock_available) {
                    $msg_status_error_stock = ['product' => $value->getProduct[0]->nama_product.' dibeli dengan jumlah '.$total_buy.' tidal mencukupi, stock yang ada '.$stock_available];
                    return  $msg_status_error_stock;
                }

                //kalau input user bayar dilakukan lagi (2 x submit)
                //tidak mengurangi product lagi, dengan kondisi ini mengizinkan edit (input ulang)
                if((int) $cekDataStruck->status !== 2){ 

                    $final_stock_afater_reduced = (int) $stock_available - $total_buy; //stock akhir
                    if ($value->getProduct[0]->is_kg === 1) { //update stock
                        $cek_same_produc1_transaction = $this->repository_keranjang->queryCheck1TransationSameProduct($request->id_struck);
                        $cek_double = $this->repository_keranjang->queryCheck1TransDobule($value->product_jual_id,$request->id_struck);
                        if (count($cek_double) > 0) {
                            $id_product_same = $cek_same_produc1_transaction->id_product;
                            $total_all_item_same_prod = $this->repository_keranjang->queryCheck1TransationSumStockProduct($id_product_same,$request->id_struck);
                            $total_all_same_item_buy = $total_all_item_same_prod[0]->total;
                            $final_stock_after_reduced_same_prd =  $stock_available - $total_all_same_item_buy;
                            //update yg 1 product variant banyak kg
                            $this->repository_product->updateStockKg($value->getProduct[0]->id_product,$final_stock_after_reduced_same_prd);
                        }else{
                             //update yg 1 product variant 1
                            $this->repository_product->updateStockKg($value->getProduct[0]->id_product,$final_stock_afater_reduced);
                        }
                       
                    }else{
                        $this->repository_product->updateStockPcs($value->getProduct[0]->id_product,$final_stock_afater_reduced);
                    }

                }
               
            }

        
            //get value price beli->ok, ubah price beli cek kondisi perhitungan price beli custom ok
            //`1. jika di tabel product_juals product_beli_id null, deefault(ambil product->kolom hargq beli)
            // 2. jika di taqbel product_juals product_beli_id != null, ambil relasi (produc_beli kolom harga beli custom)
            //isi value pada kolumn keuntungan bersih ditabel new strucks (price beli - price jual)->ok
            //kurangi stock
            DB::commit(); 
           
        } catch (\Exception $e) {
            DB::rollBack();
            $save_db = false;
        }
        return $save_db;
       
    }

    public function getProductByIdStruckService($request)
    {
        $validated = Validator::make($request->all(),[
            'id_struck' => 'required|exists:new_strucks,id_struck'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $get_data_struck = $this->repository->getStruckById($request->id_struck);
        $list = $this->repository->getProductByIdStruck($request->id_struck);
        $data = array('list'=> $list, /**timestamp dari mysql tidak bisa langsung ditampilkan pada php harus diconvert dulu */
                    'tanggal'=> date('M j Y g:i A', strtotime($get_data_struck->updated_at)),
                    'dibayar'=> number_format($get_data_struck->pembeli_bayar),
                    'total_harga'=>number_format($get_data_struck->total_harga_dibayar),
                    'kembalian'=>number_format($get_data_struck->kembalian));
        return $data;
    }

    public function getKeuntunganByIdStruckService($request)
    {
        $validated = Validator::make($request->all(),[
            'id_struck' => 'required|exists:new_strucks,id_struck'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $datail_keuntungan_tiap_product = $this->repository->QueryMySqlGetKeuntungan($request->id_struck);
        $val = array();
        foreach ($datail_keuntungan_tiap_product as $key => $value) {
            $keutungan = $value->TotalKeuntungan;
            array_push($val,$keutungan);
        }
        $counts = array_sum($val);
        return [
            'detail_keuntungan' => $datail_keuntungan_tiap_product,
            'total_semua_keuntungan' => $counts
        ];
    }

    public function getAllStruckTransactionService($request) //all laporan
    {
        $data = $this->repository->getAllStruckReport(2); //2 sudah transaksi
        return $data;
    }

    public function getAllStrukTransactionPaginateService($request)
    {
        $validated = Validator::make($request->all(),[
            'limit' => 'required|integer',
            'page' => 'integer|nullable',
            'keyword' => 'string|nullable'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        if (empty($request->page)) {
            $request->page = 1;
        }

        $data = $this->repository->getAllStruckReportPaginate($request);

        return $data;
    }

    public function getRangukumanDashboardService($request)
    {
        $validated = Validator::make($request->all(),[
            'toko_id' => 'nullable|exists:tokos,id_toko'
            // 'date' => 'integer|nullable',
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }

        if (empty($request->toko_id)) {
           $request->toko_id = $request->toko_id_from_middleware;
        }
       
        if (empty($request->tanggal)) {
           $request->tanggal = date('Y-m-d');
        }

        $data = $this->repository->getDashboardReport($request);

        return $data;
    }
}