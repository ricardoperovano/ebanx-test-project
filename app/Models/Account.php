<?php

namespace App\Models;

use App\Services\StoreService;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $store;

    //Get fake Store
    public function __construct()
    {
        $this->store = (new StoreService);
    }

    /**
     * @param string $id Account Id
     */
    public function getAccount(string $id)
    {
        //Get accounts inside store
        $accounts   = $this->store->getStore()->accounts;

        //Filter account
        $account    = array_values(array_filter($accounts, function ($item) use ($id) {
            return $item->id ===  $id;
        }));

        //return account if exists
        if (isset($account[0]))
            return $account[0];


        return null;
    }

    /**
     * Add new object to accounts
     * @param array $account Account data
     */
    public function addAccount(array $account)
    {
        $accounts   = $this->store->getStore()->accounts;

        array_push($accounts, $account);

        $dataString = json_encode($accounts);

        $jsonString = '{ "accounts": ' . $dataString . '}';

        $this->store->createStore($jsonString);

        return $this->getAccount($account['id']);
    }

    /**
     * Add new object to accounts
     * @param object $data Object to update
     */
    public function updateAccount($data)
    {
        $accounts   = $this->store->getStore()->accounts;

        $accounts   = array_filter((array)$accounts, function ($item) use ($data) {
            return $item->id != $data->id;
        });

        $accounts = array_merge($accounts, [
            'id'        => $data->id,
            'amount'    => $data->amount
        ]);

        $dataString = json_encode($accounts);

        $jsonString = '{ "accounts": [' . $dataString . ']}';

        $this->store->createStore($jsonString);

        return $this->getAccount($data->id);
    }
}
