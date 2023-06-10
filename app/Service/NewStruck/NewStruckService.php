<?php

namespace App\Service\NewStruck;

interface NewStruckService{
    public function getStruckByIdService($request);
    public function generateNewStruckService();
    public function UpdateDataStruckService($request);
    public function getProductByIdStruckService($request);
    public function getKeuntunganByIdStruckService($request);
    public function getAllStruckTransactionService($request);
    public function getAllStrukTransactionPaginateService($request);
}