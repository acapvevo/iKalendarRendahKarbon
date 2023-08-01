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
            AddressCategorySeeder::class,
            OccupationSectorTypeSeeder::class,
            UserSeeder::class,
            TranslationSeeder::class,
            SubmissionCategorySeeder::class,
            NewsletterCategorySeeder::class
        ]);
    }
}
