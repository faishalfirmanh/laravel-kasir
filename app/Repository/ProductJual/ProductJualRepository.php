<?php

namespace App\Repository\ProductJual;

interface ProductJualRepository{
    public function getAllProduct();
    public function getAllProductPaginate($limit,$keyword);
    public function getProductJualById($id);
    public function postProductJual($data,$id);
    public function deleteProductJual($id);
}