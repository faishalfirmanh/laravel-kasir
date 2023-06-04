<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role;
        $role->name_role = 'admin';
        $role->kategori = '1';
        $role->toko = '1';
        $role->user = '1';
        $role->product  = '1';
        $role->kasir    = '1';
        $role->laporan  = '1';
        $role->save();

    }
}
