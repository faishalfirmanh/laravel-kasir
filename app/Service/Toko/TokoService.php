<?php

namespace App\Service\Toko;

interface TokoService{
    public function PostTokoService($request,$id);
    public function DeleteTokoService($id);
    public function GetAllTokoService($request);
    public function GetAllTokoServicePaginateAndSearch($request);
    public function GetTokoByIdService($id);
    public function GetTokoByNameService($name);
}