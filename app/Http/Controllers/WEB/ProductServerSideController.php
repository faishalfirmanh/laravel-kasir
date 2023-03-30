<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Product;
use DataTables;

class ProductServerSideController extends Controller
{
    //

    public function viewProduct()
    {
        return view('admin.product.index_serverside');
    }

    public function getProduct(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::query()->with('kategori')->with('priceSellProduct')->orderBy('id_product','ASC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('no', function ($data) {
                    $id = $data->id_product;
                    return $id;
                })
                ->addColumn('nama_product', function ($data) {
                    return $data->nama_product;
                })
                ->addColumn('harga_beli', function ($data) {
                    return number_format($data->harga_beli);
                })
                ->addColumn('stock', function ($data) {
                    if ($data->is_kg == '1') {
                        $stock = $data->total_kg. ' kg';
                    }else{
                        $stock = $data->pcs .' pcs';
                    }
                    return $stock;
                })
                ->addColumn('action', function($data){
                    $actionBtn = '<i onclick="editKategori('.$data->id_product.')" class="far fa-edit" style="margin-right:5px;"></i>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
