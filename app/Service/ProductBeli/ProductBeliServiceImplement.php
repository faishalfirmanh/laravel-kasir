<?php

namespace App\Service\ProductBeli;

use App\Repository\ProductBeli\ProductBeliRepository;
use App\Repository\ProductJual\ProductJualRepository;
use App\Rules\RulesCekInputHargaBeliCustom;
use Illuminate\Support\Facades\Validator;
class ProductBeliServiceImplement implements ProductBeliService{

    protected $repository;
    protected $repo_productjual;
    public function __construct(ProductBeliRepository $repository, ProductJualRepository $repo_productjual)
    {
        $this->repository = $repository;
        $this->repo_productjual = $repo_productjual;
    }

    public function getAllProductBeliByIdProductService($request)
    {
        $validated = Validator::make($request->all(),[
            'product_id'=> 'required|exists:products,id_product'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }

        $data = $this->repository->getAllProductBeli($request->product_id);

        return $data;
    }

    public function getProductBeliServiceById($request)
    {
        $validated = Validator::make($request->all(),[
            'id_product_beli'=> 'required|exists:product_belis,id_product_beli'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $data = $this->repository->getProductBeliById($request->id_product_beli);
        return $data;
    }

    public function saveProductBeliService($request)
    {
        $id = $request->id;
        $find_name = $this->repository->getProductBeliById($id) != NULL ? $this->repository->getProductBeliById($id)->nama_product_variant : null;
        $cek_ = $request->nama_product_variant == $find_name ? '' : 'unique:product_belis,nama_product_variant';
        $validated = Validator::make($request->all(),[
            'nama_product_variant' => $cek_,
            'product_id' => 'required|integer|exists:products,id_product',
            'harga_beli_custom' => ['required','integer', new RulesCekInputHargaBeliCustom($request->product_id)]
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }

        if ($id != NULL) {
            $find = $this->repository->getProductBeliById($id);
            if ($find != NULL) {
                $data = $this->repository->saveProductBeli($id,$request);
            }else{
                $data = NULL;
            }
        }else{
            $data = $this->repository->saveProductBeli($id,$request);
        }
        return  $data;
    }

    public function deleteProductBeliService($request)
    {
        $validated = Validator::make($request->all(),[
            'id_product_beli'=> 'required|exists:product_belis,id_product_beli'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        
        
        $cek_in_product_jual = $this->repo_productjual->getProductJualByIdProducBeli($request->id_product_beli);
        if ($cek_in_product_jual != NULL) {
            $msg_err = ['msg' => 'Gagal hapus , id_product_beli '.$request->id_product_beli. ' ada pada data product beli'];
            return $msg_err;
        }

        $data = $this->repository->deleteProductBeli($request->id_product_beli);
        return $data;
    }

}