<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Service\Users\UserService;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseApi;

class UserController extends Controller
{
    //
    use ResponseApi;
    protected $service_user;
    public function __construct(UserService $service_user)
    {
        $this->service_user = $service_user;
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $data = $this->service_user->PostUserService($request,$id);
        return $this->responseSucess($data);
    }

    public function index(Request $request)
    {
        $data = $this->service_user->GetAllUserService($request);
        return $this->responseSucess($data);
    }

    public function remove(Request $request)
    {
        $data = $this->service_user->DeleteUserService($request);
        return $this->responseSucess($data);
    }

    public function detail(Request $request)
    {
        $data = $this->service_user->GetUserByIdService($request);
        $final = $data != null ? $this->responseSucess($data) : $this->responseError($data);
        return $final;
    }
}
