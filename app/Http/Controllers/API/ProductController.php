<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Service\Product\ProductService;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseApi;
use App\Service\ProductJual\ProductJualService;

class ProductController extends Controller
{
    //
    use ResponseApi;
    protected $service;
    public function __construct(ProductService $service, ProductJualService $product_jual_service)
    {
        $this->service = $service;
        $this->product_jual_service = $product_jual_service;
    }

    public function store(Request $request)
    {
        $data = $this->service->postProductService($request,$request->id_product);
        return response()->json([
            "status"=>"ok",
            "data"=>$data
        ],200);

    }

    public function index(Request $request)
    {
        $data = $this->service->getAllProductService($request);
        return response()->json([
            "status"=>"ok",
            "data"=>$data
        ],200);
    }

    public function detail($id)
    {
        $data = $this->service->getProductByIdService($id);
        return response()->json([
            "status"=>"ok",
            "data"=>$data
        ],200);
    }

    public function remove(Request $request)
    {
        $data = $this->service->deleteProductService($request);
        return response()->json([
            "status"=>"ok",
            "data"=>$data
        ],200);
    }

    public function detailProductJual($id){
        $data = $this->product_jual_service->getProductJualByIdService($id);
        return $this->responseSucess($data);
    }

    public function save_price_sell_product(Request $request){
        $data = $this->product_jual_service->postProductJualService($request,$request->id);
        return $this->responseSucess($data);
    }

    public function remove_price_sell_product(Request $request){
        $data = $this->product_jual_service->deleteProductJualService($request);
        return $this->responseSucess($data);

    }

}
