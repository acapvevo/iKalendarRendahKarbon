<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OccupationSectorTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('occupation_sector_type')->insertTs([
            'code' => 'A',
            'name'=> 'Public'
        ]);

        DB::table('occupation_sector_type')->insertTs([
            'code' => 'S',
            'name'=> 'Private'
        ]);
    }
}
