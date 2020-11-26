<?php

namespace App\Services;

use App\Models\Event;

class EventService
{

    private $destination;
    private $origin;
    private $amount;
    private $type;

    public function __construct($type, $destination, $origin, $amount)
    {
        $this->type         = $type;
        $this->destination  = $destination;
        $this->origin       = $origin;
        $this->amount       = $amount;
    }

    public function execute()
    {
        switch ($this->type) {
            case 'deposit':
                return (new Event())->deposit($this->destination, $this->amount);
                break;
            case 'withdraw':
                return (new Event())->withdraw($this->origin, $this->amount);
                break;
            case 'transfer':
                return (new Event())->transfer($this->origin, $this->destination, $this->amount);
                break;
        }
    }
}
