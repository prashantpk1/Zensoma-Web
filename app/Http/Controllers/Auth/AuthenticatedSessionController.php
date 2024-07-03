<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('Admin.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $validated = [];
        $validated['email'] = "required|string|email";
        $validated['password'] = "required|string";
        $request->validate($validated);

        $email = $request->email;
        $data = User::where('email', $request->email)->first();
        if (!empty($data)) {
            if ($data->user_type == 0) {
                return redirect()->intended(RouteServiceProvider::LOGIN)->with('error', 'Unaothorized User');
            } else {

                if ($data->is_approved != 1) {
                    return redirect()->intended(RouteServiceProvider::LOGIN)->with('error', 'Connect To Admin Your Account is Temporarily Deactivated');
                }
                $request->authenticate();
                $request->session()->regenerate();
                $user = Auth::user();
                if ($user->user_type == 2) { //admin

                    return redirect()->intended(RouteServiceProvider::HOME);

                }
                if ($user->user_type == 1) { // sub admin

                    return redirect()->intended(RouteServiceProvider::CALENDAR);

                }

            }

        } else {
            return redirect()->intended(RouteServiceProvider::LOGIN)->with('error', 'Email or password is incorrect');
        }

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
