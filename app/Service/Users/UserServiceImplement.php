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

    public function GetUserByIdServicePost($request)
    {
        $validated = Validator::make($request->all(),[
            'id' => 'required|integer|exists:users,id'
        ]);

        if ($validated->fails()) {
            return $validated->errors();
        }
        $find = $this->user_repository->getUserById($request->id);
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
            'toko_id' => 'required|integer|exists:tokos,id_toko',
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'nullable|string',
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
        $data = $this->user_repository->getAllUser();
        return $data;
    }

    public function GetAllUserServiceWithPaginate($request)
    {
        $validated = Validator::make($request->all(),[
            'limit' => 'required|integer',
            'page' => 'integer|nullable',
            'keyword' => 'string|nullable'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        if (empty($request->page)) {
            $request->page = 1;
        }

        $data = $this->user_repository->getAllUserPaginate($request);

        return $data;
    }

    public function UserChangePassByIdServicePost($request)
    {
        $validated = Validator::make($request->all(),[
            'password' => 'required|string',
            'id'=> 'integer|exists:users,id'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $id = $request->id;
        $save = $this->user_repository->postChangePasswordUser($request,$id);
        return  $save;
    }
}