<?php

namespace App\Repository\NewStruck;


interface NewStruckRepository{
    public function getStruckById($id);
    public function generateNewStruck($request);
    public function updateStatusNewStruck($id,$request);
}