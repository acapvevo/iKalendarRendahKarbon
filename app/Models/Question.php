<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\TranslationManager\Models\Translation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'competition_id',
        'text',
        'example',
        'category',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Get the Competition that owns the Question.
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    /**
     * Get the Answers associated with the Question.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function getCategory()
    {
        return DB::table('submission_category')->where('code', $this->category)->first();
    }

    public function getValue($attribute)
    {
        if (LaravelLocalization::getCurrentLocale() == 'ms') {
            $translation = Translation::where('group', '_json')->where('key', $this->{$attribute})->first();
            return $translation->value ?? '';
        }

        return $this->{$attribute} ?? '';
    }

    public function getCurrentTranslation($attribute, $locale)
    {
        if ($locale && $locale == 'en')
            return $this->{$attribute};

        $translation = Translation::where('group', '_json')->where('key', $this->{$attribute})->first();
        return $translation->value ?? '';
    }

    public function editTranslation($text_malay, $example_malay)
    {
        $text_translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => $this->text,
        ]);

        $text_translation->value = $text_malay;
        $text_translation->status = Translation::STATUS_CHANGED;
        $text_translation->save();

        $example_translation = Translation::firstOrNew([
            'locale' => 'ms',
            'group' => '_json',
            'key' => $this->example,
        ]);

        $example_translation->value = $example_malay;
        $example_translation->status = Translation::STATUS_CHANGED;
        $example_translation->save();
    }

    public function deleteTranslation()
    {
        Translation::where('group', '_json')->whereIn('key', [$this->text, $this->example])->delete();
    }

    public function getAnswerBySubmissionID($submission_id)
    {
        return $this->answers->where('submission_id', $submission_id)->first();
    }
}
