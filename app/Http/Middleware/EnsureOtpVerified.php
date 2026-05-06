<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureOtpVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (!str_starts_with($request->path(), 'admin')) {
            return $next($request);
        }

        if (!auth()->check()) {
            return $next($request);
        }

        if (session('otp_verified')) {
            return $next($request);
        }

        if ($request->routeIs('filament.admin.pages.otp-verify') ||
            $request->routeIs('filament.admin.auth.login')) {
            return $next($request);
        }

        return redirect()->route('filament.admin.pages.otp-verify');
    }
}