<?php
namespace App\Repository\Role;

interface RoleRepository {
    public function getAllRole();
    public function getAllRolePaginate($limit,$keyword);
    public function getRoleById($id);
    public function postRole($data,$id);
    public function deleteRole($id);
}