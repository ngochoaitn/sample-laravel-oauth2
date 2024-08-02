<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens as SanctumHasApiTokens;
use Laravel\Passport\HasApiTokens;// as PassportHasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    // OAuth2 tùy chỉnh tìm kiếm user
    public function findForPassport($username) {
        return self::where('user_name', $username)->first();
    }

    // OAuth2 tùy chỉnh so sánh mật khẩu
    public function validateForPassportPasswordGrant($password) {
        return $password == $this->password;
    }
}
