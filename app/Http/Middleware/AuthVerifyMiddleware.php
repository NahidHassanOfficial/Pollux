<?php
namespace App\Http\Middleware;

use App\Helper\Response;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthVerifyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->cookie('auth_token');
        if (! $token) {
            return redirect()->route('loginPage');
        }

        $accessToken = PersonalAccessToken::findToken($token);
        if (! $accessToken || ! $accessToken->tokenable) {
            return redirect()->route('loginPage');
        }

        Auth::setUser($accessToken->tokenable);

        return $next($request);

    }
}
