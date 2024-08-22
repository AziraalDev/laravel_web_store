<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderCreatedEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(public Order $order)
    {
        Log::info('OrderCreatedEvent dispatched');
    }
}
