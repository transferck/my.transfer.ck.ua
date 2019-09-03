<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{

    /**
     * @param Order $order
     */
    public function saving(Order $order)
    {
        if (
            $order->isDirty('ticketfree_reason') &&
            in_array($order->ticketfree_reason, Order::PERIOD_BONUSES)
        ) {
            $order->ticketfree_reason_date = new \DateTime();
        }
    }
}
