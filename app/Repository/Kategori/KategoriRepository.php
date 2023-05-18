<?php

namespace App\Repository\Kategori;

interface KategoriRepository{
    public function getAllKategori();
    public function getAllKategoryPaginate($limit,$keyword);
    public function getAllDataPaginateWithSearch($request);
    public function getCoutDataSearch($keyword);
    public function getCountAllData($request);
    public function getKategoryById($id);
    public function postKategori($data,$id);
    public function deleteKategori($id);
}