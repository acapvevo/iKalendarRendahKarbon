<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_category')->insertTs([
            'code' => 'E',
            'name'=> 'Electric'
        ]);

        DB::table('question_category')->insertTs([
            'code' => 'W',
            'name'=> 'Water'
        ]);

        DB::table('question_category')->insertTs([
            'code' => 'R',
            'name'=> 'Recycle'
        ]);

        DB::table('question_category')->insertTs([
            'code' => 'UO',
            'name'=> 'Used Oil'
        ]);
    }
}
