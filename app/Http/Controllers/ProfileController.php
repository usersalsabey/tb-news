<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\HeroSlide;

class ProfileController extends Controller
{
    public function index()
    {
        $profileData = Profile::first();

        $misiRaw   = $profileData?->misi ?? [];
        $misiArray = collect($misiRaw)->pluck('isi')->filter()->values()->toArray();

        $profile = [
            'nama_instansi'       => $profileData?->nama_instansi      ?? 'Polres Gunungkidul',
            'kapolres'            => $profileData?->kapolres            ?? 'AKBP ...',
            'foto_kapolres'       => $profileData?->foto_kapolres       ?? null,
            'sambutan'            => $profileData?->sambutan            ?? null,
            'visi'                => $profileData?->visi                ?? 'Terwujudnya Polri yang Presisi',
            'misi'                => $misiArray,
            'sejarah'             => $profileData?->sejarah             ?? null,
            'struktur_organisasi' => $profileData?->struktur_organisasi ?? null,
        ];

        $aboutLinks = [
            ['name' => 'Beranda',             'url' => route('home')],
            ['name' => 'Profil',              'url' => route('profile')],
            ['name' => 'Tribratanews',        'url' => route('news')],
            ['name' => 'Informasi Pelayanan', 'url' => route('information')],
        ];

        $heroSlides = HeroSlide::getSlides('profil');

        // $contact sudah di-share global via AppServiceProvider View::composer

        return view('profile.index', compact(
            'profile',
            'aboutLinks',
            'heroSlides'
        ));
    }
}