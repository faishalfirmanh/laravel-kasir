<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Service\NewStruck\NewStruckService;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseApi;
class NewStruckController extends Controller
{
    //
    use ResponseApi;
    protected $service;
    public function __construct(NewStruckService $service)
    {
        $this->service = $service;
    }

    public function getStrudById(Request $request)
    {
        $data = $this->service->getStruckByIdService($request);
        return $this->responseSucess($data);
    }

    public function GenerateNewStruck(Request $request)
    {
        $data = $this->service->generateNewStruckService();
        return $this->responseSucess($data);
    }

    public function UpdateStruck(Request $request)
    {

    }

    public function InputPriceUserBayar(Request $request)
    {
        $data = $this->service->UpdateDataStruckService($request);
        return $this->responseSucess($data);
    }

    public function getProductByIdStruck(Request $request)
    {
        $data = $this->service->getProductByIdStruckService($request);
        return $this->responseSucess($data);
    }
}
