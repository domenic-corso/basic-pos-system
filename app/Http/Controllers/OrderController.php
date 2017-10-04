<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Order;
use App\OrderItem;

class OrderController extends Controller
{
    public function store (Request $request) {
        $orderJson = $request->order_json;

        /* Deny any bad order JSON strings. */
        if (empty($orderJson) || empty($processedOrder = Order::processJsonOrder($orderJson))) {
            return 'BAD_FORMAT';
        }

        /* Make a new Order instance and use fillable to set attributes. */
        $order = new Order($processedOrder);
        $order->save();

        /* Make new instances of OrderItem for each processed order_item. */
        foreach ($processedOrder["order_items"] as $ordItem) {
            $orderItemInstance = new OrderItem($ordItem);
            $orderItemInstance->order_id = $order->id;
            $orderItemInstance->save();
        }
    }
}
