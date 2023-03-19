<?php

namespace App\Service\Users;

interface UserService{
    public function PostUserService($request,$id);
    public function DeleteUserService($id);
    public function GetAllUserService($request);
    public function GetUserByIdService($id);
}