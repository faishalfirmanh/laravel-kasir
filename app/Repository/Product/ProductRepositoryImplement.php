<?php

namespace App\Repository\Product;

use App\Models\Product;
use App\Repository\Product\ProductRepository;
use Illuminate\Support\Facades\DB;
class ProductRepositoryImplement implements ProductRepository{

    protected $model;
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getAllProduct(){
        $data = $this->model->with(['kategori','priceSellProduct','priceBuyProductCustom','getToko'])->get();
        return $data;
    }

    public function getAllProductPaginate($limit,$keyword)
    {
        if (!empty($keyword)) {
            $data = $this->model
            ->with("kategori")
            ->with("priceSellProduct")
            ->where('nama_product','like','%'.$keyword .'%')
            ->limit($limit)->paginate($limit);
        }else{
            $data = $this->model
            ->with("kategori")
            ->with("priceSellProduct")
            ->limit($limit)->paginate($limit);
        }
        return $data;
    }


    public function getAllProductJualPriceSet($limit,$keyword,$is_price_set)
    {
        if (!empty($keyword)) {
            $data = $this->model
            ->with("kategori")
            ->with("priceSellProduct")
            ->when($is_price_set  == 1, function ($q) {
                $q->whereHas('priceSellProduct', function ($query){
                    $query->whereNotNull('product_id');
                });
            })
            ->when($is_price_set  !== 1, function ($q) {
                $q->doesntHave('priceSellProduct');
            })
            ->where('nama_product','like','%'.$keyword .'%')
            ->limit($limit)->paginate($limit);
        }else{
           
            $data = $this->model
            ->with("kategori")
            ->with("priceSellProduct")
            ->when($is_price_set  == 1, function ($q) {
                $q->whereHas('priceSellProduct', function ($query){
                    $query->whereNotNull('product_id');
                });
            })
            ->when($is_price_set  !== 1, function ($q) {
                $q->doesntHave('priceSellProduct');
            })
            ->limit($limit)->paginate($limit);
        }
        return $data;
    }

    public function getProductById($id)
    {
        $data = $this->model->with("kategori")->with("priceSellProduct")
                    ->where('id_product',$id)
                    ->first();
        return $data;
    }

    public function postProduct($data,$id)
    {
        $model_save = $this->model;
        if ( intval($id) > 0 || $id != NULL) {
            $model_save = $this->model->where('id_product',$id)->first();
            $model_save->nama_product = strtolower($data->nama_product);
            $model_save->toko_id = $data->toko_id;
            $model_save->kategori_id = strtolower($data->kategori_id);
            $model_save->harga_beli = strtolower($data->harga_beli);
            $model_save->expired = $data->expired;
            $model_save->is_kg = $data->is_kg;
            cek_is_kg($data->is_kg,$model_save,$data);
        }else{
            $model_save->nama_product = strtolower($data->nama_product);
            $model_save->toko_id = $data->toko_id;
            $model_save->kategori_id = strtolower($data->kategori_id);
            $model_save->harga_beli = strtolower($data->harga_beli);
            $model_save->expired = $data->expired;
            $model_save->is_kg = $data->is_kg;
            cek_is_kg($data->is_kg,$model_save,$data);
        }
        $model_save->save();
        return $model_save->fresh();
    }

    public function deleteProduct($id)
    {
        $model = $this->model->find($id);
        return $model->delete();
    }

    public function updateStockKg($idPrd, $stockFinal)
    {
        $model_save = $this->model->where('id_product',$idPrd)->first();
        $model_save->total_kg = $stockFinal;
        $model_save->save();
        return $model_save->fresh();
    }

    public function updateStockPcs($idPrd, $stockFinal)
    {
        $model_save = $this->model->where('id_product',$idPrd)->first();
        $model_save->pcs = $stockFinal;
        $model_save->save();
        return $model_save->fresh();
    }

    public function getTotolAllProductTerjual($id_product,$date)
    {
        if ($date != "" || $date != null) {
            $totalAll = DB::table('products as p')
                ->leftJoin('product_juals as pj', 'p.id_product', '=', 'pj.product_id')
                ->leftJoin('keranjang_kasirs as k', 'pj.id_product_jual', '=', 'k.product_jual_id')
                ->where('p.id_product', $id_product)
                ->where('k.status', 2)
                ->whereDate('k.created_at', $date)
                ->sum('k.jumlah_item_dibeli');
           
        }else{
            $totalAll = DB::table('products as p')
            ->leftJoin('product_juals as pj', 'p.id_product', '=', 'pj.product_id')
            ->leftJoin('keranjang_kasirs as k', 'pj.id_product_jual', '=', 'k.product_jual_id')
            ->where('p.id_product', $id_product)
            ->where('k.status', 2)
            ->select(DB::raw('SUM(k.jumlah_item_dibeli) as totalAll'))
            ->first();
            
       }
       $total = gettype($totalAll) == "object" ? round($totalAll->totalAll ?? 0) : (int) $totalAll;
        return $total;
    }
}