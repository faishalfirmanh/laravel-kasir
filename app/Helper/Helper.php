<?php

use App\Models\NewStruck;

if(!function_exists('getObject')){
    function getObject($data,$isIndex = null){//jika index bernilai 1
        if ($isIndex != NULL) {
            $to_ar = (array) $data;
            $val = [];
            foreach ($to_ar as $key => $value) {
                if (isset($value->current_page)) {
                    array_push($val,$value->current_page);
                }
                if (isset($value['id_kategori'])) {
                    array_push($val,$value['id_kategori']);
                }
                if (isset($value['nama_kategori'])) {
                    array_push($val,$value['nama_kategori']);
                }
            }
            return count($val);
        }else{
            return 0;
        }
       
       
    }
}

if (!function_exists('cek_is_kg')) {
    function cek_is_kg($isKg,$model,$input){
        if ($isKg == '1') {
            $model->total_kg =  $input->total_kg;
        }else{
            $model->pcs = $input->pcs;
        }
        return $model;
    }

if (!function_exists('cek_last_id_struck')) {
    function cek_last_id_struck(){
        $data = NewStruck::query()->limit(1)->orderBy('id_struck',"DESC")->get();
        if (count($data) > 0) {
            $l = [];
            foreach ($data as $key => $value) {
                array_push($l,$value->id_struck);
            }
            $cek  = intval($l[0])+1;
        }else{
            $cek = 1;
        }
        return $cek;
    }
}

}