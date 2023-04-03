<?php

namespace App\Service\NewStruck;

interface NewStruckService{
    public function getStruckByIdService($request);
    public function generateNewStruckService();
    public function UpdateDataStruckService($request);
}