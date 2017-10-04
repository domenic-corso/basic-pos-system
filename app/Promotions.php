<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotions extends Model
{
    public static function findPromotion (array $orderItems) {
        $results = array(
            self::promotion10POff($orderItems),
            self::promotion20POff($orderItems),
        );

        $bestPromotion = $results[0];
        foreach ($results as $promotion) {
            if ($promotion["discount"] > $bestPromotion["discount"]) {
                $bestPromotion = $promotion;
            }
        }

        return $bestPromotion;
    }

    public static function promotion10POff (array $orderItems) : array {
        $result = array(
            "discount" => 0.00,
            "description" => "Buy 1 at 10% off"
        );

        if (count($orderItems) >= 1) {
            $mostExpensive = self::findMostExpensive($orderItems);
            $result["discount"] = number_format(Product::round5Cents($mostExpensive->total * .1), 2);
        }

        return $result;
    }

    public static function promotion20POff (array $orderItems) : array {
        $result = array(
            "discount" => 0.00,
            "description" => "Buy 6 at 20% off"
        );

        if (count($orderItems) >= 6) {
            $mostExpensiveItems = array();
            $totalOfExpensive = 0.00;

            /* Find the 6 most expensive items. */
            for ($i = 0; $i < 6; $i++) {
                $mostExpensiveItems[] = self::findMostExpensive($orderItems);
                $keyToRemove = array_search($mostExpensiveItems[$i], $orderItems);
                unset($orderItems[$keyToRemove]);
            }

            /* Find total. */
            foreach ($mostExpensiveItems as $orderItem) {
                $totalOfExpensive += $orderItem->total;
            }

            $result["discount"] = number_format(Product::round5Cents($totalOfExpensive * .2), 2);
        }

        return $result;
    }

    /* Finds the most expensive item of an array of OrderItems. */
    public static function findMostExpensive (array $orderItems) : OrderItem {
        if (!count($orderItems)) { return null; }

        $mostExpensive = array_values($orderItems)[0];
        foreach ($orderItems as $ordItem) {
            if ($ordItem->total > $mostExpensive->total) {
                $mostExpensive = $ordItem;
            }
        }

        return $mostExpensive;
    }

}
