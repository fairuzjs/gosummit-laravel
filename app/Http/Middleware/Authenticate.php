<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // Check if the request is for admin or validator routes
            if ($request->is('admin/*') || $request->is('validator/*')) {
                return route('admin.login');
            }
            
            // Default to customer login
            return route('login');
        }
        
        return null;
    }
}
