<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Order;

class OrderTest extends TestCase
{

    public function getTypicalJsonOrderString () : string {
        return '{
            "order_items": [
                {
                    "product_id": 2,
                    "size": "small"
                },
                {
                    "product_id": 3,
                    "size": "fixed"
                },
                {
                    "product_id": 2,
                    "size": "small"
                },
                {
                    "product_id": 3,
                    "size": "fixed"
                },
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
    }

    public function testOrderJsonParse () {
        /* Should be using a test database here. */
        $jsonString = self::getTypicalJsonOrderString();

        $this->assertTrue(Order::validateJsonOrder($jsonString));
    }

    public function testOrderProcessJson () {
        $jsonString = self::getTypicalJsonOrderString();

        $this->assertTrue(is_array(Order::processJsonOrder($jsonString)));
    }
}
