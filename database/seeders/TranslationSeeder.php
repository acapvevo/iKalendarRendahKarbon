<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Barryvdh\TranslationManager\Manager;

class TranslationSeeder extends Seeder
{
    private $translation_manager;

    public function __construct(Manager $translation_manager)
    {
        $this->translation_manager = $translation_manager;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->translation_manager->importTranslations();
    }
}
