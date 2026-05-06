<?php

namespace App\Http\Middleware;

use App\Mail\LoginOtpMail;
use App\Models\LoginOtp;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EnsureOtpVerified
{
    public function handle(Request $request, Closure $next)
    {
        // Hanya jalan di route admin
        if (!str_starts_with($request->path(), 'admin')) {
            return $next($request);
        }

        // Skip kalau belum login
        if (!auth()->check()) {
            return $next($request);
        }

        // Skip kalau sudah OTP verified
        if (session('otp_verified')) {
            return $next($request);
        }

        // Skip kalau sedang di halaman OTP atau login
        if ($request->routeIs('filament.admin.pages.otp-verify') ||
            $request->routeIs('filament.admin.auth.login')) {
            return $next($request);
        }

        $user = auth()->user();

        // Kirim OTP kalau belum ada yang aktif
        if (!LoginOtp::where('user_id', $user->id)
                ->where('expires_at', '>', now())
                ->exists()) {

            LoginOtp::where('user_id', $user->id)->delete();

            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            LoginOtp::create([
                'user_id'    => $user->id,
                'otp'        => $otp,
                'expires_at' => now()->addMinutes(5),
            ]);

            Mail::to($user->email)->send(new LoginOtpMail($user, $otp));
        }

        return redirect()->route('filament.admin.pages.otp-verify');
    }
}