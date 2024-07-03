<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class is_subadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->user_type == 1) {

                if (Auth::user()->is_approved == 1) {

                    return $next($request);
                } else {
                    Auth::logout();
                    return redirect()->intended(RouteServiceProvider::LOGIN)->with('error', 'Contect To Admin Your Account is Temprary Deactivated');
                }
            } else {

                return redirect()->route('do-have-permission');

            }
        } else {
            return redirect()->route('login');
        }

    }
}
