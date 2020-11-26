<?php

namespace App\Http\Controllers;

use App\Services\StoreService;

class StoreController extends Controller
{
    /**
     * Reset data
     */
    public function reset()
    {
        (new StoreService())->createStore();

        return response()->json(null);
    }
}
