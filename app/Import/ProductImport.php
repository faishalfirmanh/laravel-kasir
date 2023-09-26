<?php

namespace App\Import;

use App\Models\Product as ProdcutModels;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ProductImport implements ToCollection, WithHeadingRow{

    
   /** belum bisa */
    

    public function collection(Collection $rows)
    {
       
        $i = 0;
        // DB::beginTransaction();
        $models = [];
        foreach ($rows as $row) 
        {
            $nama_barang = $row['name_barang'];
            $cabang_toko = $row['name_toko'];
            $kategori = $row['kategori'];
            $harga_beli = $row['harga_beli'];
            $satuan_kg = $row['is_kg'];
            $stock =  $row['total_stock'];
            $expired =  $row['expired'];

            if ($satuan_kg !== 0 && $satuan_kg !== 1) {
                $i = 400;
                echo "error, input is kg harus 0 atau 1";
                die();
            }
            
            $cek_toko =  cek_toko_by_name($cabang_toko);
            $cek_kategori = cek_kategory_by_name($kategori);
            $cek_prd_name = cek_product_by_name($nama_barang);

            if ($cek_toko == null) {
                echo "error, nama toko tidak ada";
                die();
            }

            if ($cek_kategori == null) {
                echo "error, nama kategpri tidak ada";
                die();
            }

            if ($cek_prd_name != null) {
                echo "error, nama prodicut sudah ada";
                die();
            }
            $cek_input_stock = $satuan_kg == 1 ? 'total_kg' : 'pcs';
            // try {
                  ProdcutModels::create([
                    'nama_product' => $nama_barang,
                    'toko_id' =>  $cek_toko->id_toko,
                    'kategori_id' => $cek_kategori->id_kategori,
                    'harga_beli' =>  $harga_beli,
                    'is_kg' => $satuan_kg,
                     $cek_input_stock =>  $stock,
                    'expired' =>  $expired
                 ]);
            // } catch (\Exception $e) {
            //     DB::rollBack();
            //     // $save_db = false;
            //     echo "roolbqlcc";
            // }
            // return $save_db;
        }
        // return $models;
    }
}