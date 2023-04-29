<?php

namespace App\Repository\NewStruck;


interface NewStruckRepository{
    public function getStruckById($id);
    public function generateNewStruck($request);
    public function updateStatusNewStruck($id,$total_harga_harus_dibayar,$status = 0, $pembeli_bayar =0);

    public function getProductByIdStruck($id);
    public function updateStruckPlusMins1($request);
    public function updateInputPriceUserBayar($id, $status = 0, $pembeli_bayar = 0, $keuntungan_bersih = 0);

    public function QueryMySqlGetKeuntungan($id_struck);
    public function updateStatusStruck($id_struck, $status);
    public function deleteStruckByIdStruck($id_struck);
}