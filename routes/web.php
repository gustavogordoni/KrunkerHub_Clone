<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Livewire\MarketIndex;
use App\Livewire\Inventory;
use App\Livewire\MySales;
use App\Livewire\ItemDetail;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('market');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/market', MarketIndex::class)->name('market');
    Route::get('/inventory', Inventory::class)->name('inventory');
    Route::get('/my-sales', MySales::class)->name('my-sales');
    Route::get('/item/{id}', ItemDetail::class)->name('item-detail');
});

require __DIR__ . '/auth.php';
