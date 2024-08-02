<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $auth_user = $request->user();
        return view('home', compact('auth_user'));
    }

    public function index2(Request $request)
    {
        $auth_user = $request->user();
        return view('home2', compact('auth_user'));
    }
}