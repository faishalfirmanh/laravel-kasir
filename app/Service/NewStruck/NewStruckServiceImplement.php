<?php

namespace App\Service\NewStruck;

use App\Repository\KeranjangKasir\KeranjangKasirRepository;
use App\Repository\NewStruck\NewStruckRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class NewStruckServiceImplement implements NewStruckService{

    protected $repository;
    public function __construct(NewStruckRepository $repository, KeranjangKasirRepository $repository_keranjang)
    {
        $this->repository = $repository;
        $this->repository_keranjang = $repository_keranjang;
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

    public function UpdateDataStruckService($request)
    {  
        $cek_data = cekPriceTotalStruck($request->id_struck) != NULL ? 
                    cekPriceTotalStruck($request->id_struck)->total_harga_dibayar : 0;
        $validated = Validator::make($request->all(),[
            'id_struck' => 'required|exists:new_strucks,id_struck',
            'user_bayar' =>  'required|gt:'.$cek_data,
        ]);

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
        
            //get value price beli->ok, ubah price beli cek kondisi perhitungan price beli custom ok
            //`1. jika di tabel product_juals product_beli_id null, deefault(ambil product->kolom hargq beli)
            // 2. jika di taqbel product_juals product_beli_id != null, ambil relasi (produc_beli kolom harga beli custom)
            //isi value pada kolumn keuntungan bersih ditabel new strucks (price beli - price jual)->ok
            //kurangi stock
            DB::commit(); 
            return $save_db;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;

        }
       
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
        $data = array('list'=> $list, 
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

}