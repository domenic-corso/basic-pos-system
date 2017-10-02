<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\MessageBag;
use Validator;

class Product extends Model
{
	protected $fillable = ['name', 'short_name', 'category_id', 'price_definition_id', 'fixed_price'];

	/* This function takes care of any business logic given an array of properties.
	This includes:
		- Rounding numbers to 0.05,
		- Converting the short_name into uppercase
		- Deciding between price definition or fixed price */
	public static function applyProperties (Product $product, array $properties) : Product {
		$product->fill($properties);

		/* Round fixed price to nearest 5 cents. */
		$product->fixed_price = round($product->fixed_price / 5, 2) * 5;
		$product->short_name = strtoupper($product->short_name);

		/* If a price definition is provided, prioritize that and remove the fixed price data. */
		if (!empty($product->price_definition_id)) {
			$product->fixed_price = null;
		}
		else {
			$product->price_definition_id = null;
		}

		return $product;
	}

	/* Checks a given array of properties against the validator rules as well
	as some business logic. Returns an array of error messages. */
	public static function validateWithErrors (array $properties) : MessageBag {
		$validator = Validator::make($properties, self::getValidatorRules());

		/* If the properties are not valid and no price information at all was given,
		invalid Product. */
		if ($validator->fails()) {
			return $validator->errors();
		}

		if (empty($properties['price_definition_id']) && empty($properties['fixed_price']) 
			&& $properties['fixed_price'] != 0) {
			return new MessageBag(array('You must choose either a price group or a fixed price.'));
		}

		return new MessageBag();
	}

	/* Calls 'validateWithErrors' but returns a boolean format. */
	public static function validateProduct (array $properties) : bool {
		return (count(self::validateWithErrors($properties)) == 0);
	}

    private static function getValidatorRules () : array {
    	$namePattern = '/^[a-z\d &\']+$/i';

    	return [
    		'name' => 'required|unique:products|min:3|max:60|filled|regex:'.$namePattern,
    		'short_name' => 'required|unique:products|min:3|max:12|filled|regex:'.$namePattern,
    		'category_id' => 'required|integer|exists:categories,id',
    		'price_definition_id' => 'integer|exists:price_definitions,id|nullable',
    		'fixed_price' => 'numeric|min:0|max:50|nullable'
    	];
    }
}
