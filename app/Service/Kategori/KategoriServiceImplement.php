<?php

namespace App\Service\Kategori;

use App\Repository\Kategori\KategoriRepository;
use Illuminate\Support\Facades\Validator;
class KategoriServiceImplement implements KategoriService{

    protected $kategoriRepository;
    public function __construct(KategoriRepository $kategoriRepository)
    {
        $this->kategoriRepository = $kategoriRepository;
    }

    public function getAllKategoryService($request){
       
        $validated = Validator::make($request->all(),[
            'limit' => 'required|integer',
            'page' => 'integer|nullable',
            'keyword' => 'string|nullable'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        if (empty($request->page)) {
            $request->page = 1;
        }

        $data = $this->kategoriRepository->getAllDataPaginateWithSearch($request);

        return $data;
    }

    public function getAllKategroyServiceNoPaginate($request)
    {
        $data = $this->kategoriRepository->getAllKategori();
        return $data;
    }

    public function getKategoryByIdService($id){

        $data = $this->kategoriRepository->getKategoryById($id);
        return $data;
    }

    public function getKategoryByNameService($req){
        $validated = Validator::make($req->all(),[
            'nama_kategori' => 'string|exists:kategoris,nama_kategori'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $name = trim(strtolower($req->nama_kategori));
        $get_data = $this->kategoriRepository->getKategoriByName($name);
        return  $get_data;
    }

    public function getKategoriByidServiceFix($request){
        $validated = Validator::make($request->all(),[
            'id_kategori' => 'required|exists:kategoris,id_kategori'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        return $this->kategoriRepository->getKategoryById($request->id_kategori);
    }

    public function postKategoriService($data,$id){

        $find_name = $this->kategoriRepository->getKategoryById($id) != NULL ? $this->kategoriRepository->getKategoryById($id)->nama_kategori : null;
        $cek_ = $data->nama_kategori == $find_name ? '' : 'unique:kategoris,nama_kategori';
        $validated = Validator::make($data->all(),[
            'nama_kategori' => 'required|'.$cek_
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }

        if ($id != NULL) {
            $find = $this->kategoriRepository->getKategoryById($id);
            if ($find != NULL) {
                $data = $this->kategoriRepository->postKategori($data,$id);
            }else{
                $data = NULL;
            }
        }else{
            $data = $this->kategoriRepository->postKategori($data,$id);
        }
        return  $data;
    }
    
    public function deleteKategoriService($id){
        $validated = Validator::make($id->all(),[
            'id_kategori' => 'required|integer|exists:kategoris,id_kategori'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $delete = $this->kategoriRepository->deleteKategori($id->id_kategori);
        return $delete;
    }

}