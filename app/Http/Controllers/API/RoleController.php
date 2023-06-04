<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Service\Role\RoleService;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseApi;
class RoleController extends Controller
{
    //
    use ResponseApi;

    protected $service;
    public function __construct(RoleService $service)
    {
        $this->service =  $service;
    }

    public function index(Request $request)
    {
        $data = $this->service->GetAllRoleService($request);
        return $this->responseSucess($data);
    }

    public function indexGetAllCon(Request $request)
    {
        $data = $this->service->GetAllRoleServiceWithoutPaginate($request);
        return $this->generalResponseV2($data,11);
    }

    public function store(Request $request)
    {
        $data = $this->service->PostRoleService($request,$request->id);
        return $this->generalResponse($data,10);
    }

    public function detail($id)
    {
        $data = $this->service->GetRoleByIdService($id);
        return $this->generalResponse($data,10);
    }

    public function detailPost(Request $request)
    {
        $data = $this->service->GetRoleByIdServicePost($request);
        return $this->responseSucess($data);
    }

    public function remove(Request $request)
    {
        $data = $this->service->DeleteRoleService($request);
        return $this->responseSucess($data);
    }
}
