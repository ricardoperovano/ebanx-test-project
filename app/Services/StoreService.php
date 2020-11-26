<?php

namespace App\Services;

/**
 * This is a fake store service
 * It stores data in a json file temporarlly
 */
class StoreService
{

    public function getStore()
    {
        $jsonString = file_get_contents("store.json");

        return json_decode($jsonString);
    }

    public function createStore($data = null)
    {

        $store = fopen("store.json", "w");

        if ($data)
            fwrite($store, $data);
        else
            fwrite($store, "{ \"accounts\": []}");

        fclose($store);
    }
}
