<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Service\KeranjangKasir\KeranjangKasirService;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseApi;
class KeranjangKasirController extends Controller
{
    //
    use ResponseApi;
    protected $service;
    public function __construct(KeranjangKasirService $service)
    {
        $this->service = $service;
    }

    public function GetKerajangById(Request $request)
    {
        $data = $this->service->getKerjangServiceById($request);
        return $this->responseSucess($data);
    }

    public function CreateNewKerajangProduct(Request $request)
    {
        $data = $this->service->CreateKeranjangServiceById($request);
        return $this->generalResponseV2($data,10);
    }

    public function UpdateDataKeranjang(Request $request)
    {

    }

    public function add1JumlahProductKerajang(Request $request)
    {
        $data = $this->service->Add1ProductKeranjangServiceById($request);
        return $this->responseSucess($data);
    }

    public function reduce1JumlahProductKerajang(Request $request)
    {
        $data = $this->service->Remove1ProductKeranjangServiceById($request);
        return $this->generalResponseV2($data,9);
    }

    public function deleteKeranjang(Request $request)
    {
        $data = $this->service->DeleteKeranjangServiceById($request);
        return $this->generalResponseV2($data,8);
    }

}
