<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Promotions;

class PromotionTest extends TestCase
{
    public function testMostExpensive () {
        $orderItems = array(
            new \App\OrderItem([
                'product_name' => 'Cappucino',
                'size' => 'regular',
                'total' => 4.60
            ]),
            new \App\OrderItem([
                'product_name' => 'Caramel Slice',
                'size' => 'fixed',
                'total' => 5.60
            ]),
            new \App\OrderItem([
                'product_name' => 'Coffee Frappe',
                'size' => 'large',
                'total' => 6.40
            ]),
        );

        $this->assertEquals($orderItems[2], Promotions::findMostExpensive($orderItems));
    }
}
