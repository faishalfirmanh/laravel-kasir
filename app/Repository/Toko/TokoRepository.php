<?php

namespace App\Repository\Toko;

interface TokoRepository{
    public function getAllToko();
    public function getAllTokoPaginate($limit,$keyword);
    public function getAllDataTokoPaginateWithSearch($requst);
    public function getTokoById($id);
    public function postToko($data,$id);
    public function deleteToko($id);
}