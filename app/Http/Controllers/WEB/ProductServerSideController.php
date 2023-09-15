<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Product;
use App\Models\ProductJual;
use DataTables;

class ProductServerSideController extends Controller
{
    //

    public function viewProduct()
    {
        return view('admin.product.index_serverside');
    }

    public function viewProductUpload()
    {
        return view('admin.uploadproduct.index');
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
                    $many_price_product_set = count($data->priceSellProduct); 
                    if (count($data->priceSellProduct) > 0) {
                        foreach ($data->priceSellProduct as $key => $value) {
                            $price = number_format($value->price_sell).'<div class="style-total-price">'.count($data->priceSellProduct).'</div>';
                           array_push($val,$price);
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
                    $actionBtn .= '<a href="' . route('detail-price-product', $data->id_product) . '" class="fas fa-money-bill" style="background:#b4a2fb;margin-right:5px;" title="edit-price-product"></a>';
                    if (count($data->priceSellProduct) < 1) {
                        $actionBtn .= '<i onclick="deleteProduct('.$data->id_product.')" class="far fa-trash-alt" style="background:red" title="delete-product"></i>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action','harga_jual'])
                ->make(true);
        }
    }

    public function detailPriceProduct(Request $request)
    {
        $currenturl = url()->full();
        $to_str = explode("/",$currenturl);
        $id_product =$to_str[ count($to_str)-1];
        $name_product = Product::query()->where('id_product',$id_product)->first();
        return view('admin.product.detail_price_product',[
            'id' => $id_product,
            'name' => $name_product->nama_product
        ]);
    }

    public function getPriceListProductDetail(Request $request, $id)
    {
        $data = ProductJual::query()->with('productName')->where('product_id',$id)->orderBy('id_product_jual','DESC')->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('no', function ($data) {
            $id = $data->id_product;
            return $id;
        })
        ->addColumn('start_kg', function ($data) {
            return $data->start_kg;
        })
        ->addColumn('end_kg', function ($data) {
            return $data->end_kg;
        })
        ->addColumn('price_sell', function ($data) {
            return $data->price_sell;
        })
        ->addColumn('action', function($data){
            $actionBtn = '<i onclick="editProductJual('.$data->id_product_jual.')" title="edit-price-product" class="far fa-edit" style="margin-right:5px;"></i>';
            $actionBtn .= '<i onclick="deleteProductPrice('.$data->id_product_jual.')" class="far fa-trash-alt" style="background:red" title="edit-price-product"></i>';
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
}
