<?php
namespace App\Repository\Role;

use App\Models\Role;

class RoleRepositoryImplement implements RoleRepository{

    protected $model;
    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function getAllRole()
    {
        $data = $this->model->get();
        return $data;
    }

    public function getAllRolePaginate($limit, $keyword)
    {
        if (!empty($keyword)) {
            $data = $this->model
            ->where('name_role','like','%'.$keyword .'%')
            ->limit($limit)->get();
        }else{
            $data = $this->model
            ->limit($limit)->paginate($limit);
        }
        return $data;
    }

    public function getRoleById($id)
    {
        $data = $this->model
        ->where('id',$id)
        ->first();
        return $data;
    }

    public function postRole($data, $id)
    {
        $model_save = $this->model;
        if ((int) $id > 0 || $id != NULL) {
           $model_save =$this->model->where('id',$id)->first();
           $model_save->name_role = $data->name_role;
           $model_save->kategori = $data->kategori;
           $model_save->product = $data->product;
           $model_save->kasir = $data->kasir;
           $model_save->laporan = $data->laporan;
        }else{
            $model_save->name_role = $data->name_role;
            $model_save->kategori = $data->kategori;
            $model_save->product = $data->product;
            $model_save->kasir = $data->kasir;
            $model_save->laporan = $data->laporan;
        }
        $model_save->save();
        return $model_save->fresh();
    }

    public function deleteRole($id)
    {
        $model = $this->model->find($id);
        return $model->delete();
    }
}