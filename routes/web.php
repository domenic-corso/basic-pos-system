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

Route::get('/add-product', function () {
    return view('add_product', [
    	'product' => new Product()
    ]);
});

Route::get('/edit-product/{product}', function (Product $product) {
    return view('edit_product', [
        'product' => new Product()
    ]);
});

Route::get('/product-list', function () {
    return view('product_list');
});

Route::get('/product/{product}', function (Product $product) {
    return dd($product);
});

Route::put('/product', 'ProductController@create');

Route::post('/product/{product}', function (Product $product) {
    return 'POST /product';
});

Route::delete('/product/{product}', function (Product $product) {
    return 'DELETE /product';
});

/* APIs/Data Retrieval */
Route::get('/get-products-by-category', function (Request $request) {
    return(\App\Category::getProductsByCategoryId($request->cid)->sortBy('created_at')->toJson());
});
