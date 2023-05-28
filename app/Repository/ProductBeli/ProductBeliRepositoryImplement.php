<?php

namespace App\Repository\ProductBeli;

use App\Models\ProductBeli;

class ProductBeliRepositoryImplement implements ProductBeliRepository{

    protected $model;
    public function __construct(ProductBeli $model)
    {
        $this->model = $model;
    }

    public function getAllProductBeli($product_id)
    {
        $data = $this->model->with(["getProduct",'getProductJual'])->where('product_id',$product_id)->get();
        return $data;
    }

    public function getProductBeliById($id_product_beli)
    {
        $data = $this->model->with("getProduct")->where('id_product_beli',$id_product_beli)->first();
        return $data;
    }

    public function saveProductBeli($id, $request)
    {
        $model_save = $this->model;
        if ( intval($id) > 0 || $id != NULL) {
            $model_save = $this->model->where('id_product_beli',$id)->first();
            $model_save->product_id = strtolower($request->product_id);
            $model_save->harga_beli_custom = strtolower($request->harga_beli_custom);
            $model_save->nama_product_variant = strtolower($request->nama_product_variant);
        }else{
            $model_save->product_id = strtolower($request->product_id);
            $model_save->harga_beli_custom = strtolower($request->harga_beli_custom);
            $model_save->nama_product_variant = strtolower($request->nama_product_variant);
        }
        $model_save->save();
        return $model_save->fresh();
    }

    public function deleteProductBeli($id)
    {
        $model = $this->model->find($id);
        return $model->delete();
    }
}