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

        $toko2 = new Toko;
        $toko2->nama_toko = 'Gersik';
        $toko2->save();

        $toko3 = new Toko;
        $toko3->nama_toko = 'Lamongan';
        $toko3->save();
    }
}
