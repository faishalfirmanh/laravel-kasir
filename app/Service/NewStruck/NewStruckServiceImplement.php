<?php

namespace App\Service\NewStruck;

use App\Repository\KeranjangKasir\KeranjangKasirRepository;
use App\Repository\NewStruck\NewStruckRepository;
use Illuminate\Support\Facades\Validator;

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
        
        $save_db = $this->repository->updateInputPriceUserBayar($request->id_struck,2,$request->user_bayar,0);
        $update_status_keranjang = $this->repository_keranjang->UpdateStatusKeranjangByStruckId($request->id_struck,2);
        //get value price beli
        //isi value pada kolumn keuntungan bersih ditabel new strucks (price beli - price jual)
        //kurangi stock
      
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
        $total_bayar = $this->repository->getStruckById($request->id_struck)->total_harga_dibayar;
        $list = $this->repository->getProductByIdStruck($request->id_struck);
        $data = array('list'=> $list, 'total_bayar'=>$total_bayar);
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