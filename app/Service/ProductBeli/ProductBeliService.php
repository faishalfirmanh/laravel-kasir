<?php

namespace App\Service\ProductBeli;

interface ProductBeliService{
    public function getAllProductBeliByIdProductService($request);
    public function getAllProductBeliNoSetService($request);
    public function getProductBeliServiceById($request);
    public function saveProductBeliService($request);
    public function deleteProductBeliService($request);
}