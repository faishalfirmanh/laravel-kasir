<?php

namespace App\Service\ProductJual;

use App\Repository\ProductBeli\ProductBeliRepository;
use App\Repository\ProductJual\ProductJualRepository;
use App\Rules\RulesCekPriceLessThan;
use App\Service\ProductJual\ProductJualService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class ProductJualServiceImplement implements ProductJualService{

    protected $ProductJualRepository;
    public function __construct(ProductJualRepository $ProductJualRepository, ProductBeliRepository $ProductBeliRepository)
    {
        $this->ProductJualRepository = $ProductJualRepository;
        $this->ProductBeliRepository = $ProductBeliRepository;
    }

    public function getAllProductService($request){
        $limit = 10;
        $data = $this->ProductJualRepository->getAllProductPaginate($limit,$request->keyword);
        return $data;
    }

    public function getProductJualSearchService($request)
    {
        $validated = Validator::make($request->all(),[
            'keyword' => 'string|nullable'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $get_data = $this->ProductJualRepository->getAllProductPriceSearch($request->keyword, $request->toko_id_from_middleware);
        return  $get_data;
    }

    public function getProductJualByIdService($id){

        $data = $this->ProductJualRepository->getProductJualById($id);
        return $data;
    }

    public function getProductJualByIdProductService($request)
    {
        $validated = Validator::make($request->all(),[
            'id_product' => 'required|integer|exists:products,id_product',
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $get_data = $this->ProductJualRepository->getProductJualByIdProduct($request->id_product);
        return  $get_data;
    }

    public function getProductJualByIdSelftService($request)
    {
        $validated = Validator::make($request->all(),[
            'id_product_jual' => 'required|integer|exists:product_juals,id_product_jual',
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        $get_data = $this->ProductJualRepository->getProductJualById($request->id_product_jual);
        return  $get_data;
    }

    public function postProductJualService($request,$id){

        $productId = $request->product_id;
        $validated = Validator::make($request->all(),[
            'product_id' => 'required|integer|exists:products,id_product',
            'satuan_berat_item' => 'required|numeric',
            'price_sell' => ['required','integer', new RulesCekPriceLessThan($request->product_id)],
            'product_beli_id'=>['integer','exists:product_belis,id_product_beli',
                            'nullable'
                        ] //harusnya get by id_product terkait
        ]);
        
        if ($validated->fails()) {
            return $validated->errors();
        }

        /** allow set custom price kulak null */
        if($request->product_beli_id != null){
            $cek_product_beli = $this->ProductBeliRepository->getProductBeliById($request->product_beli_id);
            if ((int)$cek_product_beli->harga_beli_custom > (int) $request->price_sell ) {
                $msg_err = ['status_price' => 'tidak valid , harga jual tidak boleh kurang dari harga beli custom'];
                return $msg_err;
            }
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