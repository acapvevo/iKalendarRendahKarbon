<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Barryvdh\TranslationManager\Manager;
use Barryvdh\TranslationManager\Models\Translation;

class AddressCategorySeeder extends Seeder
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
        DB::table('address_category')->insertTs([
            'code' => 'A1',
            'name'=> 'House (High Rise)'
        ]);

        $translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => 'House (High Rise)',
        ]);

        $translation->value = 'Rumah (Bertingkat)';
        $translation->status = Translation::STATUS_CHANGED;
        $translation->save();

        DB::table('address_category')->insertTs([
            'code' => 'A2',
            'name'=> 'House (Landed)'
        ]);

        $translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => 'House (High Rise)',
        ]);

        $translation->value = 'Rumah (Atas Tanah)';
        $translation->status = Translation::STATUS_CHANGED;
        $translation->save();

        DB::table('address_category')->insertTs([
            'code' => 'B',
            'name'=> 'Institution'
        ]);

        $translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => 'Institution',
        ]);

        $translation->value = 'Institusi';
        $translation->status = Translation::STATUS_CHANGED;
        $translation->save();

        DB::table('address_category')->insertTs([
            'code' => 'C',
            'name'=> 'MBIP Staff/Division'
        ]);

        $translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => 'MBIP Staff/Division',
        ]);

        $translation->value = 'Staf MBIP';
        $translation->status = Translation::STATUS_CHANGED;
        $translation->save();

        $this->translation_manager->exportTranslations('_json', true);
    }
}
