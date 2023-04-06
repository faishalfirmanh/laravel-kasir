<?php

namespace App\Repository\KeranjangKasir;

interface KeranjangKasirRepository{
    public function getKeranjangById($id);
    public function addKeranjang($request);
    public function UpdateKeranjang($request,$id);
    public function Add1JumlahKerajang($id);
    public function ReduceJumlahKerajang($id);
    public function getAllTotalPriceMustPayByIdStruck($idStrck);//total harga semua yg harus dibayar
}