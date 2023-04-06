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
        $data = $this->model->find($id)->first();
        return $data;
    }

    public function generateNewStruck($id_strukc)
    {
        $create = $this->model::create(['id_struck' => $id_strukc]);
        return $create;
    }

    public function updateStatusNewStruck($id, $total_harga_harus_dibayar,$status = 0, $pembeli_bayar =0)
    {

        $model = $this->model->find($id)->first();
        $model->total_harga_dibayar = $total_harga_harus_dibayar;
        $model->pembeli_bayar = $pembeli_bayar;
        $model->kembalian = 0;
        $model->status = $status;
        $model->save();
        return $model->fresh();
        
    }

   
}