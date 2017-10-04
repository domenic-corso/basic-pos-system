<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
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
}
