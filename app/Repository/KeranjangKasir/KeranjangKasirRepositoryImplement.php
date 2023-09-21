<?php

namespace App\Repository\KeranjangKasir;
use App\Models\KeranjangKasir;
use Illuminate\Support\Facades\DB;

class KeranjangKasirRepositoryImplement implements KeranjangKasirRepository{

    protected $model;
    public function __construct(KeranjangKasir $model)
    {
        $this->model = $model;
    }

    public function getKeranjangById($id)
    {
        $data = $this->model->where('id_keranjang_kasir', $id)->first();
        return $data;
    }

    public function getKeranjangByStruckId($id_struck)
    {
        $data = $this->model->where('struck_id', $id_struck)->first();
        return $data;
    }

    public function getAllKeranjangById($id)
    {
        $data = $this->model->where('id_keranjang_kasir', $id)->get();
        return $data;
    }

    public function getAllKeranjangByIdKasir($id_kasir)
    {
        $data = $this->model->with(['getProduct'])->where('struck_id', $id_kasir)->get();
        return $data;
    }

    public function addKeranjang($request)
    {
        $modal_save = $this->model;
        $modal_save->id_keranjang_kasir = $request->id_keranjang_kasir;// kalau memperlambat bisa dihpus
        $modal_save->product_jual_id  = $request->product_jual_id;
        $modal_save->jumlah_item_dibeli = $request->jumlah_item_dibeli;
        $modal_save->harga_tiap_item = $request->harga_tiap_item;
        $modal_save->total_harga_item = $request->total_harga_item;
        $modal_save->status = 0;
        $modal_save->struck_id  = $request->struck_id;
        $modal_save->total_decimal_buy_for_stock  = $request->total_decimal_buy_for_stock;
        $modal_save->save();
        return $modal_save->fresh();
    }

    public function UpdateKeranjang($request, $id)
    {
        $modal_save = $this->model->query()->where('id_keranjang_kasir',$id)->first();
        if(!empty($request->product_jual_id)) {
            $modal_save->product_jual_id = $request->product_jual_id;
        }
        if(!empty($request->jumlah_item_dibeli)) {
            $modal_save->jumlah_item_dibeli = $request->jumlah_item_dibeli;
        }
        if(!empty($request->total_harga_item)) {
            $modal_save->total_harga_item = $request->total_harga_item;
        }
        if (!empty($request->harga_tiap_item)) {
            $modal_save->harga_tiap_item = $request->harga_tiap_item;
        }
        if (!empty($request->status)) {
            $modal_save->status = $request->status;
        }
        if (!empty($request->struck_id)) {
            $modal_save->struck_id = $request->struck_id;
        }
        if (!empty($request->total_decimal_buy_for_stock)) {
            $modal_save->total_decimal_buy_for_stock = $request->total_decimal_buy_for_stock;
        }
        $modal_save->save();
        return $modal_save->fresh();
    }

    public function UpdateStatusKeranjangByStruckId($struck_id,$status)
    {
        $get_data = $this->model->query()->where('struck_id',$struck_id)->get();
        $param_save = array();
        foreach ($get_data as $key => $value) {
            $id_keranjang = $value->id_keranjang_kasir;
            $get_first_data = $this->model->query()->where('id_keranjang_kasir',$id_keranjang)->first();
            $get_first_data->status = $status;
            $get_first_data->save();
            $saved_ = $get_first_data->fresh();
            array_push($param_save,$saved_);
        }
        return $param_save;
    }

    public function Add1JumlahKerajang($id,$item_dibeli,$total_harga_item,$total_stock_decimal)
    {
        $modal_save = $this->model->query()->where('id_keranjang_kasir',$id)->first();
        $modal_save->jumlah_item_dibeli = $item_dibeli;
        $modal_save->total_harga_item = $total_harga_item;
        $modal_save->total_decimal_buy_for_stock  = $total_stock_decimal;
        $modal_save->save();
        return $modal_save->fresh();
    }

    public function DeleteKeranjangStruck($id_keranjang)
    {
        $model = $this->model->find($id_keranjang);
        return $model->delete();
    }

    public function Reduce1JumlahKerajang($id,$item_dibeli,$total_harga_item)
    {
        
    }

    public function getAllTotalPriceMustPayByIdStruck($idStruck)
    {
        $data = $this->model->where('struck_id', $idStruck)->sum('total_harga_item');
        return $data;
    }

    public function CekIdProductAndSturckIdInKeranjang($id_product, $id_struck)
    {
        $data = $this->model->where('product_jual_id',$id_product)->where('struck_id', $id_struck)->first();
        return $data;
    }

    public function getTotalPriceAllItemMustPayCount($id_struck)
    {
        $count = $this->model->where('struck_id',$id_struck)
                  ->selectRaw('SUM(total_harga_item) as total')->first();
                  //->pluck('total');
        return $count;
    }

    public function queryCheck1TransationSameProduct($struck_id)
    {
        //$query = 
        //'SET @param_stuck_id = '.$struck_id.';
        //SET @VAL = (select p.id_product from keranjang_kasirs kk JOIN product_juals pj on pj.id_product_jual = kk.product_jual_id join products p on p.id_product = pj.product_id where kk.struck_id = @param_stuck_id GROUP by p.id_product HAVING COUNT(p.id_product) > 1); 
        //SET @total_rownya = ( select sum(keranjang_kasirs.total_decimal_buy_for_stock) from keranjang_kasirs where keranjang_kasirs.struck_id = @param_stuck_id ); 
        //SELECT IF (@VAL IS NOT NULL, ROUND(@total_rownya,3) ,0) AS "RESULT"; ';
        // return $query;

        $VAL = DB::table('keranjang_kasirs')
            ->join('product_juals', 'product_juals.id_product_jual', '=', 'keranjang_kasirs.product_jual_id')
            ->join('products', 'products.id_product', '=', 'product_juals.product_id')
            ->where('keranjang_kasirs.struck_id', $struck_id)
            ->groupBy('products.id_product')
            ->havingRaw('COUNT(products.id_product) > 1')
            ->select('products.id_product')
            ->first();

        //$result = ($VAL !== null) ? round($total_rownya, 3) : 0;
        return $VAL ;
    }

    public function queryCheck1TransationSumStockProduct($struck_id,$product_id)
    {
        $total_rownya = DB::select('select sum(keranjang_kasirs.total_decimal_buy_for_stock) as "total"
        from keranjang_kasirs 
         join product_juals pj on keranjang_kasirs.product_jual_id = pj.id_product_jual 
         join products p on pj.product_id = p.id_product where keranjang_kasirs.struck_id = '.$struck_id.' and p.id_product = '.$product_id.';');
        return $total_rownya;
    }
}