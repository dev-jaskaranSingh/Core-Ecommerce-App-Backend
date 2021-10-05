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

Route::prefix('marketingemployee')->group(function() {
    Route::get('/', 'MarketingEmployeeController@index')->name('employee-list');
    Route::get('/create', 'MarketingEmployeeController@create')->name('employee-create');
    Route::get('/edit/{employee}', 'MarketingEmployeeController@edit')->name('employee-edit');
    Route::post('/store', 'MarketingEmployeeController@store')->name('employee-store');
    Route::post('/update/{employee}', 'MarketingEmployeeController@update')->name('employee-update');
    Route::get('/delete/{employee}', 'MarketingEmployeeController@destroy')->name('employee-delete');
});
