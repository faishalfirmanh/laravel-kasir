<?php

namespace App\Service\KeranjangKasir;

use App\Repository\KeranjangKasir\KeranjangKasirRepository;
use App\Repository\NewStruck\NewStruckRepository;
use App\Repository\ProductJual\ProductJualRepository;
use Illuminate\Support\Facades\Validator;
class KeranjangKasirServiceImplement implements KeranjangKasirService{

    protected $repository;
    public function __construct(KeranjangKasirRepository $repository, 
                                ProductJualRepository $repo_product_jual,
                                NewStruckRepository $repo_struck)
    {
        $this->repository = $repository;
        $this->repo_product_jual = $repo_product_jual;
        $this->repo_struck = $repo_struck;
    }

    public function getKerjangServiceById($request)
    {
        $validated = Validator::make($request->all(),[
            'id_keranjang_kasir' => 'required|exists:keranjang_kasirs,id_keranjang_kasir'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
       
        $data = $this->repository->getKeranjangById($request->id_keranjang_kasir);
        return $data;
    }

    public function CreateKeranjangServiceById($request)
    {
        $validated = Validator::make($request->all(),[
            'struck_id' => 'required|exists:new_strucks,id_struck',
            'product_jual_id' => 'required|exists:product_juals,id_product_jual',
            'status' => 'required|integer',
            'jumlah_item_dibeli' => 'required|integer'
        ]);

        if ($validated->fails()) {
            return $validated->errors();
        }
        $find_data_product_jual = $this->repo_product_jual->getProductJualById($request->product_jual_id);
        $find_data_struck = $this->repo_struck->getStruckById($request->struck_id);
        $total_price_item = (int)$find_data_product_jual->price_sell * (int)$request->jumlah_item_dibeli;
        //keranjang
        $request->total_harga_item = $total_price_item;
        $request->harga_tiap_item = $find_data_product_jual->price_sell;
        
        //save to db
        $data_add_keranjang = $this->repository->addKeranjang($request);
        if ((int)$find_data_struck->total_harga_dibayar > 0) {
            $must_pay = $this->repository->getAllTotalPriceMustPayByIdStruck($request->struck_id);
            $data_update_struck = $this->repo_struck->updateStatusNewStruck($request->struck_id,$must_pay,1);
        }else{
            $data_update_struck = $this->repo_struck->updateStatusNewStruck($request->struck_id,$total_price_item,0);
        }
       
        return $data_add_keranjang;
    }

    

}