<?php

namespace App\Repository\LogActivity;

interface LogActivityRepository {
    public function saveLogActivity($request);
    public function getAllLogActivityPaginateAndSearch($request);
    public function getLogActivityById($id);
}