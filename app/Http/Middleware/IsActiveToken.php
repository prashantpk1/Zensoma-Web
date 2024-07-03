<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\OauthAccessTokens;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsActiveToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Check if the request has a valid access token
            $user = Auth::userOrFail();
            return $next($request);
        } catch (\Exception $e) {
            // Handle the case when the token is not valid
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
