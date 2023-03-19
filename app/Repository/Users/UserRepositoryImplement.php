<?php
namespace App\Repository\Users;

use App\Models\User;

class UserRepositoryImplement implements UserRepository{

    protected $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAllUser()
    {
        $data = $this->model->get();
        return $data;   
    }

    public function getAllUserPaginate($limit, $keyword)
    {
        if (!empty($keyword)) {
            $data = $this->model
            ->where('name','like','%'.$keyword .'%')
            ->limit($limit)->paginate($limit);
        }else{
            $data = $this->model
            ->limit($limit)->paginate($limit);
        }
        return $data;
    }

    public function getUserById($id)
    {
        $data = $this->model
        ->where('id',$id)
        ->first();
        return $data;
    }

    public function postUser($data,$id)
    {
        $model_save = $this->model;
        if ( (int) $id > 0 || $id != NULL) {
            $model_save = $this->model->where('id',$id)->first();
            $model_save->id_roles = $data->id_roles;
            $model_save->name = $data->name;
            $model_save->email = $data->email;
            $model_save->password = bcrypt($data->password);
        }else{
            $model_save->name = strtolower($data->name);
            $model_save->id_roles = $data->id_roles;
            $model_save->email = strtolower($data->email);
            $model_save->password = bcrypt($data->password);
        }
        $model_save->save();
        return $model_save->fresh();
    }

    public function deleteUser($id)
    {
        $model = $this->model->find($id);
        return $model->delete();
    }
}