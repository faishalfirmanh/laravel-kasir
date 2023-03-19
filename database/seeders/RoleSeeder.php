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
        $role->product  = '1';
        $role->kasir    = '1';
        $role->laporan  = '1';
        $role->save();

        $role2 = new Role;
        $role2->name_role = 'pegawai';
        $role2->kategori = '0';
        $role2->product  = '0';
        $role2->kasir    = '0';
        $role2->laporan  = '0';
        $role2->save();
    }
}
