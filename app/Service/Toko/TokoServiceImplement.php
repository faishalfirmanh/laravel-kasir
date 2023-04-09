<?php

namespace App\Service\Toko;
use Illuminate\Support\Facades\Validator;
use App\Repository\Toko\TokoRepository;

class TokoServiceImplement implements TokoService{

    protected $repository;
    public function __construct(TokoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function GetAllTokoService($request)
    {
        $data = $this->repository->getAllToko();
        return $data;
    }

    public function GetTokoByIdService($request)
    {
        $validated = Validator::make($request->all(),[
            'id_toko' => 'string|exists:tokos,id_toko'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $get_data = $this->repository->getTokoById($request->id_toko);
        return  $get_data;
    }

    public function PostTokoService($request, $id)
    {
        if ($id > 0) {
            $cek = $this->repository->getTokoById($id);
            if ($cek != NULL) {
                $cek_name = $cek->nama_toko == $request->nama_toko ? '' : 'unique:tokos,nama_toko';
            }else{
                $cek_name = 'unique:tokos,nama_toko';
            }
        }else{
              $cek_name = 'unique:tokos,nama_toko';
        }

        $validated = Validator::make($request->all(),[
            'id_toko' => 'integer|exists:tokos,id_toko',
            'nama_toko' => 'required|string|'.$cek_name
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $idnya = $request->id_toko;
        $post = $this->repository->postToko($request,$idnya);
        return  $post;
    }


    public function DeleteTokoService($request)
    {
        $validated = Validator::make($request->all(),[
            'id_toko' => 'integer|exists:tokos,id_toko',
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $delete = $this->repository->deleteToko($request->id_toko);
        return $delete;
    }

}