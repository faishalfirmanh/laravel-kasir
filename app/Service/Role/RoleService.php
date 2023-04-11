<?php

namespace App\Service\Role;

interface RoleService{
    public function PostRoleService($request,$id);
    public function DeleteRoleService($id);
    public function GetAllRoleService($request);
    public function GetRoleByIdService($id);
    public function GetRoleByIdServicePost($request);
}