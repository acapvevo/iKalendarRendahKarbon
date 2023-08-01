<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use JamesMills\LaravelTimezone\Facades\Timezone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Newsletter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'admin_id',
        'category',
        'title',
        'location',
        'thumbnail',
        'content',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Get the Admin that owns the Month.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function getCategory()
    {
        return DB::table('newsletter_category')->where('code', $this->category)->first();
    }

    public function getCreatedAt()
    {
        return Timezone::convertToLocal($this->created_at, 'j F Y g:i a', true, true);
    }

    public function formatTitleForFileName()
    {
        return preg_replace('/\s+/', '_', $this->title);
    }

    public function previewThumbnail()
    {
        return Storage::response('newsletter/' . $this->thumbnail);
    }
}
