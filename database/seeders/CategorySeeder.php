<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Barryvdh\TranslationManager\Manager;
use Barryvdh\TranslationManager\Models\Translation;

class CategorySeeder extends Seeder
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
        // Electric
        DB::table('category')->insertTs([
            'code' => 'E',
            'class' => 'App\Models\Electric',
            'name' => 'electric',
            'description' => 'Electric',
            'symbol' => 'kWh',
            'icon' => 'material-symbols:electric-bolt',
            'forCompetition' => true,
            'forActivity' => false,
        ]);

        $translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => 'Electric',
        ]);

        $translation->value = 'Elektrik';
        $translation->status = Translation::STATUS_CHANGED;
        $translation->save();

        // Water
        DB::table('category')->insertTs([
            'code' => 'W',
            'class' => 'App\Models\Water',
            'name' => 'water',
            'description' => 'Water',
            'symbol' => 'm<sup>3</sup>',
            'icon' => 'ion:water',
            'forCompetition' => true,
            'forActivity' => false,
        ]);

        $translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => 'Water',
        ]);

        $translation->value = 'Air';
        $translation->status = Translation::STATUS_CHANGED;
        $translation->save();

        // Recycle
        DB::table('category')->insertTs([
            'code' => 'R',
            'class' => 'App\Models\Recycle',
            'name' => 'recycle',
            'description' => 'Recycle',
            'symbol' => 'kg',
            'icon' => 'mdi:recycle',
            'forCompetition' => true,
            'forActivity' => true,
        ]);

        $translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => 'Recycle',
        ]);

        $translation->value = 'Kitar Semula';
        $translation->status = Translation::STATUS_CHANGED;
        $translation->save();

        // Used Oil
        DB::table('category')->insertTs([
            'code' => 'UO',
            'class' => 'App\Models\UsedOil',
            'name' => 'used_oil',
            'description' => 'Used Oil',
            'symbol' => 'kg',
            'icon' => 'material-symbols:oil-barrel',
            'forCompetition' => true,
            'forActivity' => true,
        ]);

        $translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => 'Used Oil',
        ]);

        $translation->value = 'Minyak Terpakai';
        $translation->status = Translation::STATUS_CHANGED;
        $translation->save();

        // Electronic
        DB::table('category')->insertTs([
            'code' => 'ET',
            'class' => 'App\Models\Electronic',
            'name' => 'electronic',
            'description' => 'Electronic',
            'symbol' => 'kg',
            'icon' => 'iconoir:electronics-chip',
            'forCompetition' => false,
            'forActivity' => true,
        ]);

        $translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => 'Electronic',
        ]);

        $translation->value = 'Elektronik';
        $translation->status = Translation::STATUS_CHANGED;
        $translation->save();

        // Fabric
        DB::table('category')->insertTs([
            'code' => 'F',
            'class' => 'App\Models\Fabric',
            'name' => 'fabric',
            'description' => 'Fabric',
            'symbol' => 'kg',
            'icon' => 'icon-park:clothes-short-sleeve',
            'forCompetition' => false,
            'forActivity' => true,
        ]);

        $translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => 'Fabric',
        ]);

        $translation->value = 'Fabrik';
        $translation->status = Translation::STATUS_CHANGED;
        $translation->save();

        // $this->translation_manager->exportTranslations('_json', true);
    }
}
