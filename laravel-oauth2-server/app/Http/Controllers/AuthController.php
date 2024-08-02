<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function login(Request $request) {
        $user = User::where('role', 2)->where('user_name', $request->username)->where('password', $request->password)
                ->where('active', '<>', 0)->first();

        if ($user == null)
            return redirect()->back()->with('error', 'Login failed');

        Auth::login($user);
        // OAuth2
        $redirect_uri = Session::get('redirect_uri', []);
        if($redirect_uri) {
            Session::forget('redirect_uri');
            return Redirect::to($redirect_uri);
        }
        return redirect('/admin');
    }

    public function logout(){
        $user = Auth::user();
        if($user) {
            $user->tokens->each(function($token, $key) {
                $refreshToken = $token->refreshToken;
                if ($refreshToken) {
                    $refreshToken->delete();
                }
                $token->delete();
            });
        }


        Auth::logout();
        return redirect('/admin/auth');
    }
}
