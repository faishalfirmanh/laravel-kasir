<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Service\Product\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    protected $service;
    public function __construct(ProductService $service)
    {
        $this->service = $service;
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


}
