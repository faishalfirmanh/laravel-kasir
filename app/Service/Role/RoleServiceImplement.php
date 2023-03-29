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
        $data = $this->role_repository->getRoleById($id);
        return $data;
    }

    public function DeleteRoleService($id)
    {
        $validator = Validator::make($id->all(),[
            'id'=> 'required|integer|exists:roles,id',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }

        $data = $this->role_repository->deleteRole($id->id);
        return $data;
    }

    public function PostRoleService($request, $id)
    {
        $validator = Validator::make($request->all(),[
            'id'=> 'integer|exists:roles,id',
            'kategori'=> 'required|numeric|between:0,1',
            'product'=> 'required|numeric|between:0,1',
            'kasir'=> 'required|numeric|between:0,1',
            'laporan'=> 'required|numeric|between:0,1'
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $data = $this->role_repository->postRole($request,$id);
        return $data;
    }

    public function GetAllRoleService($request)
    {
        $limit = 10;
        $data = $this->role_repository->getAllRolePaginate($limit,$request->keyword);
        return $data;
    }

}