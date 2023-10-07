<?php

namespace App\Import;

use App\Models\Product as ProdcutModels;
use App\Models\ProductJual;
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
            $nama_barang = strip_tags(strtolower($row['name_barang']));
            $cabang_toko = strip_tags(strtolower($row['name_toko']));
            $kategori = strip_tags(strtolower($row['kategori']));
            $harga_beli = strip_tags(strtolower($row['harga_beli']));
            $satuan_kg = strip_tags(strtolower($row['is_kg']));
            $stock =  strip_tags(strtolower($row['total_stock']));
            $expired =  strip_tags(strtolower($row['expired']));

            $item_berat =  strip_tags(strtolower($row['satuan_berat_item']));
            $harga_jual =  strip_tags(strtolower($row['harga_jual']));
            $subnmae =  strip_tags(strtolower($row['subname']));

            if (isset($item_berat) && $item_berat !== "") {
                if (!is_numeric($item_berat)) {
                    echo "error, satuan berat item ".$nama_barang." harus berupa angka";
                    die();
                }
            }

            if (isset($harga_jual) && $harga_jual !== "") {
                if (!is_numeric($harga_jual)) {
                    echo "error, harga jual ". $nama_barang ." harus berupa angka";
                    die();
                }
            }

            if ($satuan_kg !== "0" && $satuan_kg !== "1") {
                $i = 400;
                echo "error, input is kg harus 0 atau 1 "." product name ".$nama_barang;
                die();
            }
            
            $cek_toko =  cek_toko_by_name($cabang_toko);
            $cek_kategori = cek_kategory_by_name($kategori);
            $cek_prd_name = cek_product_by_name($nama_barang);

            if ($cek_toko == null) {
                echo "error, nama toko ".$cabang_toko." tidak ada";
                die();
            }

            if ($cek_kategori == null) {
                echo "error, nama kategpri ".$nama_barang ." tidak ada";
                die();
            }

            if ($cek_prd_name != null) {
                echo "error, nama prodicut ". $nama_barang." sudah ada";
                die();
            }
            $cek_input_stock = $satuan_kg == 1 ? 'total_kg' : 'pcs';
            // try {
                $prod  =  ProdcutModels::create([
                            'nama_product' => $nama_barang,
                            'toko_id' =>  $cek_toko->id_toko,
                            'kategori_id' => $cek_kategori->id_kategori,
                            'harga_beli' =>  $harga_beli,
                            'is_kg' => $satuan_kg,
                            $cek_input_stock =>  $stock,
                            'expired' =>  $expired
                        ]);
                
                if ($harga_jual !== "" &&  $item_berat !==  "") {

                    if ($harga_jual < $prod->fresh()->harga_beli ) {
                        echo "error, harga beli ".$prod->fresh()->nama_product ." lebih dari harga jual";
                        die();
                    }

                    ProductJual::create([
                        'product_id' => $prod->fresh()->id_product,
                        'subname' => $subnmae,
                        'satuan_berat_item' => $item_berat, 
                        'price_sell' => $harga_jual
                    ]);
                 }
               
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