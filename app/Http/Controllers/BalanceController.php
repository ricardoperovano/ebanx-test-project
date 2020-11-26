<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Balance;

class BalanceController extends Controller
{
    /**
     * Get Balance
     * @param int $account_id
     * 
     * @return Balance
     */
    public function get()
    {
        $account_id = request('account_id');

        $account = (new Account())->getAccount($account_id);

        if ($account)
            return response()->json($account->amount, 200);

        return response()->json(0, 404);
    }
}
