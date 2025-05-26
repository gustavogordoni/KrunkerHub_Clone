<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('item/', [ItemController::class, 'index']);
Route::get('sale/', [SaleController::class, 'index']);
Route::get('user/', [UserController::class, 'index']);
