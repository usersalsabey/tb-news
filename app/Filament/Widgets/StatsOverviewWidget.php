<?php

namespace App\Filament\Widgets;

use App\Models\News;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected ?string $heading = null;

    protected function getStats(): array
    {
        $totalNews     = News::count();
        $publishedNews = News::where('is_published', true)->count();
        $draftNews     = News::where('is_published', false)->count();
        $totalUsers    = User::count();

        // Berita bulan ini
        $newsThisMonth = News::whereMonth('created_at', now()->month)
                             ->whereYear('created_at', now()->year)
                             ->count();

        return [
            Stat::make('Total Berita', $totalNews)
                ->description('Semua berita tersimpan')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('info')
                ->chart([2, 4, 3, 5, 4, 6, $totalNews]),

            Stat::make('Dipublikasikan', $publishedNews)
                ->description('Tampil di website publik')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->chart([1, 2, 3, 3, 4, 5, $publishedNews]),

            Stat::make('Draft', $draftNews)
                ->description('Menunggu dipublikasikan')
                ->descriptionIcon('heroicon-m-pencil-square')
                ->color('warning'),

            Stat::make('Berita Bulan Ini', $newsThisMonth)
                ->description(now()->translatedFormat('F Y'))
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),

            Stat::make('Total Admin', $totalUsers)
                ->description('Pengguna aktif sistem')
                ->descriptionIcon('heroicon-m-users')
                ->color('gray'),
        ];
    }
}