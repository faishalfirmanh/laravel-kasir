<?php

namespace App\Repository\Product;

interface ProductRepository{
    public function getAllProduct();
    public function getAllProductPaginate($limit,$keyword);
    public function getProductById($id);
    public function postProduct($data,$id);
    public function deleteProduct($id);
}