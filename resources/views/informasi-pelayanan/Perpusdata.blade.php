@extends('layouts.app')

@section('title', 'Perpustakaan Data - Polres Gunungkidul')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    :root { --navy:#0a1628;--blue:#1a3a6e;--accent:#2563eb;--gold:#f0a500;--gold-lt:#fbbf24;--surface:#f4f6fa;--white:#ffffff;--text:#1a1f2e;--muted:#6b7280;--border:#e2e8f0;--radius:16px;--purple:#7c3aed;--purple-lt:#f5f3ff; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--surface); color: var(--text); overflow-x: hidden; }

    header { background: var(--navy); padding: 0 56px; display: flex; justify-content: space-between; align-items: center; height: 72px; position: sticky; top: 0; z-index: 1000; border-bottom: 1px solid rgba(255,255,255,0.06); }
    .logo { display: flex; align-items: center; gap: 14px; text-decoration: none; }
    .logo img { width: 44px; height: 44px; object-fit: contain; }
    .logo-text { display: flex; flex-direction: column; }
    .logo-text span:first-child { font-size: 15px; font-weight: 800; color: var(--white); letter-spacing: 0.3px; line-height: 1.2; }
    .logo-text span:last-child { font-size: 11px; color: var(--gold); font-weight: 500; letter-spacing: 0.8px; text-transform: uppercase; }
    nav ul { display: flex; list-style: none; gap: 4px; }
    nav ul li a { text-decoration: none; color: rgba(255,255,255,0.65); font-size: 13.5px; font-weight: 600; padding: 8px 16px; border-radius: 8px; transition: all 0.2s; display: block; }
    nav ul li a:hover { color: var(--white); background: rgba(255,255,255,0.08); }
    nav ul li a.active { color: var(--white); background: var(--accent); }

    .hero { background: var(--navy); padding: 64px 56px 72px; position: relative; overflow: hidden; }
    .hero::after { content:''; position:absolute; right:-80px; top:-80px; width:480px; height:480px; background:radial-gradient(circle,rgba(124,58,237,0.2) 0%,transparent 70%); pointer-events:none; }
    .hero-inner { max-width:1100px; margin:0 auto; position:relative; z-index:1; }
    .hero-tag { display:inline-flex; align-items:center; gap:8px; background:rgba(124,58,237,0.15); border:1px solid rgba(124,58,237,0.35); color:#c4b5fd; font-size:12px; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; padding:6px 14px; border-radius:100px; margin-bottom:22px; }
    .hero-tag::before { content:'●'; font-size:8px; }
    .hero h1 { font-family:'DM Serif Display',serif; font-size:48px; color:var(--white); line-height:1.1; margin-bottom:16px; letter-spacing:-0.5px; }
    .hero h1 em { font-style:italic; color:#c4b5fd; }
    .hero p { font-size:15px; color:rgba(255,255,255,0.55); line-height:1.8; max-width:520px; }
    .hero-breadcrumb { display:flex; align-items:center; gap:8px; margin-top:28px; font-size:12.5px; color:rgba(255,255,255,0.35); }
    .hero-breadcrumb a { color:rgba(255,255,255,0.5); text-decoration:none; transition:color 0.2s; }
    .hero-breadcrumb a:hover { color:var(--gold-lt); }
    .hero-breadcrumb span.sep { opacity:0.4; }
    .hero-breadcrumb span.current { color:rgba(255,255,255,0.7); }

    .main-wrap { max-width:900px; margin:0 auto; padding:52px 40px 100px; }

    /* Coming soon banner */
    .coming-soon { background: var(--white); border-radius: 20px; border: 1px solid var(--border); overflow: hidden; margin-bottom: 32px; text-align: center; padding: 56px 40px; }
    .cs-icon { font-size: 64px; margin-bottom: 20px; }
    .cs-title { font-size: 24px; font-weight: 800; color: var(--text); margin-bottom: 10px; }
    .cs-desc { font-size: 14px; color: var(--muted); line-height: 1.75; max-width: 480px; margin: 0 auto 28px; }
    .cs-badge { display: inline-flex; align-items: center; gap: 8px; background: var(--purple-lt); color: var(--purple); font-size: 12px; font-weight: 700; padding: 8px 18px; border-radius: 100px; border: 1px solid #ddd6fe; letter-spacing: 0.5px; }

    /* Form pendaftaran notifikasi */
    .form-card { background: var(--white); border: 1px solid var(--border); border-radius: 20px; overflow: hidden; margin-bottom: 32px; }
    .form-card-header { background: linear-gradient(135deg,#4c1d95,#7c3aed); padding: 20px 28px; }
    .form-card-header h3 { font-size: 15px; font-weight: 700; color: #fff; }
    .form-card-header p { font-size: 12.5px; color: rgba(255,255,255,0.6); margin-top: 4px; }
    .form-card-body { padding: 28px; }

    {{-- Placeholder untuk Google Form --}}
    .gform-placeholder { background: var(--surface); border: 2px dashed var(--border); border-radius: var(--radius); padding: 40px; text-align: center; }
    .gform-placeholder p { font-size: 13px; color: var(--muted); line-height: 1.7; }
    .gform-placeholder strong { color: var(--text); }

    {{-- Kalau sudah ada link Google Form, ganti bagian di atas dengan: --}}
    {{-- <iframe src="YOUR_GOOGLE_FORM_EMBED_URL" width="100%" height="520" frameborder="0" marginheight="0" marginwidth="0" style="border-radius:12px;">Memuat…</iframe> --}}

    /* Apa isi perpus data */
    .section-title { font-size: 16px; font-weight: 800; color: var(--text); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
    .info-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 16px; margin-bottom: 32px; }
    .info-box { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px 22px; }
    .info-box-icon { font-size: 24px; margin-bottom: 10px; }
    .info-box-title { font-size: 13px; font-weight: 700; color: var(--text); margin-bottom: 6px; }
    .info-box-desc { font-size: 13px; color: var(--muted); line-height: 1.65; }

    .notice { display:flex; align-items:center; gap:14px; background:var(--purple-lt); border:1px solid #ddd6fe; border-left:4px solid var(--purple); border-radius:var(--radius); padding:16px 20px; margin-bottom:32px; }
    .notice-icon { font-size:20px; flex-shrink:0; }
    .notice p { font-size:13.5px; color:#4c1d95; line-height:1.6; }
    .notice p strong { font-weight:700; }

    footer { background:var(--navy); color:var(--white); padding:0; }
    .footer-location { background:#0d1e38; border-bottom:1px solid rgba(255,255,255,0.06); padding:20px 56px; }
    .footer-location-inner { max-width:1100px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; gap:20px; flex-wrap:wrap; }
    .footer-location-left { display:flex; align-items:center; gap:14px; }
    .location-icon-wrap { width:44px; height:44px; background:rgba(37,99,235,0.15); border:1px solid rgba(37,99,235,0.3); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; }
    .location-label { font-size:10.5px; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; color:var(--gold); margin-bottom:3px; }
    .location-address { font-size:13.5px; color:rgba(255,255,255,0.85); font-weight:600; line-height:1.4; }
    .location-city { font-size:12px; color:rgba(255,255,255,0.4); margin-top:2px; }
    .maps-btn { display:inline-flex; align-items:center; gap:9px; padding:11px 20px; background:var(--accent); color:var(--white); font-size:13px; font-weight:700; border-radius:10px; text-decoration:none; transition:all 0.25s; white-space:nowrap; flex-shrink:0; border:1px solid rgba(255,255,255,0.1); }
    .maps-btn:hover { background:#1d4ed8; transform:translateY(-2px); box-shadow:0 8px 24px rgba(37,99,235,0.4); }
    .footer-main { padding:52px 56px 32px; }
    .footer-grid { max-width:1100px; margin:0 auto; display:grid; grid-template-columns:2fr 1fr 1fr; gap:48px; padding-bottom:40px; border-bottom:1px solid rgba(255,255,255,0.08); margin-bottom:28px; }
    .footer-brand p { font-size:13.5px; color:rgba(255,255,255,0.45); line-height:1.9; margin-top:14px; max-width:280px; }
    .footer-col h5 { font-size:11px; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; color:var(--gold); margin-bottom:18px; }
    .footer-col a,.footer-col p { display:block; font-size:13.5px; color:rgba(255,255,255,0.5); text-decoration:none; line-height:2.2; transition:color 0.2s; }
    .footer-col a:hover { color:var(--white); }
    .footer-bottom { max-width:1100px; margin:0 auto; display:flex; justify-content:space-between; align-items:center; font-size:12.5px; color:rgba(255,255,255,0.3); }

    @media (max-width:768px) { .info-grid{grid-template-columns:1fr} .hero{padding:44px 28px 52px} .hero h1{font-size:34px} header{padding:0 24px} .main-wrap{padding:36px 24px 72px} .footer-location{padding:18px 28px} .footer-main{padding:44px 28px 28px} .footer-grid{grid-template-columns:1fr 1fr} .form-card-body{padding:20px} }
    @media (max-width:560px) { nav ul li a{padding:7px 11px;font-size:12px} .footer-location-inner{flex-direction:column;align-items:flex-start} .maps-btn{width:100%;justify-content:center} .footer-grid{grid-template-columns:1fr} .footer-bottom{flex-direction:column;gap:8px;text-align:center} }
</style>
@endpush

@section('content')

<header>
    <a href="{{ route('home') }}" class="logo">
        <img src="{{ asset('images/new.PNG') }}" alt="Logo Polri">
        <div class="logo-text">
            <span>Tribrata News Gunungkidul</span>
            <span>Polres Gunungkidul</span>
        </div>
    </a>
    <nav>
        <ul>
            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li><a href="{{ route('profile') }}">Profil</a></li>
            <li><a href="{{ route('news') }}">Tribratanews</a></li>
            <li><a href="{{ route('information') }}" class="active">Informasi Pelayanan</a></li>
        </ul>
    </nav>
</header>

<section class="hero">
    <div class="hero-inner">
        <div class="hero-tag">Referensi & Data</div>
        <h1>Perpustakaan<br><em>Data</em></h1>
        <p>Temukan dokumen, regulasi, dan data informasi publik Polres Gunungkidul yang tersedia untuk masyarakat umum secara terbuka dan transparan.</p>
        <div class="hero-breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">›</span>
            <a href="{{ route('information') }}">Informasi Pelayanan</a>
            <span class="sep">›</span>
            <span class="current">Perpustakaan Data</span>
        </div>
    </div>
</section>

<div class="main-wrap">

    <div class="notice">
        <div class="notice-icon">🚀</div>
        <p><strong>Fitur Inovasi Baru!</strong> Perpustakaan Data adalah layanan terbaru Polres Gunungkidul untuk mempermudah akses informasi publik bagi seluruh masyarakat.</p>
    </div>

    {{-- Coming Soon --}}
    <div class="coming-soon">
        <div class="cs-icon">📚</div>
        <div class="cs-title">Perpustakaan Data Segera Hadir</div>
        <div class="cs-desc">Kami sedang menyiapkan koleksi dokumen, regulasi, dan data publik Polres Gunungkidul agar mudah diakses oleh seluruh masyarakat. Nantikan peluncurannya!</div>
        <span class="cs-badge">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Dalam Persiapan
        </span>
    </div>

    {{-- Form Google --}}
    <div class="form-card">
        <div class="form-card-header">
            <h3>📝 Permintaan Informasi / Dokumen</h3>
            <p>Isi formulir berikut untuk mengajukan permintaan data atau dokumen publik yang kamu butuhkan</p>
        </div>
        <div class="form-card-body">
            {{--
                CARA PASANG GOOGLE FORM:
                1. Buka Google Form kamu
                2. Klik tombol "Kirim" → tab embed (<>)
                3. Copy URL iframe-nya
                4. Ganti bagian placeholder di bawah dengan:
                   <iframe src="URL_GOOGLE_FORM_KAMU" width="100%" height="520"
                   frameborder="0" marginheight="0" marginwidth="0"
                   style="border-radius:12px;">Memuat…</iframe>
            --}}
            <div class="gform-placeholder">
                <p style="font-size:32px;margin-bottom:12px;">📋</p>
                <p><strong>Google Form akan dipasang di sini.</strong><br>
                Segera tersedia setelah link formulir diterima.<br>
                <span style="font-size:12px;color:#9ca3af;margin-top:8px;display:block;">Hubungi admin untuk info lebih lanjut.</span></p>
            </div>
        </div>
    </div>

    {{-- Apa yang akan tersedia --}}
    <p class="section-title">📂 Yang Akan Tersedia di Perpustakaan Data</p>
    <div class="info-grid">
        <div class="info-box">
            <div class="info-box-icon">📜</div>
            <div class="info-box-title">Regulasi & Peraturan</div>
            <div class="info-box-desc">Kumpulan Perkap, Peraturan Kapolri, dan regulasi terkait layanan kepolisian yang berlaku.</div>
        </div>
        <div class="info-box">
            <div class="info-box-icon">📊</div>
            <div class="info-box-title">Statistik Pelayanan</div>
            <div class="info-box-desc">Data jumlah SKCK, SIM, dan layanan lain yang telah diproses setiap bulannya secara transparan.</div>
        </div>
        <div class="info-box">
            <div class="info-box-icon">📁</div>
            <div class="info-box-title">Dokumen Publik</div>
            <div class="info-box-desc">Formulir, SOP pelayanan, dan dokumen resmi yang bisa diunduh langsung oleh masyarakat.</div>
        </div>
        <div class="info-box">
            <div class="info-box-icon">📰</div>
            <div class="info-box-title">Laporan Tahunan</div>
            <div class="info-box-desc">Ringkasan kinerja dan capaian Polres Gunungkidul yang dipublikasikan secara berkala untuk masyarakat.</div>
        </div>
    </div>

</div>

<footer>
    <div class="footer-location">
        <div class="footer-location-inner">
            <div class="footer-location-left">
                <div class="location-icon-wrap">📍</div>
                <div>
                    <div class="location-label">Lokasi Polres Gunungkidul</div>
                    <div class="location-address">Jln. MGR Sugiyopranoto No.15, Wonosari</div>
                    <div class="location-city">Kabupaten Gunungkidul, D.I. Yogyakarta 55813</div>
                </div>
            </div>
            <a href="https://maps.app.goo.gl/Xv8tKdyoVjMf4DkRA" target="_blank" rel="noopener" class="maps-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                Buka di Google Maps
            </a>
        </div>
    </div>
    <div class="footer-main">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ asset('images/new.PNG') }}" alt="Logo">
                    <div class="logo-text"><span>Tribrata News Gunungkidul</span><span>Polres Gunungkidul</span></div>
                </a>
                <p>{{ $contact['address'] }}, {{ $contact['city'] }}. Melayani seluruh masyarakat Gunungkidul dengan profesional dan terpercaya.</p>
            </div>
            <div class="footer-col">
                <h5>Kontak</h5>
                <p>📧 {{ $contact['email'] }}</p><p>📞 {{ $contact['phone'] }}</p>
                <p>🚨 {{ $contact['hotline'] }}</p><p>🕐 {{ $contact['hours'] }}</p>
            </div>
            <div class="footer-col">
                <h5>Navigasi</h5>
                @foreach($aboutLinks as $link)<a href="{{ $link['url'] }}">{{ $link['name'] }}</a>@endforeach
            </div>
        </div>
        <div class="footer-bottom">
            <span>© {{ date('Y') }} Polres Gunungkidul — Melayani Dengan Hati</span>
            <span>Tribrata News Gunungkidul</span>
        </div>
    </div>
</footer>

@endsection