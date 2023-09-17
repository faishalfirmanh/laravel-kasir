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

    public function GetAllTokoServicePaginateAndSearch($request)
    {
        
        $validated = Validator::make($request->all(),[
            'limit' => 'required|integer',
            'page' => 'integer|nullable',
            'keyword' => 'string|nullable'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        if (empty($request->page)) {
            $request->page = 1;
        }

        $data = $this->repository->getAllDataTokoPaginateWithSearch($request);

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

    public function GetTokoByNameService($req){
        $validated = Validator::make($req->all(),[
            'nama_toko' => 'string|exists:tokos,nama_toko'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $name = trim(strtolower($req->nama_toko));
        $get_data = $this->repository->getTokoByName($name);
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
        $cek  = $this->repository->getTokoById($request->id_toko)->userRelasiToko;
        
        if (count($cek) > 0) {
            return [
                'msg' => 'gagal hapus',
                'id_toko' => 'id toko '. $request->id_toko . ' ada relasi (digunakan user lain)'];
        }

        $delete = $this->repository->deleteToko($request->id_toko);
        return $delete;
    }

}