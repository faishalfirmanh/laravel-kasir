<?php

namespace App\Service\Users;

use App\Repository\Users\UserRepository;
use Illuminate\Support\Facades\Validator;
class UserServiceImplement implements UserService{

    protected $user_repository;
    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function GetUserByIdService($id)
    {
        
    }

    public function DeleteUserService($id)
    {
        
    }

    public function PostUserService($request, $id)
    {
        $validated = Validator::make($request->all(),[
            'id_roles' => 'required|integer|exists:roles,id',
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $save = $this->ProductJualRepository->postProductJual($request,$id);
        return  $save;
    }

    public function GetAllUserService($request)
    {
        
    }

}