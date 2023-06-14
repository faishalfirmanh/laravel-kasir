<?php

namespace App\Repository\KeranjangKasir;

interface KeranjangKasirRepository{
    public function getKeranjangById($id);
    public function getKeranjangByStruckId($id);
    public function getAllKeranjangById($id);
    public function getAllKeranjangByIdKasir($id_kasir);
    public function addKeranjang($request);
    public function UpdateKeranjang($request,$id);
    public function CekIdProductAndSturckIdInKeranjang($id_product,$struck_id);
    public function DeleteKeranjangStruck($id_keranajng);
    public function Add1JumlahKerajang($id,$item_dibeli,$total_harga_item);
    public function Reduce1JumlahKerajang($id,$item_dibeli,$total_harga_item);
    public function getAllTotalPriceMustPayByIdStruck($idStrck);//total harga semua yg harus dibayar
    public function UpdateStatusKeranjangByStruckId($id_struck,$status);
    public function getTotalPriceAllItemMustPayCount($id_struck); //menjumlahkan total harga semua barang base on id struck
}