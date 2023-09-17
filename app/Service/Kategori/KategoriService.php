<?php

namespace App\Service\Kategori;

interface KategoriService{
    public function getAllKategoryService($request);
    public function getAllKategroyServiceNoPaginate($request);
    public function getKategoryByIdService($id);//
    public function getKategoryByNameService($req);//
    public function getKategoriByidServiceFix($request);
    public function postKategoriService($data,$id);
    public function deleteKategoriService($id);
}