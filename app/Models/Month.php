<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'competition_id',
        'num',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * Get the Competiton that owns the Month.
     */
    public function competiton()
    {
        return $this->belongsTo(Competiton::class);
    }

    /**
     * Get the Bills associated with the Month.
     */
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
