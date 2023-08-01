<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Barryvdh\TranslationManager\Manager;
use Barryvdh\TranslationManager\Models\Translation;

class NewsletterCategorySeeder extends Seeder
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
        DB::table('newsletter_category')->insertTs([
            'code' => 'A',
            'name' => 'adapt',
            'description' => 'Adaptation'
        ]);

        $translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => 'Adaptation',
        ]);

        $translation->value = 'Adaptasi';
        $translation->status = Translation::STATUS_CHANGED;
        $translation->save();

        DB::table('newsletter_category')->insertTs([
            'code' => 'M',
            'name' => 'mitigate',
            'description' => 'Mitigation'
        ]);

        $translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => 'Mitigation',
        ]);

        $translation->value = 'Mitigasi';
        $translation->status = Translation::STATUS_CHANGED;
        $translation->save();

        $this->translation_manager->exportTranslations('_json', true);
    }
}
