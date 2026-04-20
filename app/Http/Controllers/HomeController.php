<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use App\Models\HeroSlide;
use App\Models\Profile;
use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private function resolveImage(string $path): string
    {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }
        return asset('storage/' . $path);
    }

    private function resolveImages($images): array
    {
        if (empty($images)) return [];

        if ($images instanceof \Illuminate\Support\Collection) {
            return $images
                ->map(fn($img) => $this->resolveImage(
                    $img->path ?? $img->url ?? $img->image ?? $img->foto ?? $img->file_path ?? ''
                ))
                ->filter(fn($url) => $url !== '')
                ->values()
                ->toArray();
        }

        return array_values(array_filter(
            array_map(fn($img) => is_string($img) && $img !== '' ? $this->resolveImage($img) : null, (array) $images)
        ));
    }

    public function index()
    {
        // ===== HERO SLIDES =====
        $heroSlides = HeroSlide::where('halaman', 'beranda')
                        ->where('is_active', true)
                        ->orderBy('urutan')
                        ->get();

        // ===== PROFILE =====
        $profile  = Profile::first();
        $sambutan = $profile?->sambutan ?? null;
        $sejarah  = $profile?->sejarah  ?? null;
        $kapolres = [
            'nama' => $profile?->kapolres     ?? 'Kapolres Gunungkidul',
            'foto' => $profile?->foto_kapolres ?? null,
        ];

        // ===== VISION & MISSION dari DB =====
        $vision  = $profile?->visi ?? '';
        $misiRaw = $profile?->misi ?? '[]';
        $misiArr = is_string($misiRaw) ? json_decode($misiRaw, true) : $misiRaw;
        $mission = collect($misiArr)->pluck('isi')->toArray();

        // ===== NEWS dari DB =====
        $news = News::where('is_published', true)
                    ->orderBy('published_at', 'desc')
                    ->take(3)
                    ->get()
                    ->map(function ($item) {
                        $fotoRaw = $item->foto;
                        $fotoArr = is_string($fotoRaw) ? json_decode($fotoRaw, true) : ($fotoRaw ?? []);
                        return [
                            'slug'    => $item->slug,
                            'title'   => $item->title,
                            'excerpt' => $item->excerpt ?? \Str::limit(strip_tags($item->content), 160),
                            'date'    => $item->published_at?->translatedFormat('d F Y') ?? '-',
                            'category'=> $item->category ?? 'umum',
                            'icon'    => $item->icon ? $this->resolveImage($item->icon) : null,
                            'images'  => $this->resolveImages($fotoArr),
                        ];
                    })->toArray();

        // ===== SOCIAL MEDIA dari DB =====
        try {
            $socialMedia = SocialMedia::aktif()->get();
        } catch (\Exception $e) {
            $socialMedia = collect();
        }

        // ===== CONTACT dari DB =====
        $contact = [
            'email'   => $profile?->email        ?? 'ppidgunungkidul@gmail.com',
            'phone'   => $profile?->telepon       ?? '0851-3375-0875',
            'hotline' => $profile?->hotline       ?? '110 (Darurat)',
            'address' => $profile?->alamat        ?? 'Jln. MGR Sugiyopranoto No.15',
            'city'    => 'Wonosari, Gunungkidul, Yogyakarta',
            'hours'   => $profile?->jam_pelayanan ?? '24 Jam',
        ];

        // ===== SERVICES =====
        $services = [
            ['icon' => '📋', 'name' => 'Laporan Online',       'url' => route('services.report')],
            ['icon' => '🆔', 'name' => 'Perpanjangan SIM',     'url' => route('services.sim')],
            ['icon' => '📄', 'name' => 'SKCK Online',          'url' => route('services.skck')],
            ['icon' => '🚨', 'name' => 'Pengaduan Masyarakat', 'url' => route('services.complaint')],
        ];

        // ===== ABOUT LINKS =====
        $aboutLinks = [
            ['name' => 'Profil',              'url' => route('profile')],
            ['name' => 'Informasi Pelayanan', 'url' => route('information')],
            ['name' => 'Tribratanews',        'url' => route('news')],
        ];

        return view('home', compact(
            'heroSlides',
            'sambutan', 'sejarah', 'kapolres',
            'vision', 'mission',
            'news', 'socialMedia',
            'contact', 'services', 'aboutLinks'
        ));
    }
}