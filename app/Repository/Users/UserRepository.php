<?php
namespace App\Repository\Users;

interface UserRepository {
    public function getAllUser();
    public function getAllUserPaginate($request);
    public function getUserById($id);
    public function postUser($data,$id);
    public function postChangePasswordUser($request,$id);
    public function deleteUser($id);
}