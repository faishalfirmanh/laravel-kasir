<?php

namespace App\Service\KeranjangKasir;

use App\Repository\KeranjangKasir\KeranjangKasirRepository;
use App\Repository\NewStruck\NewStruckRepository;
use App\Repository\ProductJual\ProductJualRepository;
use Illuminate\Support\Facades\Validator;
use stdClass;

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

    public function Add1ProductKeranjangServiceById($request)
    {
        $validated = Validator::make($request->all(),[
            'id_keranjang_kasir' => 'required|exists:keranjang_kasirs,id_keranjang_kasir'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        //get db
        $data_keranjang = $this->repository->getKeranjangById($request->id_keranjang_kasir);
        $data_struck = $this->repo_struck->getStruckById($data_keranjang->struck_id);
        $total_product_each_item = $data_struck->total_harga_dibayar + $data_keranjang->harga_tiap_item; //harga yang harus diupdate pada data struck;   
        //get db
        //save db
        $update_keranjang = $this->repository->Add1JumlahKerajang($request->id_keranjang_kasir,
                                                                (int) $data_keranjang->jumlah_item_dibeli + 1,
                                                                (int) $data_keranjang->total_harga_item + $data_keranjang->harga_tiap_item);                         
        $req_struck = new stdClass();
        $req_struck->id = $data_keranjang->struck_id;
        $req_struck->total_harga_dibayar = $total_product_each_item;                                                        
        $update_struck = $this->repo_struck->updateStruckPlusMins1($req_struck);
        //save db
        return $update_keranjang;

    }

    public function Remove1ProductKeranjangServiceById($request)
    {
        $validated = Validator::make($request->all(),[
            'id_keranjang_kasir' => 'required|exists:keranjang_kasirs,id_keranjang_kasir'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        //get db
        $data_keranjang = $this->repository->getKeranjangById($request->id_keranjang_kasir);
        $data_struck = $this->repo_struck->getStruckById($data_keranjang->struck_id);
        $total_product_each_item = $data_struck->total_harga_dibayar - $data_keranjang->harga_tiap_item; //harga yang harus diupdate pada data struck;   
        //get db
        //save db
        $update_keranjang = $this->repository->Add1JumlahKerajang($request->id_keranjang_kasir,
                                                                (int) $data_keranjang->jumlah_item_dibeli - 1,
                                                                (int) $data_keranjang->total_harga_item - $data_keranjang->harga_tiap_item);                         
        $req_struck = new stdClass();
        $req_struck->id = $data_keranjang->struck_id;
        $req_struck->total_harga_dibayar = $total_product_each_item;                                                        
        $update_struck = $this->repo_struck->updateStruckPlusMins1($req_struck);
        //save db
        return $update_keranjang;

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
        //cek if product & struc id eksis
        $data_keranjang = $this->repository->CekIdProductAndSturckIdInKeranjang($request->product_jual_id,$request->struck_id);
        
        //save to db
        if ($data_keranjang != NULL) {
            $id_keranjang_kasir = $data_keranjang->id_keranjang_kasir;
            $data_add_keranjang = $this->repository->Add1JumlahKerajang($id_keranjang_kasir,
                                                (int) $data_keranjang->jumlah_item_dibeli + (int) $request->jumlah_item_dibeli,
                                                (int) $data_keranjang->total_harga_item + ($data_keranjang->harga_tiap_item * $request->jumlah_item_dibeli));                         
        }else{
            $data_add_keranjang = $this->repository->addKeranjang($request);
        }
        
        if ((int)$find_data_struck->total_harga_dibayar > 0) {
            $must_pay = $this->repository->getAllTotalPriceMustPayByIdStruck($request->struck_id);
            $data_update_struck = $this->repo_struck->updateStatusNewStruck($request->struck_id,$must_pay,1);
        }else{
            $data_update_struck = $this->repo_struck->updateStatusNewStruck($request->struck_id,$total_price_item,0);
        }
       
        return $data_add_keranjang;//response bisa diganti paggil api get-view-struck-barang
    }

    public function DeleteKeranjangServiceById($request)
    {
        $validated = Validator::make($request->all(),[
            'id_keranjang_kasir' => 'required|exists:keranjang_kasirs,id_keranjang_kasir',
        ]);

        if ($validated->fails()) {
            return $validated->errors();
        }

        $get_keranjang = $this->repository->getKeranjangById($request->id_keranjang_kasir);
        $price_delete = $get_keranjang->total_harga_item;
        $must_pay = $this->repository->getAllTotalPriceMustPayByIdStruck($get_keranjang->struck_id);
        //save db
        $delete_keranjang = $this->repository->DeleteKeranjangStruck($request->id_keranjang_kasir);
        $update_total_price_struck = $this->repo_struck->updateStatusNewStruck($get_keranjang->struck_id,$must_pay-$price_delete,1);
        return $update_total_price_struck;
    }

}