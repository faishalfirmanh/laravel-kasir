<?php

namespace App\Service\Product;

interface ProductService{
    public function getAllProductNoPaginate();
    public function getAllProductService($request);
    public function getProductByIdService($id);
    public function postProductService($data,$id);
    public function deleteProductService($id);
}