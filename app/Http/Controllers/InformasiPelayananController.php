<?php

namespace App\Http\Controllers;

use App\Models\InformasiPelayanan;
use App\Models\HeroSlide;

class InformasiPelayananController extends Controller
{
    public function index()
    {
        $pelayananItems = InformasiPelayanan::where('is_active', true)
            ->orderBy('urutan')
            ->get();

        $aboutLinks = [
            ['name' => 'Beranda',             'url' => route('home')],
            ['name' => 'Profil',              'url' => route('profile')],
            ['name' => 'Tribratanews',        'url' => route('news')],
            ['name' => 'Informasi Pelayanan', 'url' => route('information')],
        ];

        $heroSlides = HeroSlide::getSlides('informasi-pelayanan');

        // $contact sudah di-share global via AppServiceProvider View::composer

        return view('informasi-pelayanan.index', compact(
            'pelayananItems',
            'aboutLinks',
            'heroSlides'
        ));
    }

    public function sim()
    {
        return view('informasi-pelayanan.sim');
    }

    public function perpusdata()
    {
        return view('informasi-pelayanan.perpusdata');
    }
}