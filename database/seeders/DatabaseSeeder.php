<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TranslationSeeder::class,
            AddressCategorySeeder::class,
            OccupationSectorTypeSeeder::class,
            UserSeeder::class,
            SubmissionCategorySeeder::class,
            NewsletterCategorySeeder::class
        ]);
    }
}
