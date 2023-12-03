<?php

namespace App\Repository;

use App\Models\ProductBeli;
use Illuminate\Database\Eloquent\Model;


class BaseRepositoryDua{

   

    public function getAllData($modelNya,$where = array()){
        if (count($where) > 0) {
            $data = $modelNya->where($where)->get();
        }else{
            $data = $modelNya->get();
        }
        return $data;
    }

   

}