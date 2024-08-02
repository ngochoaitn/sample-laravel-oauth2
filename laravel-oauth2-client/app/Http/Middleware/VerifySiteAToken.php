<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VerifySiteAToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Lấy access_token từ header Authorization
        $accessToken = $request->header('Authorization');

        if (!$accessToken) {
            return response()->json(['error' => 'Authorization token is missing'], 401);
        }

        // Loại bỏ 'Bearer ' khỏi token
        $accessToken = str_replace('Bearer ', '', $accessToken);

        // Gửi yêu cầu đến site A để xác thực token
        $response = Http::withToken($accessToken)
            ->get('http://gpmcloud-privateserver.test/api/user'); // Đảm bảo endpoint này chính xác

        // Kiểm tra phản hồi từ site A
        if ($response->successful()) {
            // Token hợp lệ
            Session::put('site_a_user', $response['data']);
            return $next($request);
        } else {
            // Token không hợp lệ
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}