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

        $balance = (new Balance())->getBalance($account_id);

        if ($balance)
            return response()->json($balance, 200);

        return response()->json(0, 404);
    }
}
