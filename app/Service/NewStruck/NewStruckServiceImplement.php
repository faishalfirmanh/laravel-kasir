<?php

namespace App\Service\NewStruck;

use App\Repository\NewStruck\NewStruckRepository;

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

}