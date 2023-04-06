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
        return $this->responseSucess($data);
    }

    public function UpdateDataKeranjang(Request $request)
    {

    }

    public function add1JumlahProductKerajang(Request $request)
    {

    }

    public function reduce1JumlahProductKerajang(Request $request)
    {

    }

}
