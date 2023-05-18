<?php

namespace App\Repository\Kategori;

use App\Models\Kategori;

class KategoriRepositoryImplement implements KategoriRepository{

    protected $model;
    public function __construct(Kategori $model)
    {
        $this->model = $model;
    }

    public function getAllKategori(){
        $data = $this->model->get();
        return $data;
    }

    public function getAllKategoryPaginate($limit,$keyword)
    {
        if (!empty($keyword)) {
            $data = $this->model->where('nama_kategori','like','%'.$keyword .'%')
            ->limit($limit)->paginate($limit);
        }else{
            $data = $this->model->with(['productRelasiKategori'])->limit($limit)->paginate($limit);
        }
        return $data;
    }

    public function getKategoryById($id)
    {
        return $this->model->where('id_kategori',$id)->first();
    }

    public function postKategori($data,$id)
    {
        $model_save = $this->model;
        if ( intval($id) > 0 || $id != NULL) {
            $model_save = $this->model->where('id_kategori',$id)->first();
            $model_save->nama_kategori = strtolower($data->nama_kategori);
        }else{
            $model_save->nama_kategori = strtolower($data->nama_kategori);
        }
        $model_save->save();
        return $model_save->fresh();
    }

    public function deleteKategori($id)
    {
        $model = $this->model->find($id);
        return $model->delete();
    }

    public function getCountAllData($request)
    {
        $data = $this->model->get();
        return $data->count();
    }


    //all data ketika ada keyword offset dan limit diabaikan, ketika tidak ada baru pake offset limit
    public function getAllDataPaginateWithSearch($request)
    {
        $page = $request->page;
        $keyword = $request->keyword;
        $data_next_prev =( $request->limit * $page) - $request->limit;
        $limit = $request->limit;
        if (!empty($request->keyword)) {
            $count = $this->getCoutDataSearch($request->keyword);
        }else{
            $count = $this->getCountAllData($request);
        }
       
        $offset = $page == 1 ? 0 : $data_next_prev;
        $total_halaman = $count / $request->limit;
        $halaman = $count % $request->limit != 0 ? $total_halaman + 1 : $total_halaman;
        $data = $this->model
            ->with(['productRelasiKategori'])
            ->when(!empty($keyword), function ($q) use ($keyword) {
                $q->where('nama_kategori','like','%'. $keyword .'%');
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

    public function getCoutDataSearch($keyword)
    {
        $data = $this->model->where('nama_kategori','like','%'.$keyword .'%')->get();
        return $data->count();
    }
}