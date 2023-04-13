<?php

namespace App\Repository\KeranjangKasir;
use App\Models\KeranjangKasir;
use Illuminate\Support\Facades\DB;

class KeranjangKasirRepositoryImplement implements KeranjangKasirRepository{

    protected $model;
    public function __construct(KeranjangKasir $model)
    {
        $this->model = $model;
    }

    public function getKeranjangById($id)
    {
        $data = $this->model->where('id_keranjang_kasir', $id)->first();
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
        return $modal_save->fresh();
    }

    public function UpdateKeranjang($request, $id)
    {
        
    }

    public function Add1JumlahKerajang($id,$item_dibeli,$total_harga_item)
    {
        $modal_save = $this->model->query()->where('id_keranjang_kasir',$id)->first();
        $modal_save->jumlah_item_dibeli = $item_dibeli;
        $modal_save->total_harga_item = $total_harga_item;
        $modal_save->save();
        return $modal_save->fresh();
    }

    public function Reduce1JumlahKerajang($id,$item_dibeli,$total_harga_item)
    {
        
    }

    public function getAllTotalPriceMustPayByIdStruck($idStruck)
    {
        $data = $this->model->where('struck_id', $idStruck)->sum('total_harga_item');
        return $data;
    }

}