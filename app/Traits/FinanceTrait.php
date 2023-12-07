<?php

namespace App\Traits;

use App\Models\Finance;
use Illuminate\Support\Facades\DB;

trait FinanceTrait
{
    public function getRules()
    {
        return [
            'finance.account_number' => 'string|max:255',
            'finance.account_name' => 'string|max:255',
            'finance.bank' => 'numeric|exists:banks,code',
            'bank_statement' => 'mimes:jpg,pdf,png|max:4096',
        ];
    }

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

    public function saveFinance($community_id, $details, $bank_statement)
    {
        $finance = $this->getFinanceByCommunityID($community_id);

        $finance->fill($details);

        if ($bank_statement)
            $finance->uploadBankStatement($bank_statement);

        $finance->save();
    }
}
