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

    public function getProductByIdService($id){

        $data = $this->ProductJualRepository->getProductById($id);
        return $data;
    }

    public function postProductJualService($request,$id){

        $validated = Validator::make($data->all(),[
            'product_id' => 'required|integer|exists:products,id_product',
            'start_kg' => 'required|integer',
            'end_kg' => 'required|integer',
            'price_sell' => 'required|integer'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        
        return  $data;
    }
    
    public function deleteProductService($id){
        $validated = Validator::make($id->all(),[
            'id_product' => 'required|integer|exists:products,id_product'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $delete = $this->ProductRepository->deleteProduct($id->id_product);
        return $delete;
    }

}