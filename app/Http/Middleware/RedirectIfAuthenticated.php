<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->hasRole('kasir')) {
                return redirect()->route('kasir');
            }else{
                return redirect()->route('dashboard');
            }

            return redirect('/dashboard');
        }

        return $next($request);
    }
}
