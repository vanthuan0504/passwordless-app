<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MagicLinkController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::post("/login/magic", [MagicLinkController::class, 'sendMagicLink']);
Route::get('/login/magic/{token}', [MagicLinkController::class, 'loginWithMagicLink']);

Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('custom-login', [AuthController::class, 'customLogin'])->name('login.custom');

Route::get('register', [AuthController::class, 'regitration'])->name('register');
Route::post('custom-registration', [AuthController::class, 'customRegistration'])->name('register.custom');

Route::get('signout', [AuthController::class, 'signout'])->name('signout');
