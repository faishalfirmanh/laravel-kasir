<?php

namespace App\Service\Role;

use App\Repository\Role\RoleRepository;
use Illuminate\Support\Facades\Validator;
class RoleServiceImplement implements RoleService{

    protected $role_repository;
    public function __construct(RoleRepository $role_repository)
    {
        $this->role_repository= $role_repository;
    }

    public function GetRoleByIdService($id)
    {
        
    }

    public function DeleteRoleService($id)
    {
        
    }

    public function PostRoleService($request, $id)
    {
        
    }

    public function GetAllRoleService($request)
    {
        
    }

}