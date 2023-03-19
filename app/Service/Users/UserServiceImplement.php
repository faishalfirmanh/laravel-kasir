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
        $find = $this->user_repository->getUserById($id->id);
        return $find;
    }

    public function DeleteUserService($id)
    {
        $validated = Validator::make($id->all(),[
            'id' => 'required|integer|exists:users,id'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $delete = $this->user_repository->deleteUser($id->id);
        return $delete;
    }

    public function PostUserService($request, $id)
    {
        $validated = Validator::make($request->all(),[
            'id_roles' => 'required|integer|exists:roles,id',
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'id'=> 'integer|exists:users,id'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $save = $this->user_repository->postUser($request,$id);
        return  $save;
    }

    public function GetAllUserService($request)
    {
        $limit = 10;
        $data = $this->user_repository->getAllUserPaginate($limit,$request->keyword);
        return $data;
    }

}