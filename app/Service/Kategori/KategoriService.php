<?php

namespace App\Service\Kategori;

interface KategoriService{
    public function getAllKategoryService($request);
    public function getKategoryByIdService($id);
    public function postKategoriService($data,$id);
    public function deleteKategoriService($id);
}