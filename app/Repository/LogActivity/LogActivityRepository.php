<?php

namespace App\Repository\LogActivity;

interface LogActivityRepository {
    public function saveLogActivity($request);
    public function getAllLogActivityPaginateAndSearch($request);
    public function getAllRepoActivityNopaginate();
    public function getLogActivityById($id);
}