<?php

namespace Database\Seeders;

use Barryvdh\TranslationManager\Manager;
use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    private $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->manager->importTranslations(true);
    }
}
