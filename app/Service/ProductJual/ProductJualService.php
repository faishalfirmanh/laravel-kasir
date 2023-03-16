<?php

namespace App\Service\ProductJual;

interface ProductJualService{
    public function getAllProductService($request);
    public function getProductJualByIdService($id);
    public function postProductJualService($request,$id);
    public function deleteProductJualService($id);
}