<?php

namespace App\Repository\KeranjangKasir;
use App\Models\KeranjangKasir;

class KeranjangKasirRepositoryImplement implements KeranjangKasirRepository{

    protected $model;
    public function __construct(KeranjangKasir $model)
    {
        $this->model = $model;
    }

    public function getKeranjangById($id)
    {
        $data = $this->model->find($id)->first();
        return $data;
    }

    public function addKeranjang($request)
    {
        $modal_save = $this->model;
        $modal_save->product_jual_id  = $request->product_jual_id;
        $modal_save->jumlah_item_dibeli = $request->jumlah_item_dibeli;
        $modal_save->harga_tiap_item = $request->harga_tiap_item;
        $modal_save->total_harga_item = $request->total_harga_item;
        $modal_save->status = 0;
        $modal_save->struck_id  = $request->struck_id;
        $modal_save->save();
        return $model_save->fresh();
    }

    public function UpdateKeranjang($request, $id)
    {
        
    }

    public function Add1JumlahKerajang($id)
    {
        
    }

    public function ReduceJumlahKerajang($id)
    {
        
    }

}