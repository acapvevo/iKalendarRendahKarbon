<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Barryvdh\TranslationManager\Manager;
use Barryvdh\TranslationManager\Models\Translation;

class SubmissionCategorySeeder extends Seeder
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
        DB::table('submission_category')->insertTs([
            'code' => 'E',
            'name' => 'electric',
            'description' => 'Electric',
            'symbol' => 'kWh',
        ]);

        $translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => 'Electric',
        ]);

        $translation->value = 'Elektrik';
        $translation->status = Translation::STATUS_CHANGED;
        $translation->save();

        DB::table('submission_category')->insertTs([
            'code' => 'W',
            'name' => 'water',
            'description' => 'Water',
            'symbol' => 'm<sup>3</sup>',
        ]);

        $translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => 'Water',
        ]);

        $translation->value = 'Air';
        $translation->status = Translation::STATUS_CHANGED;
        $translation->save();

        DB::table('submission_category')->insertTs([
            'code' => 'R',
            'name' => 'recycle',
            'description' => 'Recycle',
            'symbol' => 'kg',
        ]);

        $translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => 'Recycle',
        ]);

        $translation->value = 'Kitar Semula';
        $translation->status = Translation::STATUS_CHANGED;
        $translation->save();

        DB::table('submission_category')->insertTs([
            'code' => 'UO',
            'name' => 'used_oil',
            'description' => 'Used Oil',
            'symbol' => 'kg',
        ]);

        $translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => 'Used Oil',
        ]);

        $translation->value = 'Minyak Terpakai';
        $translation->status = Translation::STATUS_CHANGED;
        $translation->save();

        $this->translation_manager->exportTranslations('_json', true);
    }
}
