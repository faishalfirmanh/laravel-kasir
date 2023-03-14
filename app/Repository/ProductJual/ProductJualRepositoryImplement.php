<?php

namespace App\Repository\ProductJual;

use App\Models\ProductJual as ProductJualModel;
use App\Repository\ProductJual\ProductJualRepository;

class ProductJualRepositoryImplement implements ProductJualRepository{

    protected $model;
    public function __construct(ProductJualModel $model)
    {
        $this->model = $model;
    }

    public function getAllProduct(){
        $data = $this->model->get();
        return $data;
    }

    public function getAllProductPaginate($limit,$keyword)
    {
        if (!empty($keyword)) {
            $data = $this->model->with("kategori")->where('nama_product','like','%'.$keyword .'%')
            ->limit($limit)->paginate($limit);
        }else{
            $data = $this->model->with("kategori")->limit($limit)->paginate($limit);
        }
        return $data;
    }

    public function getProductById($id)
    {
        $data = $this->model->with("kategori")
                    ->where('id_product',$id)
                    ->first();
        return $data;
    }

    public function postProduct($data,$id)
    {
        $model_save = $this->model;
        if ( intval($id) > 0 || $id != NULL) {
            $model_save = $this->model->where('id_product',$id)->first();
            $model_save->nama_product = strtolower($data->nama_product);
            $model_save->kategori_id = strtolower($data->kategori_id);
            $model_save->harga_beli = strtolower($data->harga_beli);
            $model_save->total_kg = strtolower($data->total_kg);
        }else{
            $model_save->nama_product = strtolower($data->nama_product);
            $model_save->kategori_id = strtolower($data->kategori_id);
            $model_save->harga_beli = strtolower($data->harga_beli);
            $model_save->total_kg = strtolower($data->total_kg);
        }
        $model_save->save();
        return $model_save->fresh();
    }

    public function deleteProduct($id)
    {
        $model = $this->model->find($id);
        return $model->delete();
    }
}