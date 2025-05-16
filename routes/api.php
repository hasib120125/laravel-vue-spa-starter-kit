<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\TerritoryController;

Route::apiResource('customers', CustomerController::class);
Route::get('all-customers', [CustomerController::class, 'getCustomers']);
Route::apiResource('territories', TerritoryController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
