<?php

namespace App\Http\Controllers;

use App\Models\EmailVerification;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verify(Request $request)
    {
        $verification = EmailVerification::where('token', $request->query('token'))
            ->where('type', 'verify')
            ->whereNull('used_at')
            ->first();

        if (!$verification) {
            return redirect('/admin/login')->with('error', 'Token tidak valid.');
        }

        if (now()->isAfter($verification->expires_at)) {
            return redirect('/admin/login')->with('error', 'Token sudah kadaluarsa.');
        }

        $verification->user->update([
            'is_verified'       => true,
            'email_verified_at' => now(),
        ]);

        $verification->update(['used_at' => now()]);

        return redirect('/admin/login')->with('success', 'Email terverifikasi! Silakan login.');
    }
}