<?php

namespace App\Import;


use App\Service\Kategori\KategoriService;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
class ProductImport implements ToCollection{

    
   /** belum bisa */
    

    public function collection(Collection $rows)
    {
       
        foreach ($rows as $row) 
        {
            $nama_barang = $row[0];
            $cabang_toko = $row[1];
            $kategori = $row[2];
            $harga_beli = $row[3];
            $satuan_kg = $row[4];
            $stock =  $row[5];
            $expired =  $row[6];

            //  var_dump($satuan_kg);
            if ($satuan_kg !== 0 || $satuan_kg !== 1) {
               return "input status is kg salah harus 1 atau 0";
               die();
            }else{
                echo "Sukses";
            }
            var_dump("nama barang  : ".$nama_barang . ":  ");
            var_dump($cabang_toko);
            var_dump($kategori);
            var_dump($harga_beli);
            var_dump($satuan_kg);
            var_dump($stock);
            var_dump($expired);
            
            $cek_toko =  cek_toko_by_name($cabang_toko);
            $cek_kategori = cek_kategory_by_name($kategori);
            $cek_prd_name = cek_product_by_name($nama_barang);



           

        }
    }
}