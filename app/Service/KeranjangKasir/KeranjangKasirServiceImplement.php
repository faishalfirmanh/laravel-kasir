<?php

namespace App\Service\KeranjangKasir;

use App\Repository\KeranjangKasir\KeranjangKasirRepository;
use Illuminate\Support\Facades\Validator;
class KeranjangKasirServiceImplement implements KeranjangKasirService{

    protected $repository;
    public function __construct(KeranjangKasirRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getKerjangServiceById($request)
    {
        $validated = Validator::make($request->all(),[
            'id_keranjang_kasir' => 'required|exists:keranjang_kasirs,id_keranjang_kasir'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
       
        $data = $this->repository->getKeranjangById($request->id_keranjang_kasir);
        return $data;
    }

    public function CreateKeranjangServiceById($request)
    {

    }

    

}