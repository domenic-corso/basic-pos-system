<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceDefinition extends Model
{
    public function toStringMultipleLines () : string {
        $html = '';

        $html .= 'Small: $' . htmlentities($this->small) . '<br />';
        $html .= 'Regular: $' . htmlentities($this->regular) . '<br />';
        $html .= 'Large: $' . htmlentities($this->large) . '<br />';

        return $html;
    }

    public function toStringSingleLine () : string {
        return 'S: $' . htmlentities($this->small) . ' R: $' . htmlentities($this->regular) . ' L: $' . htmlentities($this->large);
    }
}
