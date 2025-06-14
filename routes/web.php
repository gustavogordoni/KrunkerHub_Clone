<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Livewire\MarketIndex;
use App\Livewire\Inventory;
use App\Livewire\MySales;
use App\Livewire\ItemDetail;
use App\Livewire\Profile;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('market');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/market/{search?}', MarketIndex::class)->name('market');
Route::get('/item/{id}', ItemDetail::class)->name('item.show');
Route::get('/profile/{nick}', Profile::class)->name('profile.show');

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/inventory', Inventory::class)->name('inventory');
    Route::get('/my-sales', MySales::class)->name('my-sales');     
});

require __DIR__ . '/auth.php';
