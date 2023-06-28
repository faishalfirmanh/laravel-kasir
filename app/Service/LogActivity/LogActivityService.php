<?php

namespace App\Service\LogActivity;

interface LogActivityService {
    public function saveLogActivityService($req);
    public function getAllActivityService($req);
    public function getDetailActivityService($req);
}