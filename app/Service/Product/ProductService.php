<?php

namespace App\Service\Product;

interface ProductService{
    public function getAllProductNoPaginate();
    public function getAllProductService($request);
    public function getAllProductServicePriceSet($request);
    public function getAllProductServicePriceNotSet($request);
    public function getProductByIdService($id);
    public function getProductByIdServiceInput($id);
    public function postProductService($data,$id);
    public function deleteProductService($id);
    public function getTotalProductTerjualByIdProductService($request);
}