<?php

namespace App\Repository;

use App\Models\ProductBeli;
use Illuminate\Database\Eloquent\Model;


class BaseRepository{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAllData($modelNya,$where = array()){
        if (count($where) > 0) {
            $data = $modelNya->where($where)->get();
        }else{
            $data = $modelNya->get();
        }
        return $data;
    }

    public function getAllDataPaginate(){

    }

    public function getDataById($id){
        return $this->model->findOrFail($id);
    }

    public function saveData($data,$id){

    }

    public function removeData($id){

    }

}