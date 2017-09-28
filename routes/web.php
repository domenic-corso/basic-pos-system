<?php

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

Route::get('/new-product', function () {
    return 'New Product Form';
});

Route::get('/product-list', function () {
    return 'Product Listing';
});

Route::get('/product/{$product}', function (Product $product) {
    return dd($product);
});

Route::put('/product/', function () {
    return 'PUT /product';
});

Route::post('/product/{$product}', function (Product $product) {
    return 'POST /product';
});

Route::delete('/product/{$product}', function (Product $product) {
    return 'DELETE /product';
});