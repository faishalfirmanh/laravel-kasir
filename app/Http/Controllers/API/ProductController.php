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
        $total_result_kolom = json_decode(json_encode($data), true);
        if (count($total_result_kolom) == 10) {
           return $this->responseSucess($data);
        }else{
            return $this->responseError($data);
        }

    }

    public function index(Request $request)
    {
        $data = $this->service->getAllProductService($request);
        return response()->json([
            "status"=>"ok",
            "data"=>$data
        ],200);
    }

    public function getAllProductController(Request $request)
    {
        $data = $this->service->getAllProductNoPaginate();
        return $this->responseSucess($data);
    }

    public function detailRequestId(Request $request)
    {
        $data = $this->service->getProductByIdServiceInput($request);
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

    public function getProductJualByIdProduct(Request $request)
    {
        $data = $this->product_jual_service->getProductJualByIdProductService($request);
        // $cek = count($data) > 0 ? $this->responseSucess($data) : $this->responseError($data);
        return $this->responseSucess($data);

    }

    public function detailProductJual($id){
        $data = $this->product_jual_service->getProductJualByIdService($id);
        return $this->responseSucess($data);
    }

    public function detailProductJual2(Request $request)
    {
        $data = $this->product_jual_service->getProductJualByIdSelftService($request);
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

    public function getAllProductPriceSet(Request $request)
    {
        $data = $this->service->getAllProductServicePriceSet($request);
        return $this->responseSucess($data);
    }

    public function getAllProductPriceNotSet(Request $request)
    {
        $data = $this->service->getAllProductServicePriceNotSet($request);
        return $this->responseSucess($data);
    }

    public function getProdcutPriceSearch(Request $request)
    {
        $data = $this->product_jual_service->getProductJualSearchService($request);
        return $this->responseSucess($data);
    }

}
