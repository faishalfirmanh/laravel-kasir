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

    public function getAllProductNoPaginate()
    {
        $data = $this->ProductRepository->getAllProduct();
        return $data;
    }

    public function getAllProductServicePriceSet($request)
    {
        $limit = 10;
        $data = $this->ProductRepository->getAllProductJualPriceSet($limit,$request->keyword,1);
        return $data;
    }

    public function getAllProductServicePriceNotSet($request)
    {
        $limit = 10;
        $data = $this->ProductRepository->getAllProductJualPriceSet($limit,$request->keyword,0);
        return $data;
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

    public function getProductByIdServiceInput($request)
    {
        $validated = Validator::make($request->all(),[
            'id_product' => 'required|exists:products,id_product',
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $data = $this->ProductRepository->getProductById($request->id_product);
        return $data;
    }

    public function postProductService($data,$id){

        $find = $this->ProductRepository->getProductById($id);
        if ($find != NULL) {
            if ($find->nama_product == $data->nama_product) {
                $kondisi_ = '';
            }else{
                $kondisi_ = 'unique:products,nama_product';
            }
        }else{
            $kondisi_ = 'unique:products,nama_product';
        }

        $cek_kondisi_stock_kg = $data->is_kg == 1 ? 'required|numeric' : '';
        $cek_kondisi_stock_pcs = $data->is_kg == 0 ? 'required|integer' : '';
        
        $validated = Validator::make($data->all(),[
            'nama_product' => 'required|'.$kondisi_,
            'toko_id' => 'required|integer|exists:tokos,id_toko',
            'kategori_id' => 'required|integer|exists:kategoris,id_kategori',
            'harga_beli' => 'integer',
            'expired'=> 'date_format:Y-m-d|after:today|nullable',
            'is_kg' => 'required|numeric|between:0,1',
            'total_kg' => $cek_kondisi_stock_kg,
            'pcs'=> $cek_kondisi_stock_pcs
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }

        if ($id != NULL) {
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