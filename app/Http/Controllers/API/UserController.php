<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Service\Users\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    protected $service_user;
    public function __construct(UserService $service_user)
    {
        $this->service_user = $service_user;
    }

    public function store(Request $request)
    {

    }

    public function index(Request $request)
    {

    }

    public function remove($id)
    {

    }

    public function detail($id)
    {

    }
}
