<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Service\Kategori\KategoriService;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseApi;
use App\Service\Kategori\KategoriLogic;
use Illuminate\Support\Facades\Schema;

class KategoriController extends Controller
{
    //
    use ResponseApi;
    protected $kategori_service;
    public function __construct(KategoriService $kategori_service)
    {
        $this->kategori_service = $kategori_service;
        // $this->global_service = $global_service;
        // parent::__construct($repo);
    }

    public function store(Request $request)
    {
        $data = $this->kategori_service->postKategoriService($request,$request->id_kategori);
        $helper = getObject($data,1);
        return $this->getResponse($data, $helper);
    }

    public function index(Request $request)
    {
        $data = $this->kategori_service->getAllKategoryService($request);
        $helper = getObject($data,1); //1
        return $this->getResponse($data, $helper);
    }

    public function allKategori(Request $request)
    {
        $data = $this->kategori_service->getAllKategroyServiceNoPaginate($request);
        return $this->responseSucess($data);
    }

    public function detail($id)
    {
        $data = $this->kategori_service->getKategoryByIdService($id);
        $helper = getObject($data,0); //1
        return $this->getResponse($data, $helper);
    }

    public function detail2(Request $request)
    {
       $columns = Schema::getColumnListing('kategoris');
       $table = 'kategoris';
       $service = $this->global_service->detail_service($request,$columns,$table);
       return $service;
    }

    public function remove(Request $request)
    {
        $id = $request->id_kategori;
        $data = $this->kategori_service->deleteKategoriService($request);
        $helper = getObject($data,1); //1
        return $this->getResponse($data, $helper);//2
    }
}
