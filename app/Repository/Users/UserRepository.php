<?php
namespace App\Repository\Users;

interface UserRepository {
    public function getAllUser();
    public function getAllUserPaginate($limit,$keyword);
    public function getUserById($id);
    public function postUser($data,$id);
    public function deleteUser($id);
}