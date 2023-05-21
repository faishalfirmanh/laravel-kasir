<?php

namespace App\Repository\Toko;

use App\Models\Toko;
class TokoRepositoryImplement implements TokoRepository{

    protected $model;
    public function __construct(Toko $model)
    {
        $this->model = $model;
    }


    public function getAllToko()
    {
        $data = $this->model->with(['userRelasiToko'])->get();
        return $data;
    }

    public function getAllDataTokoPaginateWithSearch($request)
    {
        $page = $request->page;
        $keyword = $request->keyword;
        $data_next_prev =( $request->limit * $page) - $request->limit;
        $limit = $request->limit;
        if (!empty($request->keyword)) {
            $count = cekCountAllData($this->model);
        }else{
            $count = cekCoutAllDataSearch($this->model, 'nama_toko', $keyword);
        }
       
        $offset = $page == 1 ? 0 : $data_next_prev;
        $total_halaman = $count / $request->limit;
        $halaman = $count % $request->limit != 0 ? $total_halaman + 1 : $total_halaman;
        $data = $this->model
            ->with(['userRelasiToko'])
            ->when(!empty($keyword), function ($q) use ($keyword) {
                $q->where('nama_toko','like','%'. $keyword .'%');
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
                $ee = 'yes';
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

    public function getAllTokoPaginate($limit, $keyowrd)
    {
        if (!empty($keyword)) {
            $data = $this->model
            ->where('nama_toko','like','%'.$keyword .'%')
            ->limit($limit)->get();
        }else{
            $data = $this->model
            ->limit($limit)->paginate($limit);
        }
        return $data;
    }

    public function getTokoById($id)
    {
        $data = $this->model
        ->with(['userRelasiToko'])
        ->where('id_toko',$id)
        ->first();
        return $data;   
    }

    public function postToko($data, $id)
    {
        $model_save = $this->model;
        if ((int) $id > 0 || $id != NULL) {
           $model_save =$this->model->where('id_toko',$id)->first();
           $model_save->nama_toko = strtolower($data->nama_toko);
        }else{
           $model_save->nama_toko = strtolower($data->nama_toko);
        }
        $model_save->save();
        return $model_save->fresh();
    }

    public function deleteToko($id)
    {
        $model = $this->model->find($id);
        return $model->delete();
    }

}