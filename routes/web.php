<?php

use \Illuminate\Http\Request;

use \App\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin-panel', function () {
    return view('admin_panel');
});

Route::get('/take-orders', function () {
    return view('take_orders');
});

/* Add Product - Form */
Route::get('/add-product', function () {
    return view('add_product', [
    	'product' => new Product()
    ]);
});

/* Edit Product - Form */
Route::get('/edit-product/{product}', function (Product $product) {
    return view('edit_product', [
        'product' => $product
    ]);
});

/* Delete Product - Confirmation */
Route::get('/delete-product/{product}', function (Product $product) {
    return view('delete_product', [
        'product' => $product
    ]);
});

Route::get('/product-list', function () {
    return view('product_list');
});

/* Debug Product */
Route::get('/product/{product}', function (Product $product) {
    return dd($product);
});

/* Add Product */
Route::put('/product', 'ProductController@create');

/* Edit Product */
Route::post('/product/{product}', 'ProductController@update');

/* Delete Product */
Route::delete('/product/{product}', 'ProductController@delete');

/* APIs/Data Retrieval */
Route::get('/get-products-by-category', function (Request $request) {
    return(\App\Category::getProductsByCategoryId($request->cid)->sortBy('created_at')->toJson());
});
