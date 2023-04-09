<?php

namespace App\Repository\Toko;

use App\Models\Toko;
class TokoRepositoryImplement implements TokoRepository{

    protected $model;
    public function __construct(Toko $model)
    {
        $this->model = $model;
    }


    public function getAllToko()
    {
        $data = $this->model->get();
        return $data;
    }

    public function getAllTokoPaginate($limit, $keyowrd)
    {
        if (!empty($keyword)) {
            $data = $this->model
            ->where('nama_toko','like','%'.$keyword .'%')
            ->limit($limit)->get();
        }else{
            $data = $this->model
            ->limit($limit)->paginate($limit);
        }
        return $data;
    }

    public function getTokoById($id)
    {
        $data = $this->model
        ->where('id_toko',$id)
        ->first();
        return $data;   
    }

    public function postToko($data, $id)
    {
        $model_save = $this->model;
        if ((int) $id > 0 || $id != NULL) {
           $model_save =$this->model->where('id_toko',$id)->first();
           $model_save->nama_toko = strtolower($data->nama_toko);
        }else{
           $model_save->nama_toko = strtolower($data->nama_toko);
        }
        $model_save->save();
        return $model_save->fresh();
    }

    public function deleteToko($id)
    {
        $model = $this->model->find($id);
        return $model->delete();
    }

}