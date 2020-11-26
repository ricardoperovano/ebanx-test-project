<?php

namespace App\Http\Controllers;

use App\Services\EventService;

class EventController extends Controller
{
    /**
     * @param string $type
     * @param string $destination
     * @param float $amount
     */
    public function create()
    {
        $type           = request()->get('type');
        $destination    = request()->get('destination');
        $orgin          = request()->get('origin');
        $amount         = request()->get('amount');

        $response = (new EventService($type, $destination, $orgin, $amount))->execute();

        return response()->json($response['data'], $response['status']);
    }
}
