<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\SuperAdmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Super Admin

        SuperAdmin::create([
            'username' => 'superadmin',
            'password' => Hash::make('superadmin'),
            'name' => 'Super Admin',
            'email' => 'hamlala8@gmail.com',
        ]);

        //Admin

        Admin::create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'name' => 'Admin',
            'email' => 'hamlala8@gmail.com',
        ]);
    }
}
