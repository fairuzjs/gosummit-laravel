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
            // Check if the request is for validator routes
            if ($request->is('validator/*')) {
                return route('validator.login');
            }
            
            // Check if the request is for admin routes
            if ($request->is('admin/*')) {
                return route('admin.login');
            }
            
            // Default to customer login
            return route('login');
        }
        
        return null;
    }
}
