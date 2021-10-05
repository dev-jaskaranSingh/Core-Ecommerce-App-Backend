<?php

use Illuminate\Http\Request;
use Modules\MarketingEmployee\Http\Controllers\MarketingEmployeeController;

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
Route::group(['prefix'=> '/marketingemployee'],function(){
    Route::post('/login', [MarketingEmployeeController::class, 'login'])->name('login');
});
