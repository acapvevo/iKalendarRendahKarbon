<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Barryvdh\TranslationManager\Manager;
use Barryvdh\TranslationManager\Models\Translation;

class OccupationSectorTypeSeeder extends Seeder
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
        DB::table('occupation_sector_type')->insertTs([
            'code' => 'A',
            'name'=> 'Public'
        ]);

        $translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => 'Public',
        ]);

        $translation->value = 'Awam';
        $translation->status = Translation::STATUS_CHANGED;
        $translation->save();

        DB::table('occupation_sector_type')->insertTs([
            'code' => 'S',
            'name'=> 'Private'
        ]);

        $translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => 'Private',
        ]);

        $translation->value = 'Swasta';
        $translation->status = Translation::STATUS_CHANGED;
        $translation->save();

        $this->translation_manager->exportTranslations('_json', true);
    }
}
