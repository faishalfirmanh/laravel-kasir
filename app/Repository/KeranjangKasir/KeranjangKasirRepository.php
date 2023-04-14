<?php

namespace App\Repository\KeranjangKasir;

interface KeranjangKasirRepository{
    public function getKeranjangById($id);
    public function addKeranjang($request);
    public function UpdateKeranjang($request,$id);
    public function CekIdProductAndSturckIdInKeranjang($id_product,$struck_id);
    public function Add1JumlahKerajang($id,$item_dibeli,$total_harga_item);
    public function Reduce1JumlahKerajang($id,$item_dibeli,$total_harga_item);
    public function getAllTotalPriceMustPayByIdStruck($idStrck);//total harga semua yg harus dibayar
}