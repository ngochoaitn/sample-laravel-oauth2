<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/setup', [HomeController::class, 'setup']);
Route::post('/setup', [HomeController::class, 'createDb']);

Route::get('/admin/auth', function(Request $request){
    $queryParams = $request->query(); // OAuth2
    return view('login', compact('queryParams'));
})->name('login');

Route::get('/admin/auth/logout', [AuthController::class, 'logout']);
Route::post('/admin/auth', [AuthController::class, 'login']);


Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/active-user/{id}', [AdminController::class, 'toogleActiveUser']);
Route::get('/admin/reset-profile-status', [AdminController::class, 'resetProfileStatus']);
Route::get('/admin/set-storage-type', [AdminController::class, 'setStorageType']);

// Route::group([
//     'as' => 'passport.',
//     'prefix' => config('passport.path', 'oauth'),
//     'namespace' => '\Laravel\Passport\Http\Controllers',
// ], function () {
//     Route::get('/authorize', function(Request $request) {
//         // die('okla');
//     });
// });