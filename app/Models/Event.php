<?php

namespace App\Models;

use App\Services\StoreService;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function __construct()
    {
        //Get fake store service
        $this->store = (new StoreService);
    }

    /**
     * @param string $destination Destination account
     * @param float $amount Amount to transfer
     */
    public function deposit($destination, $amount)
    {
        $account = (new Account());
        $accountDetails = $account->getAccount($destination);

        //add amount to destination account
        if (!$accountDetails) {
            $accountDetails = $account->addAccount(['id'  => $destination, 'amount'   => $amount]);
        } else {
            $accountDetails->amount += $amount;
            $account->updateAccount($accountDetails);
        }

        return [
            "data"  => [
                "destination" => [
                    "id" => $accountDetails->id,
                    "balance" => $accountDetails->amount
                ]
            ],
            "status"    => 201
        ];
    }

    /**
     * @param string $origin Origin account
     * @param float $amount Amount to transfer
     */
    public function withdraw($origin, $amount)
    {
        $account = (new Account());
        $accountDetails = $account->getAccount($origin);

        if ($accountDetails) {
            //remove amount from origin account
            $accountDetails->amount -= $amount;
            $account->updateAccount($accountDetails);

            return [
                "data" => [
                    "origin" => [
                        "id" => $accountDetails->id,
                        "balance" => $accountDetails->amount
                    ]
                ],
                "status"    => 201
            ];
        }

        return ["data"  => 0, "status" => 404];
    }

    /**
     * @param string $origin Origin account
     * @param string $destination Destination account
     * @param float $amount Amount to transfer
     */
    public function transfer($origin, $destination, $amount)
    {
        $account = (new Account());

        //Get origin and destination account
        $originAccountDetails = $account->getAccount($origin);
        $destinationAccountDetails = $account->getAccount($destination);

        if ($originAccountDetails) {
            //if destination account does not exists
            //create it
            if (!$destinationAccountDetails) {
                $destinationAccountDetails = $account->addAccount(['id' => $destination, 'amount'   => 0]);
            }

            //remove amount from origin account
            $originAccountDetails->amount -= $amount;
            $account->updateAccount($originAccountDetails);

            //transfer to destination account
            $destinationAccountDetails->amount += $amount;
            $account->updateAccount($destinationAccountDetails);

            return [
                "data" => [
                    "origin" => [
                        "id" => $originAccountDetails->id,
                        "balance" => $originAccountDetails->amount
                    ],
                    "destination" => [
                        "id" => $destinationAccountDetails->id,
                        "balance" => $destinationAccountDetails->amount
                    ]
                ],
                "status"    => 201
            ];
        }

        return ["data"  => 0, "status" => 404];
    }
}
