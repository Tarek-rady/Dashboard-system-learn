<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Str;

class OrderObserver
{

    public function creating(Order $order)
    {
        do {
            $code = 'ORD-' . Str::upper(Str::random(8));
        } while (Order::where('code', $code)->exists());

        $order->code = $code;
    }
}
