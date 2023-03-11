<?php

namespace App\Repository\Kategori;

interface KategoriRepository{
    public function getAllKategori();
    public function getAllKategoryPaginate($limit,$keyword);
    public function getKategoryById($id);
    public function postKategori($data,$id);
    public function deleteKategori($id);
}