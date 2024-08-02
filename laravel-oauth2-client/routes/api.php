<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('verify.site.a.token')->get('/user', function (Request $request) {
//     $site_a_user = Session::get('site_a_user');
//     if($site_a_user){
//         return $site_a_user;
//     }
//     return abort(404);
//     // return $request->user();
// });


Route::middleware('verify.site.a.token')->get('/get-token', function (Request $request) {
    $site_a_user = Session::get('site_a_user');
    if($site_a_user){
        $user = User::where('email', strtolower($site_a_user['user_name']))->first();
        if($user){
            $user->tokens()->delete();
            $token = $user->createToken('token');
            $resp = ['token' => $token->plainTextToken];
            return $resp;
        }
        return $site_a_user;
    }
    return abort(404);
    // return $request->user();
});
