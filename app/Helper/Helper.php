<?php

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