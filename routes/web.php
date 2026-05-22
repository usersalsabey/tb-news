<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\InformasiPelayananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\WbsController;

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Profile Routes
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

// News Routes
Route::get('/news',        [NewsController::class, 'index'])->name('news');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// Contact Routes
Route::get('/contact', fn () => view('contact'))->name('contact');

// Services Routes
Route::prefix('services')->name('services.')->group(function () {
    Route::get('/report',    fn () => view('services.report'))->name('report');
    Route::get('/sim',       fn () => view('services.sim'))->name('sim');
    Route::get('/skck',      fn () => view('services.skck'))->name('skck');
    Route::get('/complaint', fn () => view('services.complaint'))->name('complaint');
});

// About Routes
Route::prefix('about')->name('about.')->group(function () {
    Route::get('/profile',   fn () => view('about.profile'))->name('profile');
    Route::get('/structure', fn () => view('about.structure'))->name('structure');
    Route::get('/privacy',   fn () => view('about.privacy'))->name('privacy');
    Route::get('/terms',     fn () => view('about.terms'))->name('terms');
});

// Informasi Pelayanan Routes
Route::get('/informasi-pelayanan',            [InformasiPelayananController::class, 'index'])->name('information');
Route::get('/informasi-pelayanan/skck',       [InformasiPelayananController::class, 'skck'])->name('information.skck');
Route::get('/informasi-pelayanan/sim',        [InformasiPelayananController::class, 'sim'])->name('information.sim');
Route::get('/informasi-pelayanan/penerimaan', [InformasiPelayananController::class, 'penerimaan'])->name('information.penerimaan');
Route::get('/informasi-pelayanan/wbs',        [InformasiPelayananController::class, 'wbs'])->name('information.wbs');
Route::get('/informasi/perpustakaan-data',    [InformasiPelayananController::class, 'perpusdata'])->name('information.perpusdata');

// Chatbot
Route::post('/chatbot/chat', [ChatbotController::class, 'chat'])->name('chatbot.chat');

// Email Verification
Route::get('/verify-email', [EmailVerificationController::class, 'verify'])->name('verify.email');

// Admin OTP redirect
Route::get('/admin', function () {
    if (auth()->check() && !session('otp_verified')) {
        return redirect()->route('filament.admin.pages.otp-verify');
    }
    return redirect('/admin/dashboard');
});

Route::get('/wbs/laporan', [WbsController::class, 'index'])->name('wbs.form');
Route::post('/wbs/laporan', [WbsController::class, 'store'])->name('wbs.store');
Route::get('/wbs/sukses/{tiket}', [WbsController::class, 'sukses'])->name('wbs.sukses');
Route::get('/wbs/download/{tiket}', [WbsController::class, 'downloadPdf'])->name('wbs.download');