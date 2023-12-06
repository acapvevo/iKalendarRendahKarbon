<?php

namespace App\Http\Controllers\Community\User;

use App\Traits\FinanceTrait;
use Illuminate\Http\Request;
use App\Traits\CommunityTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Universal\Participant\Community\ViewFinanceRequest;

class FinanceController extends Controller
{
    use CommunityTrait, FinanceTrait;

    public function view()
    {
        $user = $this->getCommunity(Auth::guard('community')->user()->id);

        return view('community.user.finance')->with('user', $user);
    }

    public function statement(ViewFinanceRequest $request)
    {
        $validated = $request->validated();

        $finance = $this->getFinance($validated['finance_id']);

        return $finance->downloadBankStatement();
    }
}
