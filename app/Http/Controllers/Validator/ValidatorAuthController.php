<?php

namespace App\Http\Controllers\Validator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ValidatorAuthController extends Controller
{
    /**
     * Display the validator login view.
     */
    public function showLoginForm(): View
    {
        return view('validator.auth.login');
    }

    /**
     * Handle an incoming validator authentication request.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        // Authenticate using validator guard
        $credentials = $request->only('email', 'password');
        
        if (!Auth::guard('validator')->attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => __('The provided credentials do not match our records.'),
            ])->onlyInput('email');
        }

        // Validasi bahwa user yang login adalah validator
        $user = Auth::guard('validator')->user();
        
        if ($user->role !== 'validator') {
            Auth::guard('validator')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return back()->withErrors([
                'email' => __('You do not have permission to access the validator panel.'),
            ])->onlyInput('email');
        }

        $request->session()->regenerate();
        
        return redirect()->intended(route('validator.dashboard'));
    }

    /**
     * Destroy an authenticated validator session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('validator')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('validator.login');
    }
}
