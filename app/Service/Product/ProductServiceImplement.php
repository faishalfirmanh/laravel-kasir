<?php

namespace App\Service\Product;

use App\Repository\Product;
use App\Repository\Product\ProductRepository;
use Illuminate\Support\Facades\Validator;
class ProductServiceImplement implements ProductService{

    protected $ProductRepository;
    public function __construct(ProductRepository $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }

    public function getAllProductService($request){
        $limit = 10;
        $data = $this->ProductRepository->getAllProductPaginate($limit,$request->keyword);
        return $data;
    }

    public function getProductByIdService($id){

        $data = $this->ProductRepository->getProductById($id);
        return $data;
    }

    public function postProductService($data,$id){

        $validated = Validator::make($data->all(),[
            'nama_product' => 'required|unique:products,nama_product|max:255',
            'kategori_id' => 'required|integer|exists:kategoris,id_kategori',
            'harga_beli' => 'required|integer',
            'total_kg' => 'required|integer'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }

        if ($id != NULL) {
            $find = $this->ProductRepository->getProductById($id);
            if ($find != NULL) {
                $data = $this->ProductRepository->postProduct($data,$id);
            }else{
                $data = NULL;
            }
        }else{
            $data = $this->ProductRepository->postProduct($data,$id);
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