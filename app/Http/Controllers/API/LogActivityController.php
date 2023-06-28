<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\LogActivity\LogActivityService;
use App\Http\Traits\ResponseApi;

class LogActivityController extends Controller
{
    //
    use ResponseApi;
    protected $service;
    public function __construct(LogActivityService $service)
    {
        $this->service = $service;
    }

    public function getAllLogActivityController(Request $request)
    {
        $data = $this->service->getAllActivityService($request);
        return $this->generalResponseV2($data,6);
    }

    public function saveLogActivityController(Request $request)
    {
        $data = $this->service->saveLogActivityService($request);
        return $this->generalResponseV2($data,9);
    }

    public function detailLogActivityController(Request $request)
    {
        $data = $this->service->getDetailActivityService($request);
        return $this->generalResponseV2($data,9);
    }
}
