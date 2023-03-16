<?php

namespace App\Service\ProductJual;

use App\Repository\ProductJual\ProductJualRepository;

use App\Service\ProductJual\ProductJualService;
use Illuminate\Support\Facades\Validator;
class ProductJualServiceImplement implements ProductJualService{

    protected $ProductJualRepository;
    public function __construct(ProductJualRepository $ProductJualRepository)
    {
        $this->ProductJualRepository = $ProductJualRepository;
    }

    public function getAllProductService($request){
        $limit = 10;
        $data = $this->ProductJualRepository->getAllProductPaginate($limit,$request->keyword);
        return $data;
    }

    public function getProductJualByIdService($id){

        $data = $this->ProductJualRepository->getProductJualById($id);
        return $data;
    }

    public function postProductJualService($request,$id){

        $validated = Validator::make($request->all(),[
            'product_id' => 'required|integer|exists:products,id_product',
            'start_kg' => 'required|integer',
            'end_kg' => 'required|integer',
            'price_sell' => 'required|integer'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $save = $this->ProductJualRepository->postProductJual($request,$id);
        return  $save;
    }
    
    public function deleteProductJualService($req){
        $validated = Validator::make($req->all(),[
            'id_product_jual' => 'required|integer|exists:product_juals,id_product_jual'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $delete = $this->ProductJualRepository->deleteProductJual($req->id_product_jual);
        return $delete;
    }

}