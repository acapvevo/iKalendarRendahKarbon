<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Finance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'community_id',
        'account_number',
        'account_name',
        'bank',
        'bank_statement',
    ];

    /**
     * Get the Community that owns the Address.
     */
    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function uploadBankStatement($bank_statment)
    {
        $this->bank_statement = 'Bank_Statement_' . $this->community->username . '.' .  $bank_statment->getClientOriginalExtension();
        $bank_statment->storeAs('bank_statement', $this->bank_statement);
    }

    public function downloadBankStatement()
    {
        return Storage::response('bank_statement/' . $this->bank_statement);
    }

    public function getBank()
    {
        return DB::table('banks')->where('code', $this->bank)->first();
    }
}
