<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = ['total', 'discounted', 'discount_description'];

    public function order_items () : HasMany {
        return $this->hasMany('App\OrderItem');
    }

    /* The register will add orders to the system by POST'ing a JSON string
    containing order information. This needs to be validated and made sure
    it's in the right format or else the system will reject the order.

    A typical JSON String might look like this:
    {
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
    }
     */
    public static function validateJsonOrder (string $jsonString) : bool {
        $object = json_decode($jsonString);

        if (is_null($object)) { return false; }
        if (empty($object->order_items)) { return false; }
        if (!is_array($object->order_items)) { return false; }

        foreach ($object->order_items as $ordItem) {
            /* 'product_id' and 'size' attributes must be present. */
            if (empty($ordItem->product_id) || empty($ordItem->size)) { return false; }

            /* 'size' must only have a specific set of values. */
            $validSizeValues = array('fixed', 'small', 'regular', 'large');
            if (!in_array($ordItem->size, $validSizeValues)) { return false; }

            /* Try to resolve the product_id to a Product instance. */
            if (is_null(Product::find($ordItem->product_id))) { return false; }
        }

        return true;
    }

    /* This will accept a JSON String Order and process it into an associative
    array of format: [
        "total": 0.00,
        "subtotal": 0.00,
        "discounted": 0.00,
        "discount_description": "",
        "order_items": [
            {
                "product_name": "",
                "size": "",
                "total": ""
            }
        ]
    ]
    or NULL if it cannot be processed. */
    public static function processJsonOrder (string $jsonString) {
        if (!self::validateJsonOrder($jsonString)) { return false; }
        $order = json_decode($jsonString);
        $orderItems = $order->order_items;

        $processed = array();

        $processed["total"] = 0.00;
        $processed["sub_total"] = 0.00;
        $processed["discounted"] = 0.00;
        $processed["discount_description"] = "";
        $processed["order_items"] = array();

        $orderItemList = array();

        /* Process each order item. */
        foreach ($orderItems as $ordItem) {
            /* Resolve the product_id attribute of $ordItem to a Product Instance. */
            $productInstance = Product::find($ordItem->product_id);

            $product_name = $productInstance->name;
            $size = $ordItem->size;

            $total = 0.00;

            /* If the product is put through as having a fixed size, make the total
            for this OrderItem as the fixed price of the product. */
            if ($size === 'fixed') {
                $total = $productInstance->fixed_price;
            }

            /* Otherwise if the product is put through and a size is specified,
            use the size attribute on the products' price definition to get the total
            for this OrderItem */
            if (!is_null($productInstance->price_definition)) {
                $total = $productInstance->price_definition[$ordItem->size];
            }

            /* Format OrderItem array, readable by the client register. */
            $orderItemAssocArray = array (
                "product_name" => $product_name,
                "size" => $size,
                "total" => floatval($total)
            );

            $processed["order_items"][] = $orderItemAssocArray;
            $orderItemList[] = new OrderItem($orderItemAssocArray);
        }

        /* Find the total. */
        foreach ($processed["order_items"] as $ordItem) {
            $processed["sub_total"] += $ordItem["total"];
        }

        $processed["sub_total"] = number_format($processed["sub_total"], 2);

        /* Calculate promotions. */
        $promotionResult = Promotions::findPromotion($orderItemList);
        $processed["discounted"] = $promotionResult["discount"];
        $processed["discount_description"] = $promotionResult["description"];

        $processed["total"] = number_format(floatval($processed["sub_total"]) - floatval($processed["discounted"]), 2);

        return $processed;
    }
}
