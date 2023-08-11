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
        return $this->generalResponseV2($data,8);
    }

    public function GenerateNewStruck(Request $request)
    {
        $data = $this->service->generateNewStruckService();
        return $this->generalResponseV2($data,3);
    }

    public function UpdateStruck(Request $request)
    {

    }

    public function InputPriceUserBayar(Request $request)
    {
        $data = $this->service->UpdateDataStruckService($request);
        return $this->generalResponseV2($data,8);
    }

    public function getProductByIdStruck(Request $request)
    {
        $data = $this->service->getProductByIdStruckService($request);
        return $this->generalResponseV2($data,5);
    }

    public function getKeuntunganByIdStruckCon(Request $request)
    {
        $data = $this->service->getKeuntunganByIdStruckService($request);
        return $this->generalResponseV2($data,2);
    }

    public function listTransactionAll(Request $request)
    {
        $data = $this->service->getAllStruckTransactionService($request);
        return $this->generalResponseV2($data,9);
    }

    public function listTransactionPaginate(Request $request)
    {
        $data  = $this->service->getAllStrukTransactionPaginateService($request);
        return $this->responseSucess($data);
    }

    public function get_dashboardToday(Request $request)
    {
        $data  = $this->service->getRangukumanDashboardService($request);
        return $this->generalResponseV2($data,4);
    }
}
