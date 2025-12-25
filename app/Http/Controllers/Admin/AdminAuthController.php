<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    /**
     * Display the admin login view.
     */
    public function showLoginForm(): View
    {
        return view('admin.auth.login');
    }

    /**
     * Handle an incoming admin authentication request.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        // Authenticate using admin guard
        $credentials = $request->only('email', 'password');
        
        if (!Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => __('The provided credentials do not match our records.'),
            ])->onlyInput('email');
        }

        // Validasi bahwa user yang login adalah admin atau validator
        $user = Auth::guard('admin')->user();
        
        if (!in_array($user->role, ['admin', 'validator'])) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return back()->withErrors([
                'email' => __('You do not have permission to access the admin panel.'),
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        // Redirect berdasarkan role
        if ($user->role === 'validator') {
            return redirect()->intended(route('validator.dashboard'));
        }
        
        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Destroy an authenticated admin session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
