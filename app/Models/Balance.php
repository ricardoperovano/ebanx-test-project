<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    public function getBalance(string $account_id)
    {
        $account = (new Account())->getAccount($account_id);

        return $account ? $account->amount : 0;
    }
}
