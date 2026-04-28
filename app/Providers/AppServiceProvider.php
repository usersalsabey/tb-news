<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('partials.footer', function ($view) {
            try {
                $profile = DB::table('profiles')->first();
                $view->with('contact', [
                    'email'   => $profile->email         ?? 'ppidgunungkidul@gmail.com',
                    'phone'   => $profile->telepon       ?? '0851-3375-0875',
                    'hotline' => $profile->hotline       ?? '110 (Darurat)',
                    'hours'   => $profile->jam_pelayanan ?? '24 Jam',
                ]);
                $view->with('footerProfile', $profile);
            } catch (\Exception $e) {
                //
            }
        });

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}