<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('vendor-api')->group(function () {
        
    //Product Category APIs
    Route::post('save/category',   'ProductCategoryController@SaveCategory')->name('vendor.save.category');
    Route::get('get/category/list',   'ProductCategoryController@getCategoryList')->name('get.category.list');
    Route::get('get/category/{category_id}',   'ProductCategoryController@getCategoryById')->name('get.category');

    // Product Variant APIs
    Route::get('get/product-variants',   'ProductVariantController@getProductVariants')->name('get.product.variants');

    //Products
    Route::get('get-products', 'ProductController@getProductsList')->name('products.list');
    Route::get('get-product/{id}', 'ProductController@getProductById')->name('product');
    Route::post('save-product', 'ProductController@saveProduct')->name('save.product');
    Route::put('update-product/{id}', 'ProductController@updateProduct')->name('update.product');
    Route::get('remove-product-image/{product_id}/{image_index}', 'ProductController@removeProductImage')->name('remove.product.image');
    
    //Category products by category id 
    Route::get('get-category-products/{categoryId}', 'ProductCategoryController@getCategoryProducts')->name('get.category.products');
    Route::get('get-only-category-products/{category}', 'ProductCategoryController@getOnlyCategoryProducts')->name('get.only.category.products');
    
    //Order APIs
    Route::get('get-order/{id}', 'OrderController@getOrderById')->name('order');
    Route::get('get-orders-list', 'OrderController@getOrderList')->name('orders.list');
    Route::post('place-order', 'OrderController@saveOrder')->name('save-order');

});