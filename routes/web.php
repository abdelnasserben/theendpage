<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartureController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', [DepartureController::class, 'wizard'])->name('departure.wizard');
Route::post('/store-step', [DepartureController::class, 'storeStep'])->name('departure.storeStep');
Route::post('/finish', [DepartureController::class, 'store'])->name('departure.store');
Route::get('/page/{slug}', [DepartureController::class, 'show'])->name('departure.show');
Route::post('/page/{slug}/comment', [DepartureController::class, 'comment'])->name('departure.comment');
Route::post('/page/{slug}/vote',    [DepartureController::class,'vote'])->name('departure.vote');
Route::get('/hall-of-fame',         [DepartureController::class,'hallOfFame'])->name('departure.hallOfFame');
Route::get('/histories',            [DepartureController::class,'histories'])->name('departure.histories');


Route::get('register', [RegisterController::class, 'showForm'])->name('register.form');
Route::post('register', [RegisterController::class, 'register'])->name('register');

Route::get('login', [LoginController::class, 'showForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login');

Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

Route::middleware('auth')->get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

Route::middleware('auth')->delete('/account', [AccountController::class,'destroy'])->name('account.destroy');