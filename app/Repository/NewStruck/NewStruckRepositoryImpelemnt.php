<?php

namespace App\Repository\NewStruck;
use App\Models\NewStruck;

class NewStruckRepositoryImpelemnt implements NewStruckRepository{

    protected $model;
    public function __construct(NewStruck $model)
    {
        $this->model = $model;
    }

    public function getStruckById($id){
        $data = $this->model->find($id);
        return $data;
    }

    public function generateNewStruck($id_strukc)
    {
        $create = $this->model::create(['id_struck' => $id_strukc]);
        return $create;
    }

    public function updateStatusNewStruck($id, $total_harga_harus_dibayar,$status = 0, $pembeli_bayar =0)
    {

        $model = $this->model->query()->where('id_struck',$id)->first();
        $model->total_harga_dibayar = $total_harga_harus_dibayar;
        $model->pembeli_bayar = $pembeli_bayar;
        $model->kembalian = 0;
        $model->status = $status;
        $model->save();
        return $model;
        
    }

    public function updateStruckPlusMins1($req)
    {
        $model = $this->model->find($req->id)->first();
        $model->total_harga_dibayar = $req->total_harga_dibayar;
        $model->save();
        return $model->fresh();
    }

    public function getProductByIdStruck($id)
    {
    
        $data = $this->model
        ->select('keranjang_kasirs.id_keranjang_kasir','new_strucks.id_struck',
        'products.nama_product','products.is_kg','product_juals.start_kg','product_juals.end_kg','product_juals.id_product_jual',
        'keranjang_kasirs.harga_tiap_item','keranjang_kasirs.jumlah_item_dibeli','keranjang_kasirs.total_harga_item')
        ->join('keranjang_kasirs','new_strucks.id_struck','=','keranjang_kasirs.struck_id')
        ->join('product_juals','keranjang_kasirs.product_jual_id','=','product_juals.id_product_jual')
        ->join('products','product_juals.product_id','=','products.id_product')
        ->where('keranjang_kasirs.struck_id',$id)
        ->get();
        return $data;
    }

   
}