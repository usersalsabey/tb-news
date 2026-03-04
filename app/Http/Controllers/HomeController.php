<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Vision & Mission
        $vision = 'Polres Gunungkidul bertekad mewujudkan postur Polri yang profesional, bermoral dan modern sebagai pelindung, pengayom dan pelayan masyarakat, yang terpercaya dalam memelihara kamtibmas dan menegakkan hukum di wilayah Gunungkidul sebagai Kota Pariwisata dalam suatu kehidupan sosial yang demokratis, berbudaya serta masyarakat yang sejahtera.';

        $mission = [
            'Memberikan perlindungan, pengayoman, dan pelayanan kepada seluruh masyarakat sehingga bebas dari gangguan fisik maupun psikis.',
            'Memberikan bimbingan preventif kepada masyarakat untuk meningkatkan kesadaran dan kepatuhan hukum.',
            'Menegakkan hukum secara profesional dan proporsional dengan menjunjung tinggi supremasi hukum dan Hak Asasi Manusia.',
            'Memelihara keamanan dan ketertiban masyarakat dengan memperhatikan norma dan nilai yang berlaku di Gunungkidul.',
            'Mengelola sumber daya personel secara profesional untuk mewujudkan keamanan wilayah dan kesejahteraan masyarakat.',
            'Meningkatkan konsolidasi internal untuk menyamakan visi dan misi Polri sesuai harapan masyarakat.',
            'Memelihara soliditas kesatuan Polres Gunungkidul dari pengaruh luar yang dapat merugikan organisasi.',
            'Melaksanakan kebijakan Kapolda D.I. Yogyakarta dalam pelaksanaan tugas secara nyata dan terukur.',
            'Meningkatkan kesadaran hukum dan berbangsa, mengingat Gunungkidul memiliki karakteristik wilayah yang khas.',
        ];

        // News — slug WAJIB ada di setiap item
        $news = [
            [
                'slug'    => 'operasi-ketertiban-lalu-lintas',
                'icon'    => '🚦',
                'date'    => '10 Februari 2026',
                'title'   => 'Operasi Ketertiban Lalu Lintas',
                'content' => 'Kepolisian mengadakan operasi gabungan untuk meningkatkan keselamatan dan ketertiban masyarakat di seluruh wilayah. Operasi ini melibatkan berbagai unit dengan teknologi modern.',
                'images'  => [
                    'images/news/traffic-1.jpg',
                    'images/news/traffic-2.jpg',
                    'images/news/traffic-3.jpg',
                ],
            ],
            [
                'slug'    => 'pelayanan-sim-online',
                'icon'    => '🆔',
                'date'    => '08 Februari 2026',
                'title'   => 'Pelayanan SIM Online',
                'content' => 'Kini masyarakat dapat memperpanjang SIM secara online melalui layanan resmi TB News. Proses cepat, mudah, dan tanpa antrian panjang. Daftar sekarang dan nikmati kemudahan layanan digital.',
                'images'  => [
                    'images/news/sim-1.jpg',
                    'images/news/sim-2.jpg',
                ],
            ],
            [
                'slug'    => 'program-polisi-sahabat-anak',
                'icon'    => '👮',
                'date'    => '05 Februari 2026',
                'title'   => 'Program Polisi Sahabat Anak',
                'content' => 'Inisiatif terbaru untuk mendekatkan diri dengan generasi muda dan memberikan edukasi keamanan sejak dini. Mari bersama membangun masa depan yang lebih aman untuk anak-anak Indonesia.',
                'images'  => [
                    'images/news/child-1.jpg',
                    'images/news/child-2.jpg',
                    'images/news/child-3.jpg',
                    'images/news/child-4.jpg',
                ],
            ],
        ];

        // Social Media
        $socialMedia = [
            ['icon' => '📷', 'name' => 'Instagram', 'handle' => '@polres.gunungkidul', 'url' => 'https://www.instagram.com/polres.gunungkidul/'],
            ['icon' => '👍', 'name' => 'Facebook',  'handle' => 'Polres Gunungkidul',  'url' => 'https://www.facebook.com/polres.gunungkidul/?locale=id_ID'],
            ['icon' => '▶️', 'name' => 'YouTube',   'handle' => 'Polres Gunungkidul',  'url' => 'https://www.youtube.com/@PolresGunungkidul'],
        ];

        // Contact
        $contact = [
            'email'   => 'ppidgunungkidul@gmail.com',
            'phone'   => '0851-3375-0875',
            'hotline' => '110 (Darurat)',
            'address' => 'Jln. MGR Sugiyopranoto No.15',
            'city'    => 'Wonosari, Gunungkidul, Yogyakarta',
            'hours'   => '24 Jam',
        ];

        // Services
        $services = [
            ['icon' => '📋', 'name' => 'Laporan Online',       'url' => route('services.report')],
            ['icon' => '🆔', 'name' => 'Perpanjangan SIM',     'url' => route('services.sim')],
            ['icon' => '📄', 'name' => 'SKCK Online',          'url' => route('services.skck')],
            ['icon' => '🚨', 'name' => 'Pengaduan Masyarakat', 'url' => route('services.complaint')],
        ];

        // About Links
        $aboutLinks = [
            [
                'name' => 'Profil',
                'url' => route('profile')
            ],
            [
                'name' => 'Informasi Pelayanan',
                'url' => route('information')
            ],
            [
                'name' => 'Tribratanews',
                'url' => route('news')
            ],
        ];

        return view('home', compact(
            'vision', 'mission', 'news',
            'socialMedia', 'contact', 'services', 'aboutLinks'
        ));
    }
}