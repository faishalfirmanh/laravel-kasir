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
            $data = Product::query()->with('kategori')->with('priceSellProduct')->orderBy('id_product','DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('no', function ($data) {
                    $id = $data->id_product;
                    return $id;
                })
                ->addColumn('nama_product', function ($data) {
                    return $data->nama_product;
                })
                ->addColumn('kategori', function ($data) {
                    return $data->kategori->nama_kategori;
                })
                ->addColumn('harga_beli', function ($data) {
                    return number_format($data->harga_beli);
                })
                ->addColumn('harga_jual', function ($data) {
                    $val = [];
                    if (count($data->priceSellProduct) > 0) {
                        foreach ($data->priceSellProduct as $key => $value) {
                           array_push($val,number_format($value->price_sell));
                        }
                    }else{
                        array_push($val, '<div class="style-pricenoset">'.'Belum diset'.'</div>');
                    }
                    return $val[0];
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
                    $actionBtn = '<i onclick="editProduct('.$data->id_product.')" title="edit-product" class="far fa-edit" style="margin-right:5px;"></i>';
                    $actionBtn .= '<i onclick="editProductPrice('.$data->id_product.')" class="fas fa-money-bill" style="background:#3FD12E" title="edit-price-product"></i>';
                    return $actionBtn;
                })
                ->rawColumns(['action','harga_jual'])
                ->make(true);
        }
    }
}
