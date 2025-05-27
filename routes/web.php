<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Http\Livewire\MarketIndex;
use App\Http\Livewire\Inventory;
use App\Http\Livewire\MySales;
use App\Http\Livewire\Trading;
use App\Http\Livewire\ItemSearch;
use App\Http\Livewire\UserProfile;
use App\Livewire\Inventory as LivewireInventory;
use App\Livewire\ItemSearch as LivewireItemSearch;
use App\Livewire\MarketIndex as LivewireMarketIndex;
use App\Livewire\MySales as LivewireMySales;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/market', LivewireMarketIndex::class)->name('market');
    Route::get('/inventory', LivewireInventory::class)->name('inventory');
    Route::get('/my-sales', LivewireMySales::class)->name('my-sales');
    Route::get('/item-serch', LivewireItemSearch::class)->name('item-serch');

});

require __DIR__.'/auth.php';
