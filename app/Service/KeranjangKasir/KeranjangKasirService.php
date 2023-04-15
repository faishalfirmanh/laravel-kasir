<?php

namespace App\Service\KeranjangKasir;

interface KeranjangKasirService{
  public function getKerjangServiceById($request);
  public function CreateKeranjangServiceById($request);
  public function DeleteKeranjangServiceById($request);
  public function Add1ProductKeranjangServiceById($request);
  public function Remove1ProductKeranjangServiceById($request);
}