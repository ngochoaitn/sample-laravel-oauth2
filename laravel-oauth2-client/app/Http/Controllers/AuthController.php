<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('laravelpassport')->redirect();
    }

    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('laravelpassport')->user();
            $user_info = $user->user['data'];
            // die(json_encode($user_info));
            $auth_user = $this->findOrCreateUser($user_info);
            Auth::login($auth_user, true);
        }
        catch(\Exception $e) {}
        
        return redirect()->to('/home');
    }

    public function findOrCreateUser($passportUser)
    {
        $authUser = User::where('email', $passportUser['user_name'])->first();
        if ($authUser) {
            return $authUser;
        }

        return User::create([
            'name' => $passportUser['display_name'],
            'email' => $passportUser['user_name'],
            'provider' => 'passport-oauth2',
        ]);
    }

    public function logout(){
        Auth::logout();
        $url = env('LARAVELPASSPORT_HOST') . '/admin/auth/logout?redirect_url=http://localhost:8081/home';
        return redirect()->to($url);
    }
}