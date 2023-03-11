<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Service\Kategori\KategoriService;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    //
    protected $kategori_service;
    public function __construct(KategoriService $kategori_service)
    {
        $this->kategori_service = $kategori_service;
    }

    public function store(Request $request)
    {
        $data = $this->kategori_service->postKategoriService($request,$request->id_kategori);
        return response()->json([
            "status"=>"ok",
            "data"=>$data
        ],200);
    }

    public function index(Request $request)
    {
        $data = $this->kategori_service->getAllKategoryService($request);
        return response()->json([
            "status"=>"ok",
            "data"=>$data
        ],200);
    }

    public function detail($id)
    {
        $data = $this->kategori_service->getKategoryByIdService($id);
        return response()->json([
            "status"=>"ok",
            "data"=>$data
        ],200);
    }

    public function remove(Request $request)
    {
        $id = $request->id_kategori;
        $data = $this->kategori_service->deleteKategoriService($request);
        return response()->json([
            "status"=>"ok",
            "data"=>$data
        ],200);
    }
}
