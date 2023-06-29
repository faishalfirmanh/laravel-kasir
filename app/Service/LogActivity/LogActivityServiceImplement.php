<?php

namespace App\Service\LogActivity;
use App\Service\LogActivity\LogActivityService;
use Illuminate\Support\Facades\Validator;
use App\Repository\LogActivity\LogActivityRepository;

class LogActivityServiceImplement implements LogActivityService{

    protected $repository;

    public function __construct(LogActivityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getDetailActivityService($req)
    {
        $validated = Validator::make($req->all(),[
            'id' => 'required|integer|exists:log_activities,id_logActivity',
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        
        $data = $this->repository->getLogActivityById($req->id);
        return $data;
    }

    public function saveLogActivityService($req)
    {
        $req->ip = $_SERVER['REMOTE_ADDR']; 
        $validated = Validator::make($req->all(),[
            'user_id' => 'required|integer|exists:users,id',
            'tipe' => 'required|string',
            'ip' => 'string|nullable',
            'lat' => 'required|string',
            'long' => 'required|string',
            'desc' => 'required|string'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        
        $data = $this->repository->saveLogActivity($req);
        return $data;
    }

    public function getAllActivityService($req)
    {
        $validated = Validator::make($req->all(),[
            'limit' => 'required|integer',
            'page' => 'integer|nullable',
            'keyword' => 'string|nullable'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        if (empty($req->page)) {
            $req->page = 1;
        }

        $data = $this->repository->getAllLogActivityPaginateAndSearch($req);
        return $data;
    }
}