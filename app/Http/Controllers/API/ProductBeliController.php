<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Service\ProductBeli\ProductBeliService;;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseApi;


class ProductBeliController extends Controller
{
    //
    use ResponseApi;
    protected $service;

    public function __construct(ProductBeliService $service)
    {
        $this->service = $service;
    }

    public function getAllProductBeliCon(Request $request)
    {
        $data = $this->service->getAllProductBeliByIdProductService($request);
        return $this->responseSucess($data);
    }

    public function getProductBeliConById(Request $request)
    {
        $data = $this->service->getProductBeliServiceById($request);
        return $this->responseSucess($data);
    }

    public function saveProductBeliCon(Request $request)
    {
        $data = $this->service->saveProductBeliService($request);
        return $this->generalResponseV2($data,6);
    }

    public function deleteProductBeliCon(Request $request)
    {
        $data = $this->service->deleteProductBeliService($request);
        return $this->responseSucess($data);
    }




}