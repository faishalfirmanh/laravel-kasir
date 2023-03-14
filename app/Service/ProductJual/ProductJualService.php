<?php

namespace App\Service\ProductJual;

interface ProductJualService{
    public function getAllProductService($request);
    public function getProductByIdService($id);
    public function postProductJualService($request,$id);
    public function deleteProductService($id);
}