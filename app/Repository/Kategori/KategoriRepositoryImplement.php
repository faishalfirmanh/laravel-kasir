<?php

namespace App\Repository\Kategori;

use App\Models\Kategori;

class KategoriRepositoryImplement implements KategoriRepository{

    protected $model;
    public function __construct(Kategori $model)
    {
        $this->model = $model;
    }

    public function getAllKategori(){
        $data = $this->model->get();
        return $data;
    }

    public function getAllKategoryPaginate($limit,$keyword)
    {
        if (!empty($keyword)) {
            $data = $this->model->where('nama_kategori','like','%'.$keyword .'%')
            ->limit($limit)->paginate($limit);
        }else{
            $data = $this->model->with(['productRelasiKategori'])->limit($limit)->paginate($limit);
        }
        return $data;
    }

    public function getKategoryById($id)
    {
        return $this->model->where('id_kategori',$id)->first();
    }

    public function postKategori($data,$id)
    {
        $model_save = $this->model;
        if ( intval($id) > 0 || $id != NULL) {
            $model_save = $this->model->where('id_kategori',$id)->first();
            $model_save->nama_kategori = strtolower($data->nama_kategori);
        }else{
            $model_save->nama_kategori = strtolower($data->nama_kategori);
        }
        $model_save->save();
        return $model_save->fresh();
    }

    public function deleteKategori($id)
    {
        $model = $this->model->find($id);
        return $model->delete();
    }
}