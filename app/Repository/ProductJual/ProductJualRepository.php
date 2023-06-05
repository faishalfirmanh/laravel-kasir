<?php

namespace App\Repository\ProductJual;

interface ProductJualRepository{
    public function getAllProduct();
    public function getAllProductPaginate($limit,$keyword);
    public function getAllProductPriceSearch($keyword,$toko_id);
    public function getProductJualById($id);
    public function getProductJualByIdProduct($id);
    public function getProductJualByIdProducBeli($id_product_beli);
    public function postProductJual($data,$id);
    public function deleteProductJual($id);
}