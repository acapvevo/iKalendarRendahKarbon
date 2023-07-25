<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('address_category')->insertTs([
            'code' => 'A1',
            'name'=> 'House (High Rise)'
        ]);

        DB::table('address_category')->insertTs([
            'code' => 'A2',
            'name'=> 'House (Landed)'
        ]);

        DB::table('address_category')->insertTs([
            'code' => 'B',
            'name'=> 'Institution'
        ]);

        DB::table('address_category')->insertTs([
            'code' => 'C',
            'name'=> 'MBIP Staff/Division'
        ]);
    }
}
