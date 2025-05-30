<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $roles = explode('|', $role);
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        return redirect('/')->with('error', 'You do not have permission to access this page.');
    }
}