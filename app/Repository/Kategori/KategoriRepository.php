<?php

namespace App\Repository\Kategori;

interface KategoriRepository{
    public function getAllKategori();
    public function getAllKategoryPaginate($limit,$keyword);
    public function getAllDataPaginateWithSearch($request);
    public function getKategoryById($id);
    public function getKategoriByName($name);
    public function postKategori($data,$id);
    public function deleteKategori($id);
}