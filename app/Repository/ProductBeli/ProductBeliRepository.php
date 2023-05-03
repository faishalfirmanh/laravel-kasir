<?php

namespace App\Repository\ProductBeli;

interface ProductBeliRepository{
    public function getAllProductBeli($product_id);
    public function getProductBeliById($id_product_beli);
    public function saveProductBeli($id,$request);
    public function deleteProductBeli($id);
}