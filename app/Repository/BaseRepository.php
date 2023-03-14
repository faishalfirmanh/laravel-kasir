<?php

namespace App\Repository;
use Illuminate\Database\Eloquent\Model;


class BaseRepository{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAllData(){

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