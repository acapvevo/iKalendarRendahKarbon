<?php

namespace App\Models;

use App\Traits\SubmissionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evidence extends Model
{
    use HasFactory, SubmissionTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'submission_id',
        'title',
        'file',
        'category',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Get the Submission that owns the Bill.
     */
    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function formatTitleForFileName($category_name)
    {
        return $category_name . '_' . preg_replace('/[^a-zA-Z0-9\-\._]/', '', $this->title);
    }

    public function getFilePath()
    {
        return 'evidences/' . $this->submission->competition->year . '/' . $this->submission->community->id;
    }

    public function downloadFile()
    {
        return response()->file(storage_path('app/evidences/' . $this->submission->competition->year . '/' . $this->submission->community->id . '/' . $this->file));
    }

    public function deleteFile()
    {
        Storage::delete($this->getFilePath() . '/' . $this->file);
    }

    public function checkFile()
    {
        return Storage::exists($this->getFilePath() . '/' . $this->file);
    }

    public function getCategory()
    {
        return $this->getSubmissionCategoryByCode($this->category);
    }
}
