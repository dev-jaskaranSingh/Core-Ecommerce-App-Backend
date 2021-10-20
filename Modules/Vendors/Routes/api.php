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

    Route::prefix('vendor-api')->group(function() {
        
        //Product Category APIs
        Route::post('save/category'     ,   'ProductCategoryController@SaveCategory')->name('vendor-save-category');
        Route::get('get/category/list'  ,   'ProductCategoryController@getCategoryList')->name('get-category-list');
        Route::get('get/category/{category_id}'  ,   'ProductCategoryController@getCategoryById')->name('get-category');
        
        // Product Variant APIs
        Route::get('get/product-variants'  ,   'ProductVariantController@getProductVariants')->name('get-product-variants');
    
    });