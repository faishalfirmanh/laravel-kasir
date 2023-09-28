<?php

namespace App\Repository\NewStruck;
use App\Models\NewStruck;
use Illuminate\Support\Facades\DB;

class NewStruckRepositoryImpelemnt implements NewStruckRepository{

    protected $model;
    public function __construct(NewStruck $model)
    {
        $this->model = $model;
    }

    public function getStruckById($id){
        $data = $this->model->find($id);
        return $data;
    }

    public function generateNewStruck($id_strukc)
    {
        $create = $this->model::create(['id_struck' => $id_strukc]);
        return $create;
    }

    public function updateStatusNewStruck($id, $total_harga_harus_dibayar,$status = 0, $pembeli_bayar =0)
    {

        $model = $this->model->query()->where('id_struck',$id)->first();
        $model->total_harga_dibayar = $total_harga_harus_dibayar;
        $model->pembeli_bayar = $pembeli_bayar;
        $model->kembalian = 0;
        $model->status = $status;
        $model->save();
        return $model;
        
    }

    public function updateInputPriceUserBayar($id, $status = 0, $pembeli_bayar = 0,$keuntungan_bersih = 0)
    {
        $model = $this->model->query()->where('id_struck',$id)->first();
        $model->pembeli_bayar = $pembeli_bayar;
        $model->kembalian = $pembeli_bayar - $model->total_harga_dibayar;
        $model->status = $status;
        $model->keuntungan_bersih = $keuntungan_bersih;
        $model->save();
        return $model->fresh();
    }

    public function updateStruckPlusMins1($req)
    {
        $model = $this->model->query()->where('id_struck',$req->id)->first();
        $model->total_harga_dibayar = $req->total_harga_dibayar;
        $model->save();
        return $model->fresh();
    }

    public function updateStatusStruck($id_struck,$status)
    {
        $model = $this->model->find($id_struck)->first();
        $model->status = $status;
        $model->save();
        return $model->fresh();
    }

    public function deleteStruckByIdStruck($id_struck)
    {
        $model = $this->model->find($id_struck);
        return $model->delete();
    }

    public function getProductByIdStruck($id)
    {
    
        $data = $this->model
        ->select('keranjang_kasirs.id_keranjang_kasir','new_strucks.id_struck',
        'products.nama_product','products.is_kg','product_juals.satuan_berat_item','product_juals.id_product_jual','product_juals.product_beli_id','product_belis.nama_product_variant','product_juals.subname',
        'keranjang_kasirs.harga_tiap_item','keranjang_kasirs.jumlah_item_dibeli','keranjang_kasirs.total_harga_item')
        ->join('keranjang_kasirs','new_strucks.id_struck','=','keranjang_kasirs.struck_id')
        ->join('product_juals','keranjang_kasirs.product_jual_id','=','product_juals.id_product_jual')
        ->join('products','product_juals.product_id','=','products.id_product')
        ->leftJoin("product_belis","product_juals.product_beli_id","=","product_belis.id_product_beli")
        ->where('keranjang_kasirs.struck_id',$id)
        ->get();
        return $data;
    }

    public function QueryMySqlGetKeuntungan($id_struck)
    {
        $query = DB::select('
        select s.id_struck,
        p.id_product_jual,
        prod.is_kg,
        p.product_beli_id,
        prod.nama_product,
        p.subname,
        prodBeli.nama_product_variant,
        k.jumlah_item_dibeli,
        IF (p.product_beli_id IS NULL, 
            ABS((k.jumlah_item_dibeli * prod.harga_beli) - k.total_harga_item), 
            ABS((k.jumlah_item_dibeli * prodBeli.harga_beli_custom) - k.total_harga_item)) 
            as "TotalKeuntungan",
        IF (p.product_beli_id IS NULL, 
            ROUND(ABS((k.jumlah_item_dibeli * prod.harga_beli) - k.total_harga_item) / k.jumlah_item_dibeli), 
            ROUND(ABS((k.jumlah_item_dibeli * prodBeli.harga_beli_custom) - k.total_harga_item) / k.jumlah_item_dibeli) ) 
            as "keuntungan_1_item"
        FROM `new_strucks` s JOIN keranjang_kasirs k on s.id_struck = k.struck_id 
        JOIN product_juals p on k.product_jual_id = p.id_product_jual 
        JOIN products prod on p.product_id = prod.id_product
        LEFT JOIN product_belis prodBeli on p.product_beli_id = prodBeli.id_product_beli 
        WHERE s.id_struck = '.$id_struck.' and k.status = 2 order by p.product_id asc');
        return $query;
    }

    public function getAllStruckReport($request)
    {
        $data = $this->model->where('status',$request)->with(['listProducBuy'])->orderBy('id_struck','desc')->get();
        return $data;
    }

    public function getAllStruckReportPaginate($request)
    {
        $page = $request->page;
        $keyword = $request->keyword;
        $data_next_prev =( $request->limit * $page) - $request->limit;
        $limit = $request->limit;
        if (!empty($request->keyword)) {
            $count = cekCountAllData($this->model->where('status',2));
        }else{
            $count = cekCoutAllDataSearch($this->model->where('status',2), 'created_at', $keyword);
        }
       
        $offset = $page == 1 ? 0 : $data_next_prev;
        $total_halaman = $count / $request->limit;
        $halaman = $count % $request->limit != 0 ? $total_halaman + 1 : $total_halaman;
        $data = $this->model
            ->with(['listProducBuy'])
            ->when(!empty($keyword), function ($q) use ($keyword) {
                $q->where('created_at','like','%'. $keyword .'%');
            })
            ->when(empty($keyword), function ($q) use ($offset,$limit) {
                $q->offset($offset);
                $q->limit($limit);
            })
            ->get();
        //cek next page
        if ($page == 1) {
            if ($count == $data->count()) {
                $ee = 'no';
            }else{
                $ee = 'yes';
            }
            $prevv = 'no';
        }else{
            if ($data->count() < $offset) {
                $ee = 'no';
            }else{
                $ee = 'yes';
            }
            $prevv = 'yes';
        }
        $ress = [
            'data'=> $data,
            'total_data' => $count,
            'total_page' => (int) $halaman,
            'current_page' => (int) $page,
            'prev_page' => $prevv, 
            'next_page' => $ee
        ];
        return $ress;
    }

    public function getDashboardReport($request)
    {
        $data = cekCountTransaction($request->toko_id, $request->tanggal);
        return $data;
    }
   
}