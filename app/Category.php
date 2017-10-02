<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
	public function products () : HasMany {
		return $this->hasMany('App\Product');
	}

    public static function getProductsByCategoryId (string $cid) : Collection {
		if ($cid == 'all') {
			$allProducts = Product::all();

			if ($allProducts instanceof Collection) {
				return $allProducts;
			}
		}

		$category = Category::find(intval($cid));

		if (is_null($category)) {
			return new Collection();
		}

		$fetchedCollection = $category->products;
		if ($fetchedCollection instanceof Collection) {
			return $fetchedCollection;
		}

		return new Collection();
    }
}
