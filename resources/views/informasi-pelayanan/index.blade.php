@extends('layouts.app')

@section('title', 'Informasi Pelayanan - Polres Gunungkidul')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    :root { --navy:#0a1628;--blue:#1a3a6e;--mid:#1e4da1;--accent:#2563eb;--gold:#f0a500;--gold-lt:#fbbf24;--surface:#f4f6fa;--white:#ffffff;--text:#1a1f2e;--muted:#6b7280;--border:#e2e8f0;--radius:16px; }

    /* ===== DARK MODE ===== */
    html.dark {
        --surface: #0f1923;
        --white:   #1a2535;
        --text:    #e2e8f0;
        --muted:   #94a3b8;
        --border:  #1e2d42;
    }

    body, .card, .notice, .ext-badge,
    .card-title, .card-desc {
        transition: background-color 0.3s ease, color 0.3s ease,
                    border-color 0.3s ease, box-shadow 0.3s ease;
    }

    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--surface); color: var(--text); overflow-x: hidden; }
    html.dark body { background: var(--surface); color: var(--text); }

    header { background: var(--navy); padding: 0 56px; display: flex; justify-content: space-between; align-items: center; height: 72px; position: sticky; top: 0; z-index: 1000; border-bottom: 1px solid rgba(255,255,255,0.06); }
    .logo { display: flex; align-items: center; gap: 14px; text-decoration: none; }
    .logo img { width: 44px; height: 44px; object-fit: contain; }
    .logo-text { display: flex; flex-direction: column; }
    .logo-text span:first-child { font-size: 15px; font-weight: 800; color: var(--white); letter-spacing: 0.3px; line-height: 1.2; }
    .logo-text span:last-child { font-size: 11px; color: var(--gold); font-weight: 500; letter-spacing: 0.8px; text-transform: uppercase; }

    .header-right { display: flex; align-items: center; gap: 4px; }
    nav ul { display: flex; list-style: none; gap: 4px; }
    nav ul li a { text-decoration: none; color: rgba(255,255,255,0.65); font-size: 13.5px; font-weight: 600; padding: 8px 16px; border-radius: 8px; transition: all 0.2s; display: block; }
    nav ul li a:hover { color: var(--white); background: rgba(255,255,255,0.08); }
    nav ul li a.active { color: var(--white); background: var(--accent); }

    /* ===== DARK MODE TOGGLE ===== */
    .dark-toggle { width:38px; height:38px; border-radius:10px; background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.12); color:rgba(255,255,255,0.7); cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.25s; flex-shrink:0; margin-left:8px; outline:none; }
    .dark-toggle:hover { background:rgba(255,255,255,0.14); color:var(--gold-lt); border-color:rgba(240,165,0,0.4); }
    .dark-toggle svg { transition:transform 0.45s ease; pointer-events:none; }
    .dark-toggle:hover svg { transform:rotate(22deg); }
    .dark-toggle .icon-moon { display:block; }
    .dark-toggle .icon-sun  { display:none; }
    html.dark .dark-toggle .icon-moon { display:none; }
    html.dark .dark-toggle .icon-sun  { display:block; }

    /* ===== HERO ===== */
    .hero { position: relative; overflow: hidden; height: 480px; }
    .hero-bg { position: absolute; inset: 0; }
    .hero-bg img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .hero-bg::after { content: ''; position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(10,22,40,0.35) 0%, rgba(10,22,40,0.72) 100%); }
    .hero-inner { position: absolute; inset: 0; z-index: 2; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 0 56px; }
    .hero-tag { display: inline-flex; align-items: center; gap: 8px; background: rgba(240,165,0,0.18); border: 1px solid rgba(240,165,0,0.4); color: var(--gold-lt); font-size: 11px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; padding: 6px 16px; border-radius: 100px; margin-bottom: 20px; }
    .hero-tag::before { content: '\25cf'; font-size: 8px; }
    .hero h1 { font-family: 'DM Serif Display', serif; font-size: 56px; color: var(--white); line-height: 1.1; margin-bottom: 14px; letter-spacing: -0.5px; text-shadow: 0 4px 24px rgba(0,0,0,0.4); }
    .hero h1 em { font-style: italic; color: var(--gold-lt); }
    .hero-desc { font-size: 15px; color: rgba(255,255,255,0.75); line-height: 1.8; max-width: 520px; }
    .hero-breadcrumb { display: flex; align-items: center; gap: 8px; margin-top: 16px; font-size: 12.5px; color: rgba(255,255,255,0.5); }
    .hero-breadcrumb a { color: rgba(255,255,255,0.65); text-decoration: none; transition: color 0.2s; }
    .hero-breadcrumb a:hover { color: var(--gold-lt); }
    .hero-breadcrumb span.sep { opacity: 0.4; }
    .hero-breadcrumb span.current { color: rgba(255,255,255,0.85); }

    /* ===== MAIN ===== */
    .main-wrap { max-width: 1100px; margin: 0 auto; padding: 52px 40px 100px; }

    .notice { display: flex; align-items: center; gap: 14px; background: var(--white); border: 1px solid var(--border); border-left: 4px solid var(--gold); border-radius: var(--radius); padding: 16px 20px; margin-bottom: 40px; }
    html.dark .notice { background: #1a2535; border-color: #1e2d42; border-left-color: var(--gold); }
    .notice-icon { font-size: 20px; flex-shrink: 0; }
    .notice p { font-size: 13.5px; color: var(--muted); line-height: 1.6; }
    .notice p strong { color: var(--text); font-weight: 700; }

    .grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 20px; }

    .card { background: var(--white); border-radius: 20px; border: 1px solid var(--border); overflow: hidden; color: inherit; display: flex; flex-direction: column; transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s, background-color 0.3s; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 20px 48px rgba(10,22,40,0.12); border-color: transparent; }
    html.dark .card { background: #1a2535; border-color: #1e2d42; }
    html.dark .card:hover { box-shadow: 0 20px 48px rgba(0,0,0,0.4); border-color: #2d3e55; }

    .card-band { height: 6px; }
    .band-blue { background: linear-gradient(90deg,#1a3a6e,#2563eb); }
    .band-green { background: linear-gradient(90deg,#064e3b,#10b981); }
    .band-red { background: linear-gradient(90deg,#7f1d1d,#ef4444); }
    .band-amber { background: linear-gradient(90deg,#78350f,#f59e0b); }

    .card-inner { padding: 28px 28px 24px; flex: 1; display: flex; flex-direction: column; gap: 16px; }
    .card-meta { display: flex; align-items: center; justify-content: space-between; }

    .card-chip { display: inline-block; font-size: 10.5px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; padding: 4px 11px; border-radius: 100px; }
    .chip-blue { background: #eff6ff; color: #2563eb; }
    .chip-green { background: #ecfdf5; color: #059669; }
    .chip-red { background: #fef2f2; color: #dc2626; }
    .chip-amber { background: #fffbeb; color: #d97706; }
    html.dark .chip-blue { background: #1e3a5f; color: #60a5fa; }
    html.dark .chip-green { background: #064e3b; color: #34d399; }
    html.dark .chip-red { background: #450a0a; color: #f87171; }
    html.dark .chip-amber { background: #451a03; color: #fbbf24; }

    .card-title { font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2; }
    .card-desc { font-size: 13.5px; color: var(--muted); line-height: 1.75; }

    .card-list { list-style: none; display: flex; flex-direction: column; gap: 8px; padding: 0; }
    .card-list li { display: flex; align-items: flex-start; gap: 10px; font-size: 13px; color: #4b5563; line-height: 1.5; }
    html.dark .card-list li { color: #94a3b8; }
    .check { width: 17px; height: 17px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; font-size: 9px; font-weight: 900; color: var(--white); }
    .check-blue { background: #2563eb; }
    .check-green { background: #10b981; }
    .check-red { background: #ef4444; }
    .check-amber { background: #f59e0b; }

    .ext-links { padding: 16px 28px 20px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap; border-top: 1px solid var(--border); }
    html.dark .ext-links { border-top-color: #1e2d42; }
    .ext-links-label { font-size: 10.5px; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; color: var(--muted); flex-basis: 100%; margin-bottom: 4px; }
    .ext-badge { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; text-decoration: none; padding: 7px 14px; border-radius: 8px; border: 1px solid var(--border); background: var(--white); color: var(--text); transition: all 0.2s; white-space: nowrap; }
    html.dark .ext-badge { background: #0f1923; border-color: #1e2d42; color: #e2e8f0; }
    .ext-badge:hover { border-color: var(--accent); color: var(--accent); background: #eff6ff; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,99,235,0.1); }
    html.dark .ext-badge:hover { background: #1e3a5f; color: #60a5fa; border-color: #2563eb; }
    .ext-badge svg { flex-shrink: 0; }

    /* ===== FOOTER ===== */
    footer { background: var(--navy); color: var(--white); padding: 0; }
    html.dark footer { background: #060d18; }
    .footer-location { background: #0d1e38; border-bottom: 1px solid rgba(255,255,255,0.06); padding: 20px 56px; }
    html.dark .footer-location { background: #080f1a; }
    .footer-location-inner { max-width: 1100px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap; }
    .footer-location-left { display: flex; align-items: center; gap: 14px; }
    .location-icon-wrap { width: 44px; height: 44px; background: rgba(37,99,235,0.15); border: 1px solid rgba(37,99,235,0.3); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
    .location-label { font-size: 10.5px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; color: var(--gold); margin-bottom: 3px; }
    .location-address { font-size: 13.5px; color: rgba(255,255,255,0.85); font-weight: 600; line-height: 1.4; }
    .location-city { font-size: 12px; color: rgba(255,255,255,0.4); margin-top: 2px; }
    .maps-btn { display: inline-flex; align-items: center; gap: 9px; padding: 11px 20px; background: var(--accent); color: var(--white); font-size: 13px; font-weight: 700; border-radius: 10px; text-decoration: none; transition: all 0.25s; white-space: nowrap; flex-shrink: 0; border: 1px solid rgba(255,255,255,0.1); }
    .maps-btn:hover { background: #1d4ed8; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(37,99,235,0.4); }
    .footer-main { padding: 52px 56px 32px; }
    .footer-grid { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 48px; padding-bottom: 40px; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 28px; }
    .footer-brand p { font-size: 13.5px; color: rgba(255,255,255,0.45); line-height: 1.9; margin-top: 14px; max-width: 280px; }
    .footer-col h5 { font-size: 11px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; color: var(--gold); margin-bottom: 18px; }
    .footer-col a,.footer-col p { display: block; font-size: 13.5px; color: rgba(255,255,255,0.5); text-decoration: none; line-height: 2.2; transition: color 0.2s; }
    .footer-col a:hover { color: var(--white); }
    .footer-bottom { max-width: 1100px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; font-size: 12.5px; color: rgba(255,255,255,0.3); }

    /* ===== WEATHER BAR ===== */
    .wx-bar { background: #0d1e38; border-bottom: 1px solid rgba(255,255,255,0.07); padding: 0 56px; height: 52px; display: flex; align-items: center; gap: 0; overflow: hidden; }
    html.dark .wx-bar { background: #080f1a; }
    .wx-bar-current { display: flex; align-items: center; gap: 10px; flex-shrink: 0; padding-right: 20px; border-right: 1px solid rgba(255,255,255,0.08); height: 32px; }
    .wx-bar-icon   { font-size: 22px; line-height: 1; }
    .wx-bar-temp   { font-size: 18px; font-weight: 800; color: #ffffff; letter-spacing: -0.5px; }
    .wx-bar-info   { display: flex; flex-direction: column; gap: 1px; }
    .wx-bar-desc   { font-size: 11.5px; font-weight: 600; color: rgba(255,255,255,0.75); line-height: 1; }
    .wx-bar-meta   { display: flex; gap: 10px; font-size: 10px; color: rgba(255,255,255,0.35); font-weight: 500; }
    .wx-bar-meta span { display: flex; align-items: center; gap: 3px; }
    .wx-bar-days { display: flex; align-items: center; gap: 4px; flex: 1; overflow-x: auto; padding: 0 16px; scrollbar-width: none; }
    .wx-bar-days::-webkit-scrollbar { display: none; }
    .wx-bar-day { display: flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 100px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); flex-shrink: 0; transition: background 0.2s, border-color 0.2s; cursor: default; }
    .wx-bar-day:hover { background: rgba(37,99,235,0.18); border-color: rgba(37,99,235,0.3); }
    .wx-bar-day.wx-today-pill { background: rgba(37,99,235,0.2); border-color: rgba(37,99,235,0.45); }
    .wx-bar-day-name { font-size: 10.5px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; color: rgba(255,255,255,0.45); min-width: 26px; }
    .wx-bar-day.wx-today-pill .wx-bar-day-name { color: #fbbf24; }
    .wx-bar-day-icon  { font-size: 16px; line-height: 1; }
    .wx-bar-day-temps { font-size: 11px; font-weight: 700; color: #ffffff; white-space: nowrap; }
    .wx-bar-day-lo    { color: rgba(255,255,255,0.35); font-weight: 500; }
    .wx-bar-refresh { flex-shrink: 0; background: none; border: none; color: rgba(255,255,255,0.25); cursor: pointer; padding: 6px; border-radius: 6px; display: flex; align-items: center; transition: color 0.2s; font-family: inherit; }
    .wx-bar-refresh:hover { color: rgba(255,255,255,0.7); }
    .wx-bar-refresh svg { transition: transform 0.5s; }
    .wx-bar-refresh.spinning svg { animation: wxSpin 0.7s linear infinite; }
    @keyframes wxSpin { to { transform: rotate(360deg); } }
    .wx-sk { background: rgba(255,255,255,0.07); border-radius: 6px; animation: wxPulse 1.6s ease-in-out infinite; display: inline-block; }
    @keyframes wxPulse { 0%,100%{opacity:.4} 50%{opacity:.9} }

    /* ===== RESPONSIVE ===== */
    @media (max-width:900px) {
        .grid{grid-template-columns:1fr} .hero{height:400px} .hero h1{font-size:38px}
        .hero-inner{padding:0 32px} header{padding:0 24px}
        .main-wrap{padding:36px 24px 72px} .footer-location{padding:18px 28px}
        .footer-main{padding:44px 28px 28px} .footer-grid{grid-template-columns:1fr 1fr}
    }
    @media (max-width:768px) { .wx-bar{padding:0 20px} .wx-bar-current{padding-right:12px} .wx-bar-desc{display:none} }
    @media (max-width:560px) {
        nav ul li a{padding:7px 11px;font-size:12px} .hero{height:320px} .hero h1{font-size:28px}
        .hero-inner{padding:0 20px} .footer-location-inner{flex-direction:column;align-items:flex-start}
        .maps-btn{width:100%;justify-content:center} .footer-grid{grid-template-columns:1fr}
        .footer-bottom{flex-direction:column;gap:8px;text-align:center}
    }
    @media (max-width:480px) { .wx-bar-meta{display:none} }
</style>
@endpush

@section('content')

{{-- HEADER --}}
<header>
    <a href="{{ route('home') }}" class="logo">
        <img src="{{ asset('images/new.PNG') }}" alt="Logo Polri">
        <div class="logo-text">
            <span>Tribrata News Gunungkidul</span>
            <span>Polres Gunungkidul</span>
        </div>
    </a>
    <div class="header-right">
        <nav>
            <ul>
                <li><a href="{{ route('home') }}">Beranda</a></li>
                <li><a href="{{ route('profile') }}">Profil</a></li>
                <li><a href="{{ route('news') }}">Tribratanews</a></li>
                <li><a href="{{ route('information') }}" class="active">Informasi Pelayanan</a></li>
            </ul>
        </nav>
        <button class="dark-toggle" id="darkToggle" title="Ganti tema" aria-label="Toggle dark mode">
            <svg class="icon-moon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            <svg class="icon-sun" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
        </button>
    </div>
</header>

{{-- WEATHER BAR --}}
<div class="wx-bar" id="wxBar">
    <div class="wx-bar-current">
        <div class="wx-bar-icon" id="wxIcon">⏳</div>
        <div class="wx-bar-info">
            <span class="wx-bar-temp" id="wxTemp"><span class="wx-sk" style="width:42px;height:16px;border-radius:4px;display:inline-block;vertical-align:middle;"></span></span>
            <div class="wx-bar-desc" id="wxDesc">Memuat…</div>
            <div class="wx-bar-meta">
                <span id="wxHum">💧 --</span>
                <span id="wxWnd">💨 --</span>
                <span id="wxPrcp">☔ --</span>
            </div>
        </div>
    </div>
    <div class="wx-bar-days" id="wxDays">
        @for($i = 0; $i < 7; $i++)
        <div class="wx-bar-day"><span class="wx-bar-day-name"><span class="wx-sk" style="width:24px;height:9px;border-radius:3px;display:inline-block;"></span></span><span class="wx-bar-day-icon"><span class="wx-sk" style="width:16px;height:16px;border-radius:50%;display:inline-block;"></span></span><span class="wx-bar-day-temps"><span class="wx-sk" style="width:36px;height:9px;border-radius:3px;display:inline-block;"></span></span></div>
        @endfor
    </div>
    <button class="wx-bar-refresh" id="wxRefresh" title="Refresh cuaca">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M23 4v6h-6"/><path d="M1 20v-6h6"/>
            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
        </svg>
    </button>
</div>

{{-- HERO --}}
<section class="hero">
    <div class="hero-bg">
        <img src="{{ asset('images/slideshow/pelayanan.jpg') }}" alt="Informasi Pelayanan Polres Gunungkidul">
    </div>
    <div class="hero-inner">
        <div class="hero-tag">Layanan Publik</div>
        <h1>Informasi<br><em>Pelayanan</em></h1>
        <p class="hero-desc">Akses layanan kepolisian Polres Gunungkidul secara online — cepat, mudah, dan transparan.</p>
        <div class="hero-breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">›</span>
            <span class="current">Informasi Pelayanan</span>
        </div>
    </div>
</section>

{{-- MAIN --}}
<div class="main-wrap">
    <div class="notice">
        <div class="notice-icon">ℹ️</div>
        <p><strong>Layanan tersedia 24 jam.</strong> Pilih layanan di bawah untuk melihat persyaratan lengkap dan akses langsung ke portal resmi Polri.</p>
    </div>
    <div class="grid">

        {{-- SKCK ONLINE --}}
        <div class="card">
            <div class="card-band band-blue"></div>
            <div class="card-inner">
                <div class="card-meta"><span class="card-chip chip-blue">Surat Keterangan</span></div>
                <div class="card-title">SKCK Online</div>
                <p class="card-desc">Urus Surat Keterangan Catatan Kepolisian secara online — daftar, upload dokumen, lalu ambil hasilnya di Polres atau Polsek terdekat.</p>
                <ul class="card-list">
                    <li><span class="check check-blue">✓</span> Pendaftaran & pengisian formulir online</li>
                    <li><span class="check check-blue">✓</span> Upload dokumen persyaratan digital</li>
                    <li><span class="check check-blue">✓</span> Ambil SKCK langsung di Polres / Polsek</li>
                </ul>
            </div>
            <div class="ext-links">
                <span class="ext-links-label">Unduh Aplikasi</span>
                <a href="https://play.google.com/store/apps/details?id=superapps.polri.presisi.presisi" target="_blank" rel="noopener" class="ext-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    Google Play
                </a>
                <a href="https://apps.apple.com/id/app/super-app-polri/id1617509708" target="_blank" rel="noopener" class="ext-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
                    App Store
                </a>
            </div>
        </div>

        {{-- SIM ONLINE --}}
        <div class="card">
            <div class="card-band band-green"></div>
            <div class="card-inner">
                <div class="card-meta"><span class="card-chip chip-green">Surat Izin Mengemudi</span></div>
                <div class="card-title">SIM Online</div>
                <p class="card-desc">Perpanjangan SIM kini bisa dilakukan online melalui aplikasi Digital Korlantas Polri — tanpa perlu datang ke Satpas.</p>
                <ul class="card-list">
                    <li><span class="check check-green">✓</span> Perpanjangan SIM A, B, C secara online</li>
                    <li><span class="check check-green">✓</span> SIM dikirim langsung ke alamat rumah</li>
                    <li><span class="check check-green">✓</span> Proses cepat via aplikasi Digital Korlantas</li>
                </ul>
            </div>
            <div class="ext-links">
                <span class="ext-links-label">Unduh Aplikasi Digital Korlantas</span>
                <a href="https://play.google.com/store/apps/details?id=id.qoin.korlantas.user" target="_blank" rel="noopener" class="ext-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    Google Play
                </a>
                <a href="https://apps.apple.com/id/app/digital-korlantas-polri/id1565558949" target="_blank" rel="noopener" class="ext-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
                    App Store
                </a>
            </div>
        </div>

        {{-- PENERIMAAN POLRI --}}
        <div class="card">
            <div class="card-band band-red"></div>
            <div class="card-inner">
                <div class="card-meta"><span class="card-chip chip-red">Rekrutmen</span></div>
                <div class="card-title">Penerimaan Polri</div>
                <p class="card-desc">Informasi lengkap pendaftaran penerimaan anggota Polri: Akpol, Bintara, Tamtama, dan SIPSS melalui portal resmi.</p>
                <ul class="card-list">
                    <li><span class="check check-red">✓</span> Jalur Akpol, Bintara, Tamtama & SIPSS</li>
                    <li><span class="check check-red">✓</span> Pendaftaran online di portal resmi Polri</li>
                    <li><span class="check check-red">✓</span> Gratis — waspada calo & penipuan</li>
                </ul>
            </div>
            <div class="ext-links">
                <span class="ext-links-label">Akses Portal Resmi</span>
                <a href="https://penerimaan.polri.go.id/" target="_blank" rel="noopener" class="ext-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    penerimaan.polri.go.id
                </a>
            </div>
        </div>

        {{-- WBS --}}
        <div class="card">
            <div class="card-band band-amber"></div>
            <div class="card-inner">
                <div class="card-meta"><span class="card-chip chip-amber">Pengaduan Rahasia</span></div>
                <div class="card-title">WBS</div>
                <p class="card-desc">Whistle Blowing System untuk melaporkan dugaan pelanggaran anggota Polri secara aman dengan identitas yang terjamin rahasianya.</p>
                <ul class="card-list">
                    <li><span class="check check-amber">✓</span> Identitas pelapor dijamin rahasia</li>
                    <li><span class="check check-amber">✓</span> Laporan ditangani secara profesional</li>
                    <li><span class="check check-amber">✓</span> Dilindungi dari tindakan balasan</li>
                </ul>
            </div>
            <div class="ext-links">
                <span class="ext-links-label">Akses Portal Resmi</span>
                <a href="https://wbs.polri.go.id" target="_blank" rel="noopener" class="ext-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    wbs.polri.go.id
                </a>
            </div>
        </div>

        {{-- E-SURVEY --}}
        <div class="card">
            <div class="card-band" style="background:linear-gradient(90deg,#065f46,#059669);"></div>
            <div class="card-inner">
                <div class="card-meta">
                    <span class="card-chip" style="background:#ecfdf5;color:#059669;">Survei Kepuasan</span>
                </div>
                <div class="card-title">E-Survey Pelayanan</div>
                <p class="card-desc">Berikan penilaian dan masukan atas layanan yang telah kamu terima. Survei resmi dari Polri untuk meningkatkan kualitas pelayanan publik.</p>
                <ul class="card-list">
                    <li><span class="check" style="background:#059669;">✓</span> Penilaian layanan secara online</li>
                    <li><span class="check" style="background:#059669;">✓</span> Masukan langsung ke sistem Polri</li>
                    <li><span class="check" style="background:#059669;">✓</span> Membantu peningkatan kualitas layanan</li>
                </ul>
            </div>
            <div class="ext-links">
                <span class="ext-links-label">Akses E-Survey Resmi</span>
                <a href="https://esurveypelayanan.polri.go.id/#/reg/2466726035434743189" target="_blank" rel="noopener" class="ext-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    Isi E-Survey Sekarang
                </a>
            </div>
        </div>

        {{-- PERPUSTAKAAN DATA --}}
        <div class="card">
            <div class="card-band" style="background:linear-gradient(90deg,#4c1d95,#7c3aed);"></div>
            <div class="card-inner">
                <div class="card-meta">
                    <span class="card-chip" style="background:#f5f3ff;color:#7c3aed;">Referensi & Data</span>
                </div>
                <div class="card-title">Perpustakaan Data</div>
                <p class="card-desc">Akses kumpulan dokumen, regulasi, dan data informasi publik Polres Gunungkidul yang tersedia untuk masyarakat umum secara terbuka.</p>
                <ul class="card-list">
                    <li><span class="check" style="background:#7c3aed;">✓</span> Dokumen & regulasi publik tersedia</li>
                    <li><span class="check" style="background:#7c3aed;">✓</span> Data statistik pelayanan Polres</li>
                    <li><span class="check" style="background:#7c3aed;">✓</span> Informasi terbuka & transparan</li>
                </ul>
            </div>
            <div class="ext-links">
                <span class="ext-links-label">Akses Perpustakaan Data</span>
                <a href="{{ route('information.perpusdata') }}" class="ext-badge" style="opacity:0.55;pointer-events:none;cursor:default;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Segera Hadir
                </a>
            </div>
        </div>

    </div>
</div>

{{-- FOOTER --}}
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

@push('scripts')
<script>
// ===== DARK MODE =====
(function () {
    const html = document.documentElement;
    const btn  = document.getElementById('darkToggle');
    const KEY  = 'theme';
    function applyTheme(dark) { dark ? html.classList.add('dark') : html.classList.remove('dark'); }
    applyTheme(localStorage.getItem(KEY) === 'dark');
    btn.addEventListener('click', function () {
        const isDark = html.classList.toggle('dark');
        localStorage.setItem(KEY, isDark ? 'dark' : 'light');
    });
    if (!localStorage.getItem(KEY)) {
        const mq = window.matchMedia('(prefers-color-scheme: dark)');
        applyTheme(mq.matches);
        mq.addEventListener('change', e => { if (!localStorage.getItem(KEY)) applyTheme(e.matches); });
    }
})();

// ===== CUACA REAL-TIME =====
(function () {
    const LAT = -7.9408, LON = 110.5993, TZ = 'Asia%2FJakarta';
    const WMO = {
        0:{e:'☀️',d:'Cerah'}, 1:{e:'🌤️',d:'Umumnya Cerah'}, 2:{e:'⛅',d:'Berawan Sebagian'},
        3:{e:'☁️',d:'Berawan'}, 45:{e:'🌫️',d:'Berkabut'},
        51:{e:'🌦️',d:'Gerimis Ringan'}, 53:{e:'🌦️',d:'Gerimis Sedang'}, 55:{e:'🌧️',d:'Gerimis Lebat'},
        61:{e:'🌧️',d:'Hujan Ringan'}, 63:{e:'🌧️',d:'Hujan Sedang'}, 65:{e:'🌧️',d:'Hujan Lebat'},
        80:{e:'🌦️',d:'Hujan Lokal'}, 81:{e:'🌧️',d:'Hujan Lokal Sedang'}, 82:{e:'⛈️',d:'Hujan Lokal Lebat'},
        95:{e:'⛈️',d:'Hujan Petir'}, 96:{e:'⛈️',d:'Petir + Es'}, 99:{e:'⛈️',d:'Petir + Es Besar'},
    };
    const HARI = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];
    function wmo(c) { return WMO[c] || {e:'🌡️',d:'—'}; }
    const API = 'https://api.open-meteo.com/v1/forecast?latitude='+LAT+'&longitude='+LON+'&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m,precipitation&daily=weather_code,temperature_2m_max,temperature_2m_min,precipitation_probability_max&timezone='+TZ+'&forecast_days=7';
    function $d(id) { return document.getElementById(id); }
    const $icon=$d('wxIcon'), $temp=$d('wxTemp'), $desc=$d('wxDesc'), $hum=$d('wxHum'), $wnd=$d('wxWnd'), $prcp=$d('wxPrcp'), $days=$d('wxDays'), $btn=$d('wxRefresh');
    async function load() {
        $btn.classList.add('spinning');
        try {
            const r = await fetch(API); if (!r.ok) throw new Error(r.status);
            const d = await r.json(), c = d.current, dl = d.daily, w = wmo(c.weather_code);
            $icon.textContent = w.e; $temp.textContent = Math.round(c.temperature_2m)+'°C'; $desc.textContent = w.d;
            $hum.textContent = '💧 '+c.relative_humidity_2m+'%';
            $wnd.textContent = '💨 '+Math.round(c.wind_speed_10m)+' km/h';
            $prcp.textContent = '☔ '+c.precipitation+' mm';
            $days.innerHTML = '';
            dl.time.forEach((dt, i) => {
                const today = i===0, day = new Date(dt+'T00:00:00'), dw = wmo(dl.weather_code[i]);
                const hi = Math.round(dl.temperature_2m_max[i]), lo = Math.round(dl.temperature_2m_min[i]);
                const p = document.createElement('div');
                p.className = 'wx-bar-day'+(today?' wx-today-pill':'');
                p.title = dw.d+' · Hujan: '+(dl.precipitation_probability_max[i]??0)+'%';
                p.innerHTML = '<span class="wx-bar-day-name">'+(today?'Hari ini':HARI[day.getDay()])+'</span><span class="wx-bar-day-icon">'+dw.e+'</span><span class="wx-bar-day-temps">'+hi+'° <span class="wx-bar-day-lo">/ '+lo+'°</span></span>';
                $days.appendChild(p);
            });
        } catch(e) { $icon.textContent='⚠️'; $temp.textContent='--'; $desc.textContent='Gagal memuat'; }
        finally { $btn.classList.remove('spinning'); }
    }
    $btn.addEventListener('click', load); load(); setInterval(load, 10*60*1000);
})();
</script>
@endpush