<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Order;

class OrderTest extends TestCase
{
    public function testOrderJsonParse () {
        /* Should be using a test database here. */
        $jsonString = '{
            "order_items": [
                {
                    "product_id": 2,
                    "size": "small"
                },
                {
                    "product_id": 3,
                    "size": "fixed"
                }
            ]
        }';

        $this->assertTrue(Order::validateJsonOrder($jsonString));
    }
}
