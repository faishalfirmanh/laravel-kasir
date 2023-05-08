<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Toko;
class TokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $toko = new Toko;
        $toko->nama_toko = 'Mojokerto';
        $toko->save();
    }
}
