<?php

namespace App\Repository\ProductJual;

use App\Models\ProductJual as ProductJualModel;
use App\Repository\ProductJual\ProductJualRepository;
use stdClass;


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

    public function getAllProductPriceSearch($keyword,$toko_id)
    {
       if (!empty($keyword)) {
            $data = $this->model
            ->select("*")
            ->join("products","product_juals.product_id","=","products.id_product")
            ->where("products.toko_id",$toko_id)
            ->where(function($query){
                $query->where('products.pcs', '>', 0);
                $query->orWhere('products.total_kg', '>', 0);
            })
            ->where("products.nama_product",'like','%'.strtolower($keyword).'%')
            ->get();
       }else{
            $data = $this->model
            ->select("*")
            ->join("products","product_juals.product_id","=","products.id_product")
            ->where("products.toko_id",$toko_id)
            ->where(function($query){
                $query->where('products.pcs', '>', 0);
                $query->orWhere('products.total_kg', '>', 0);
            })
            ->get();
       }
        $data_val = [];
        foreach ($data as $key) {
            $cek_kg_or_pcs = $key->is_kg == '0' ? 'pcs' : 'kg';
            $coll = new stdClass();
            $coll->idProduct = $key->id_product;
            $coll->id_product_jual = $key->id_product_jual;
            $coll->nama_product = $key->nama_product." | ".$key->start_kg."-".$key->end_kg." ".$cek_kg_or_pcs .' | '.number_format($key->price_sell);
            $coll->harga_jual = $key->price_sell;
            array_push($data_val,$coll);
        }
        return $data_val;
    }

    public function getProductJualById($id)
    {
        //tambah with('namafungsimode') kalau ingin menampilkan data yg berhubungan
        $data = $this->model->where('id_product_jual',$id)->first();
        return $data;
    }

    public function getProductJualByIdProduct($id)
    {
        $data = $this->model->where('product_id',$id)->with(['productName','productBeliKulak'])->get();
        return $data;
    }


    public function postProductJual($data,$id)
    {
        $model_save = $this->model;
        $input_product_beli_custom = !empty($data->product_beli_id) ? $data->product_beli_id : null;
        if ( intval($id) > 0 || $id != NULL) {
            $model_save = $this->model->where('id_product_jual',$id)->first();
            $model_save->product_id = $data->product_id;
            $model_save->start_kg = $data->start_kg;
            $model_save->end_kg =$data->end_kg;
            $model_save->product_beli_id = $input_product_beli_custom;
            $model_save->price_sell = $data->price_sell;
        }else{
            $model_save->product_id = $data->product_id;
            $model_save->start_kg = $data->start_kg;
            $model_save->end_kg = $data->end_kg;
            $model_save->product_beli_id = $input_product_beli_custom;
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

    public function getProductJualByIdProducBeli($id_product_beli){
        $data = $this->model->where('product_beli_id',$id_product_beli)->first();
        return $data;
    }
}