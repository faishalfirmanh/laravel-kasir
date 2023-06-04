<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use DB;
class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
       
        DB::table('kategoris')->insert([
            'nama_kategori' => 'kebutuhan pokoK',
        ],true);
        
        DB::table('kategoris')->insert([
            'nama_kategori' => 'rempah rempah',
        ],true);

        DB::table('kategoris')->insert([
            'nama_kategori' => 'sayur',
        ],true);
        
        DB::table('kategoris')->insert([
            'nama_kategori' => 'buah',
        ],true);
    	

    }
}
