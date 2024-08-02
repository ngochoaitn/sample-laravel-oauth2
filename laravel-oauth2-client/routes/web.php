<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum'])->get('/home', [HomeController::class, 'index'])->name('home');
Route::middleware(['auth:sanctum'])->get('/home2', [HomeController::class, 'index2'])->name('home2');

Route::get('auth/redirect', [App\Http\Controllers\AuthController::class, 'redirectToProvider']);
Route::get('auth/callback', [App\Http\Controllers\AuthController::class, 'handleProviderCallback']);

Route::get('/login', [App\Http\Controllers\AuthController::class, 'redirectToProvider'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
