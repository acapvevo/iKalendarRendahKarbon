<?php

namespace App\Traits;

use App\Models\Finance;
use Illuminate\Support\Facades\DB;

trait FinanceTrait
{
    public function initFinance()
    {
        return new Finance;
    }

    public function getFinanceByCommunityID($community_id)
    {
        return Finance::firstOrNew([
            'community_id' => $community_id
        ]);
    }

    public function getFinance($id)
    {
        return Finance::find($id);
    }

    public function getBankList()
    {
        return DB::table('banks')->get();
    }
}
