<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Exception;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback(\Illuminate\Http\Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists by google_id
            $user = User::where('google_id', $googleUser->getId())->first();
            
            if ($user) {
                // User exists with Google ID, just login
                Auth::guard('web')->login($user, true); // Use web guard explicitly with remember
                $request->session()->regenerate();
                
                return redirect()->intended(route('dashboard'))
                    ->with('success', 'Berhasil login dengan Google!');
            }
            
            // Check if user exists by email
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if ($user) {
                // User exists with same email, link Google account
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
                
                Auth::guard('web')->login($user, true); // Use web guard explicitly with remember
                $request->session()->regenerate();
                
                return redirect()->intended(route('dashboard'))
                    ->with('success', 'Akun Google berhasil ditautkan!');
            }
            
            // Create new user
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => Hash::make(Str::random(24)), // Random password
                'email_verified_at' => now(), // Google emails are verified
                'role' => 'customer', // Default role
            ]);
            
            Auth::guard('web')->login($user, true); // Use web guard explicitly with remember
            $request->session()->regenerate();
            
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Akun berhasil dibuat dengan Google!');
            
        } catch (Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Gagal login dengan Google. Silakan coba lagi.');
        }
    }
}
