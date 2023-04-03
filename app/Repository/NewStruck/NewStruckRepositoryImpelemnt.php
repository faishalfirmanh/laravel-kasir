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

    public function updateStatusNewStruck($id, $request)
    {

    }

   
}