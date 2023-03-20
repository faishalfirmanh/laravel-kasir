<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin = new User;
        $admin->id_roles = env('user_login_id_role');
        $admin->name = env('user_login_name');
        $admin->email = env('user_login_email');
        $admin->password = bcrypt(env('user_login_pass'));
        $admin->save();
    }
}
