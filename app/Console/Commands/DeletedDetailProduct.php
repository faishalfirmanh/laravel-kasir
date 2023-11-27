<?php

namespace App\Console\Commands;

use App\Models\KeranjangKasir;
use App\Models\ProductBeli;
use App\Models\ProductJual;
use App\Models\Product;
use Illuminate\Console\Command;

class DeletedDetailProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete_prod {idProd}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'untuk hapus product, product_jual,product_beli, keranjang dan new_struck';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    

     public function getPorudctJualByIdProd($idProd)
     {
         if (Product::find($idProd) != NULL) {
             $productJual = ProductJual::query()->where('product_id',$idProd)->get();
             if (count($productJual) > 0) {
                 foreach ($productJual as $key => $value) {
                     if (KeranjangKasir::query()->where('product_jual_id',$value->id_product_jual)->first() != null) {
                        $this->deleteKeranjangBy($value->id_product_jual);
                     }
                 }
                 ProductJual::query()->where('product_id',$idProd)->delete();
             }
             $prodcutBeli = ProductBeli::query()->where('product_id',$idProd)->get();
             if (count($prodcutBeli) > 0) {
                 $this->deleteProductBeli($idProd);
             }
             return true;
         }else{
            return false;
         }
     }
 
     public function deleteKeranjangBy($productJual)
     {
         KeranjangKasir::where('product_jual_id',$productJual)->delete();
     }
 
     public function deleteProductBeli($idProd)
     {
         ProductBeli::where('product_id',$idProd)->delete();
     }
 
     public function deleteProduct($idProd)
     {
         $prd = Product::find($idProd);
         if ($prd != null) {
             $prd->delete();
             return true;
         }
         else{
            return false;
         }
     }

    public function handle()
    {
        $prod_id = $this->argument('idProd');
        try {
            $cek1 = $this->getPorudctJualByIdProd($prod_id);
            $cek2 = $this->deleteProduct($prod_id);
            if ($cek1 && $cek2) {
                $this->info("sukses hapus product " . $prod_id);
            }else{
                $this->error(" id product ".$prod_id ." tidak ada");
            }
            
          
        } catch (\Exception $e) {
            $this->error('gagal hapus product id ' .$prod_id . " exceptions");
        }
      
    }
}
