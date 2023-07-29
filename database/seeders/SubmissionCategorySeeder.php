<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubmissionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('submission_category')->insertTs([
            'code' => 'E',
            'name' => 'electric',
            'description' => 'Electric'
        ]);

        DB::table('submission_category')->insertTs([
            'code' => 'W',
            'name' => 'water',
            'description' => 'Water'
        ]);

        DB::table('submission_category')->insertTs([
            'code' => 'R',
            'name' => 'recycle',
            'description' => 'Recycle'
        ]);

        DB::table('submission_category')->insertTs([
            'code' => 'UO',
            'name' => 'used_oil',
            'description' => 'Used Oil'
        ]);
    }
}
