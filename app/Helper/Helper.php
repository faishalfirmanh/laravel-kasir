<?php

use App\Models\KeranjangKasir;
use App\Models\NewStruck;
use App\Models\Product;
use App\Models\ProductJual;
use App\Models\Kategori;
use App\Models\Toko;
use Illuminate\Support\Facades\DB;


if (!function_exists('cek_toko_by_name')) {
    function cek_toko_by_name($name){
        $name_val = trim(strtolower($name));
        $get = Toko::query()->where('nama_toko',$name_val)->first();
        return $get;
    }
}

if (!function_exists('cek_kategory_by_name')) {
    function cek_kategory_by_name($name){
        $name_val = trim(strtolower($name));
        $get = Kategori::query()->where('nama_kategori',$name_val)->first();
        return $get;
    }
}

if (!function_exists('cek_product_by_name')) {
    function cek_product_by_name($name){
        $name_val = trim(strtolower($name));
        $get = Product::query()->where('nama_product',$name_val)->first();
        return $get;
    }
}

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
            $model->pcs = null;
        }else{
            $model->pcs = $input->pcs;
            $model->total_kg = null;
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

if (!function_exists('cek_last_id_keranjang_kasir')) {
    function cek_last_id_keranjang_kasir(){
        $data = KeranjangKasir::query()->limit(1)->orderBy('id_keranjang_kasir',"DESC")->get();
        if (count($data) > 0) {
            $l = [];
            foreach ($data as $key => $value) {
                array_push($l,$value->id_keranjang_kasir);
            }
            $cek  = intval($l[0])+1;
        }else{
            $cek = 1;
        }
        return $cek;
    }
}

if (!function_exists('cekPriceTotalStruck')) {
    function cekPriceTotalStruck($id_struck){
        $data = NewStruck::query()->where('id_struck',$id_struck)->first();
       if ($data != NULL) {
            return $data;
       }else{
            return null;
       } 
    }
}

if (!function_exists('getFirstProductById')) {
    function getFirstProductById($id_product){
       $data = Product::query()->where('id_product',$id_product)->first();
       if ($data != NULL) {
            return $data;
       }else{
            return null;
       } 
    }
}

if (!function_exists('getAllProductJaulByProductId')) {
    function getAllProductJaulByProductId($id_product){
       $data = ProductJual::query()->where('product_id',$id_product)->get();
       if ($data != NULL) {
            return $data;
       }else{
            return null;
       } 
    }
}

if (!function_exists('getAllProductJaulById')) {
    function getAllProductJaulById($id){
       $data = ProductJual::query()->where('id_product_jual',$id)->get();
       if ($data != NULL) {
            return $data;
       }else{
            return null;
       } 
    }
}

if (!function_exists('getAllKeranjangByStruckId')) {
    function getAllKeranjangByStruckId($struck_id){
       $data = KeranjangKasir::query()->where('struck_id',$struck_id)->get();
       if ($data != NULL) {
            return $data;
       }else{
            return null;
       } 
    }
}

if (!function_exists('cekCountAllData')) {
    function cekCountAllData($name_table){
        $data = $name_table->get();
        return $data->count();
    }
}

if (!function_exists('cekCountAllDataSearch')) {
    function cekCoutAllDataSearch($name_table, $column, $keyword){
        $data = $name_table->where($column,'like','%'.$keyword .'%')->get();
        return $data->count();
    }
}

if (!function_exists('cekCountTransaction')) { //date  = 'yyyy-mm-dd', keuntungan yang sudah fix status new struck = 2
    function cekCountTransaction($toko_id, $date){
        $result_data = DB::select('
        select 
            count(*) as "total_transaksi",
            sum(pembeli_bayar) as "uang_masuk", 
            sum(keuntungan_bersih) as "keuntungan_bersih",
            DATE(created_at) as "tanggal"
        from new_strucks
        where id_struck in
        (
            select ns.id_struck
            FROM `new_strucks` ns 
            join keranjang_kasirs ks on ks.struck_id = ns.id_struck 
            join product_juals pj on pj.id_product_jual = ks.product_jual_id 
            join products prd on prd.id_product = pj.product_id 
            join tokos on tokos.id_toko = prd.toko_id 
            where tokos.id_toko = '.$toko_id.' 
            and ns.status = 2
            and DATE(ns.created_at) = "'.$date.'"
            GROUP by ns.id_struck order by ns.id_struck desc
        )
        ');
        return $result_data;
    }
}

if (!function_exists('cek_last_id_struck_helper')) {
    function cek_last_id_struck_helper(){
        $data = NewStruck::query()->orderBy("id_struck","desc")->limit(1)->get();
        return $data;
    }
}

}