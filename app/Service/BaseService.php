<?php

namespace App\Service;

use App\Repository\BaseRepository;
use App\Repository\Kategori\KategoriRepo;
use Illuminate\Support\Facades\Validator;

class BaseService{

    public function __construct(BaseRepository $repo)
    {
       $this->repo = $repo;
    }

    public function list_all_service(){

    }

    public function list_paginate_service(){
        
    }
   
    public function save_service($req, $id){

    }

    public function remove_service($id){

    }

    public function detail_service($req,$columns,$table){
        $validated = Validator::make($req->all(),[//kategoris,id_kategori
            $columns[0] => 'required|integer|exists:'.$table.','.$columns[0]
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $req_id = strval($columns[0]);
        $id = $req->$req_id;
        $data = $this->repo->getDataById($id);
        return $data;
    }

}