<?php

namespace App\Service\ProductJual;

interface ProductJualService{
    public function getAllProductService($request);
    public function getProductJualByIdService($id);
    public function getProductJualByIdProductService($request);
    public function postProductJualService($request,$id);
    public function deleteProductJualService($id);
}