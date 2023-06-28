<?php

namespace App\Repository\LogActivity;
use App\Repository\LogActivity\LogActivityRepository;
use App\Models\LogActivity;

class LogActivityRepositoryImplement implements LogActivityRepository {

    protected $model;
    public function __construct(LogActivity $model)
    {
        $this->model = $model;
    }

    public function getLogActivityById($id)
    {
    
        $data = $this->model
        ->where('id_logActivity',$id)
        ->first();
        return $data;
        
    }

    public function saveLogActivity($request)
    {
        $model_save = $this->model;
        $model_save->user_id  = $request->user_id;
        $model_save->tipe = $request->tipe;
        $model_save->ip = $request->ip;
        $model_save->lat = $request->lat;
        $model_save->long = $request->long;
        $model_save->desc = $request->desc;
        $model_save->save();
        return $model_save->fresh();

    }

    public function getAllLogActivityPaginateAndSearch($request)
    {
        $page = $request->page;
        $keyword = $request->keyword;
        $data_next_prev =( $request->limit * $page) - $request->limit;
        $limit = $request->limit;

        if (!empty($request->keyword)) {
            $count = cekCountAllData($this->model); 
        }else{
            $count = cekCoutAllDataSearch($this->model, 'desc', $keyword);
        }
       
        $offset = $page == 1 ? 0 : $data_next_prev;
        $total_halaman = $count / $request->limit;
        $halaman = $count % $request->limit != 0 ? $total_halaman + 1 : $total_halaman;
        $data = $this->model
            ->when(!empty($keyword), function ($q) use ($keyword) {
                $q->where('desc','like','%'. $keyword .'%');
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

}