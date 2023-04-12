<?php

namespace App\Repository\NewStruck;


interface NewStruckRepository{
    public function getStruckById($id);
    public function generateNewStruck($request);
    public function updateStatusNewStruck($id,$total_harga_harus_dibayar,$status = 0, $pembeli_bayar =0);

    public function getProductByIdStruck($id);
}