<?php

namespace App\Http\Controllers;

use App\Product;
use \Illuminate\Http\Request;

class ProductController extends Controller {

	public function create (Request $request) {
		$suppliedProperties = $request->all();
		$errorList = Product::validateWithErrors($suppliedProperties);

		/* If there were errors with the form input, redirect back and
		inform user of errors. */
		if (count($errorList) > 0) {
			return redirect('/add-product')
				->withInput()
				->withErrors($errorList);
		}

		/* If the input data is valid, then make a new Product instance,
		optimizing the input for business use (rounding to 5c, formatting
		data etc.) */
		$newProduct = Product::applyProperties(new Product(), $suppliedProperties);

		/* Save product to the database. */
		$newProduct->save();

		/* Inform the user on the next page that the product has been added
		successfully. */
		$request->session()->flash('success', $newProduct->name.' has been added!');

		/* If the user chose to 'Save & Add Another', redirect back. */
		if ($request->has('add_another')) {
			return redirect('/add-product');
		}

		return redirect('/product-list');
	}

    public function update (Request $request, Product $product) {
		$suppliedProperties = $request->all();

        /* If the name has not been changed, do not check for uniqueness when
        validating the properties of the product - otherwise if the name has
        been changed, make sure it's not the same name as any other product. */
        $allowDuplicates = ($product->name === $suppliedProperties['name']) ? true : false;

		$errorList = Product::validateWithErrors($suppliedProperties, $allowDuplicates);

		/* If there were errors with the form input, redirect back and
		inform user of errors. */
		if (count($errorList) > 0) {
			return redirect('/edit-product/' . $product->id)
				->withInput()
				->withErrors($errorList);
		}

		/* If the input data is valid, then update this Product instance,
		optimizing the input for business use (rounding to 5c, formatting
		data etc.) */
        $product = Product::applyProperties($product, $suppliedProperties);

        /* Reflect the changes in the database. */
        $product->save();

        return redirect('/product-list');
    }

}
