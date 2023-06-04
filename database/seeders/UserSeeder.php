<?php

namespace Database\Seeders;

use Faker\Generator;
use App\Models\Admin;
use App\Models\Address;
use App\Models\Community;
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
        $faker = app(Generator::class);

        //Super Admin
        SuperAdmin::create([
            'username' => 'superadmin',
            'password' => Hash::make('superadmin'),
            'name' => 'SUPER ADMIN',
            'email' => 'superadmin@gmail.com',
        ]);

        //Admin
        Admin::create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'name' => 'ADMIN',
            'email' => 'admin@gmail.com',
        ]);

        //Community
        $community = Community::create([
            'name' => 'COMMUNITY',
            'identification_number' => '990101-01-5619',
            'phone_number' => '+60182901888',
            'username' => 'community',
            'email' => 'community@gmail.com',
            'password' => Hash::make('community'),
        ]);

        Address::create([
            'community_id' => $community->id,
            'line_1' => strtoupper($faker->buildingNumber()),
            'line_2' => strtoupper($faker->streetName()),
            'line_3' => strtoupper($faker->township()),
            'city' => strtoupper($faker->city()),
            'postcode' => strtoupper($faker->postcode()),
            'state' => 'JOHOR',
            'country' => 'MALAYSIA',
        ]);
    }
}
