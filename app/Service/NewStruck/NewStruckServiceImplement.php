<?php

namespace App\Service\NewStruck;

use App\Repository\NewStruck\NewStruckRepository;
use Illuminate\Support\Facades\Validator;

class NewStruckServiceImplement implements NewStruckService{

    protected $repository;
    public function __construct(NewStruckRepository $repository)
    {
        $this->repository = $repository;
    }

    public function generateNewStruckService()
    {
        $req_id_struck = cek_last_id_struck();
        $data = $this->repository->generateNewStruck($req_id_struck);
        return $data;
    }

    public function getStruckByIdService($request)
    {
        
    }

    public function UpdateDataStruckService($request)
    {
        
    }

    public function getProductByIdStruckService($request)
    {
        $validated = Validator::make($request->all(),[
            'id_struck' => 'required|exists:new_strucks,id_struck'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $total_bayar = $this->repository->getStruckById($request->id_struck)->total_harga_dibayar;
        $list = $this->repository->getProductByIdStruck($request->id_struck);
        $data = array('list'=> $list, 'total_bayar'=>$total_bayar);
        return $data;
    }

}