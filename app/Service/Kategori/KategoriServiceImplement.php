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
        //$page_input = $request->page == null ? 1 : $request->page;
        $limit = 10;
        $data = $this->kategoriRepository->getAllKategoryPaginate($limit,$request->keyword);
        return $data;
    }

    public function getKategoryByIdService($id){

        $data = $this->kategoriRepository->getKategoryById($id);
        return $data;
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