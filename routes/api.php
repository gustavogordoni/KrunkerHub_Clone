<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ItemController;
use App\Http\Controllers\api\MarketController;
use App\Http\Controllers\api\ProfileController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware([])->group(function () {
    Route::get('market', [MarketController::class, 'index']);
    Route::get('items', [ItemController::class, 'index']);
    Route::get('items/{id}', [ItemController::class, 'show']);
    Route::get('profiles/{nickname}', [ProfileController::class, 'show']);
});