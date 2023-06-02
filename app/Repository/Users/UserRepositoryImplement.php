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
        $data = $this->model->with(['getRole','getToko'])->get();
        return $data;   
    }

    public function getAllUserPaginate($request)
    {
        $page = $request->page;
        $keyword = $request->keyword;
        $data_next_prev =( $request->limit * $page) - $request->limit;
        $limit = $request->limit;
        if (!empty($request->keyword)) {
            $count = cekCountAllData($this->model); 
        }else{
            $count = cekCoutAllDataSearch($this->model, 'name', $keyword);
        }
       
        $offset = $page == 1 ? 0 : $data_next_prev;
        $total_halaman = $count / $request->limit;
        $halaman = $count % $request->limit != 0 ? $total_halaman + 1 : $total_halaman;
        $data = $this->model
            ->when(!empty($keyword), function ($q) use ($keyword) {
                $q->where('name','like','%'. $keyword .'%');
            })
            ->when(empty($keyword), function ($q) use ($offset,$limit) {
                $q->offset($offset);
                $q->limit($limit);
            })
            ->get();
        //cek next page
        if ($page == 1) {
            if ($count == $data->count()) {
                $ee = 'no';
            }else{
                $ee = 'yes';
            }
            $prevv = 'no';
        }else{
            if ($data->count() < $offset) {
                $ee = 'no';
            }else{
                if ($data->count() == 1) {
                    $ee = 'no';
                }else{
                    $ee = 'yes';
                }
            }
            $prevv = 'yes';
        }
        $ress = [
            'data'=> $data,
            'total_data' => $count,
            'total_page' => (int) $halaman,
            'current_page' => (int) $page,
            'prev_page' => $prevv, 
            'next_page' => $ee
        ];
        return $ress;
    }

    public function getUserById($id)
    {
        $data = $this->model->with(['getRole','getToko'])
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
            $model_save->toko_id = $data->toko_id;
            if (!empty($data->password)) {
                $model_save->password = bcrypt($data->password);
            }
            
        }else{
            $model_save->name = strtolower($data->name);
            $model_save->id_roles = $data->id_roles;
            $model_save->email = strtolower($data->email);
            $model_save->toko_id = $data->toko_id;
            if (!empty($data->password)) {
                $model_save->password = bcrypt($data->password);
            }else{
                $model_save->password = bcrypt(env('password_for_login'));
            }
            
        }
        $model_save->save();
        return $model_save->fresh();
    }

    public function postChangePasswordUser($req,$id)
    {
        $model_save = $this->model;
        $model_save = $this->model->where('id',$id)->first();
        $model_save->password = bcrypt($req->password);
        $model_save->save();
        return $model_save->fresh();
    }

    public function deleteUser($id)
    {
        $model = $this->model->find($id);
        return $model->delete();
    }
}