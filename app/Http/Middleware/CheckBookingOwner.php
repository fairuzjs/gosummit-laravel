<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBookingOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $booking = $request->route('booking');
        
        // Jika tidak ada booking di route, skip check
        if (!$booking) {
            return $next($request);
        }
        
        // Check ownership - pastikan booking milik user yang sedang login
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke booking ini.');
        }
        
        return $next($request);
    }
}
