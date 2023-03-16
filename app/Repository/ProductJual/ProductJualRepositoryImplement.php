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

    public function getProductJualById($id)
    {
        //tambah with('namafungsimode') kalau ingin menampilkan data yg berhubungan
        $data = $this->model->where('id_product_jual',$id)->first();
        return $data;
    }

    public function postProductJual($data,$id)
    {
        $model_save = $this->model;
        if ( intval($id) > 0 || $id != NULL) {
            $model_save = $this->model->where('id_product_jual',$id)->first();
            $model_save->product_id = $data->product_id;
            $model_save->start_kg = $data->start_kg;
            $model_save->end_kg =$data->end_kg;
            $model_save->price_sell = $data->price_sell;
        }else{
            $model_save->product_id = $data->product_id;
            $model_save->start_kg = $data->start_kg;
            $model_save->end_kg = $data->end_kg;
            $model_save->price_sell = $data->price_sell;
        }
        $model_save->save();
        return $model_save->fresh();
    }

    public function deleteProductJual($id)
    {
        $model = $this->model->find($id);
        return $model->delete();
    }
}