<?php

namespace App\Repository\Kategori;

use App\Models\Kategori;
use App\Repository\BaseRepository;

class KategoriRepo extends BaseRepository{

    public function __construct(Kategori $model)
    {
        parent::__construct($model);
    }
}