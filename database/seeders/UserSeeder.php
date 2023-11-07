<?php

namespace Database\Seeders;

use Faker\Generator;
use App\Models\Admin;
use App\Models\Address;
use App\Models\Community;
use App\Models\Occupation;
use App\Models\Resident;
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

        //Resident
        Resident::create([
            'username' => 'community',
            'password' => Hash::make('community'),
            'name' => 'COMMUNITY',
            'email' => 'community@gmail.com',
        ]);

        //Community
        $community = Community::create([
            'name' => 'RESIDENT',
            'identification_number' => '990101-01-5619',
            'phone_number' => '+60182901888',
            'username' => 'resident',
            'email' => 'resident@gmail.com',
            'password' => Hash::make('resident'),
        ]);

        Occupation::create([
            'community_id' => $community->id,
            'place' => $faker->company(),
            'position' => $faker->jobTitle(),
            'sector' => 'S',
        ]);

        Address::create([
            'community_id' => $community->id,
            'category' => 'A2',
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
