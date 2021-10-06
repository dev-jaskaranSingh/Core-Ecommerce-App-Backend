<?php

use Modules\MarketingEmployee\Http\Controllers\MarketingEmployeeController;
use Modules\MarketingEmployee\Http\Controllers\MarketingLeadController;

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
Route::group(['prefix' => '/marketingemployee'], function () {
    Route::post('/login', [MarketingEmployeeController::class, 'login'])->name('login');
    Route::post('/save-lead', [MarketingLeadController::class, 'saveLead'])->name('saveOrder');
    Route::get('/business-types', 'MarketingEmployeeController@businessTypes')->name('business-types');
    Route::get('/get-employee-by-mobile/{mobile}', [MarketingLeadController::class, 'getEmployeeByMobile'])->name('employee.by.mobile');
    Route::get('/get-employee-leads/{employee_id}', [MarketingLeadController::class, 'getEmployeeLeads'])->name('employee.leads');
    Route::get('/get-employee-leads-count/{employee_id}', [MarketingLeadController::class, 'getEmployeeLeadsCount'])->name('employee.leads.count');
});
