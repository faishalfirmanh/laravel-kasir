<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseApi;
use App\Service\Toko\TokoService;
use Illuminate\Support\Facades\Schema;

class TokoController extends Controller
{
    //
    use ResponseApi;
    protected $service;
    public function __construct(TokoService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        $data = $this->service->PostTokoService($request,$request->id_toko);
        return $this->generalResponseV2($data,4);
    }

    public function index(Request $request)
    {
        $data = $this->service->GetAllTokoService($request);
        return $this->generalResponseV2($data,5);
    }

    public function getAllTokoPaginateSearchCon(Request $request)
    {
        $data = $this->service->GetAllTokoServicePaginateAndSearch($request);
        return $this->generalResponseV2($data,1);
    }

    public function allToko(Request $request)
    {
        $data = $this->kategori_service->getAllKategroyServiceNoPaginate($request);
        return $this->responseSucess($data);
    }

    public function detail(Request $request)
    {
      
        $data = $this->service->GetTokoByIdService($request);
        return $this->generalResponseV2($data,5);
    }

 


    public function remove(Request $request)
    {
        $data = $this->service->DeleteTokoService($request);
        return $this->responseSucess($data);
    }
}
