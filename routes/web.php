<?php

use App\Http\Controllers\DepartureController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', [DepartureController::class, 'wizard'])->name('departure.wizard');
Route::post('/store-step', [DepartureController::class, 'storeStep'])->name('departure.storeStep');
Route::post('/finish', [DepartureController::class, 'store'])->name('departure.store');
Route::get('/page/{slug}', [DepartureController::class, 'show'])->name('departure.show');
