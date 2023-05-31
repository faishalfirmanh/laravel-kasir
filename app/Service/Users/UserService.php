<?php

namespace App\Service\Users;

interface UserService{
    public function PostUserService($request,$id);
    public function GetUserByIdServicePost($request);
    public function UserChangePassByIdServicePost($request);
    public function DeleteUserService($id);
    public function GetAllUserService($request);
    public function GetAllUserServiceWithPaginate($request);
    public function GetUserByIdService($id);
}