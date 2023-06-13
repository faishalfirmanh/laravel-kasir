<?php

namespace App\Repository\Product;

interface ProductRepository{
    public function getAllProduct();
    public function getAllProductPaginate($limit,$keyword);
    public function getAllProductJualPriceSet($limit,$keyword,$is_price_set);//1 ada, 0 tidak
    public function getProductById($id);
    public function postProduct($data,$id);
    public function updateStockKg($idPrd, $stockFinal);
    public function updateStockPcs($idPrd, $stockFinal);
    public function deleteProduct($id);
}