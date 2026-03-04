@extends('layouts.app')

@section('title', 'E-Survey Pelayanan - Polres Gunungkidul')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    :root { --navy:#0a1628;--blue:#1a3a6e;--accent:#2563eb;--gold:#f0a500;--gold-lt:#fbbf24;--surface:#f4f6fa;--white:#ffffff;--text:#1a1f2e;--muted:#6b7280;--border:#e2e8f0;--radius:16px;--green:#059669;--green-lt:#ecfdf5; }
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
    .hero::after { content:''; position:absolute; right:-80px; top:-80px; width:480px; height:480px; background:radial-gradient(circle,rgba(5,150,105,0.2) 0%,transparent 70%); pointer-events:none; }
    .hero-inner { max-width:1100px; margin:0 auto; position:relative; z-index:1; }
    .hero-tag { display:inline-flex; align-items:center; gap:8px; background:rgba(5,150,105,0.15); border:1px solid rgba(5,150,105,0.35); color:#6ee7b7; font-size:12px; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; padding:6px 14px; border-radius:100px; margin-bottom:22px; }
    .hero-tag::before { content:'●'; font-size:8px; }
    .hero h1 { font-family:'DM Serif Display',serif; font-size:48px; color:var(--white); line-height:1.1; margin-bottom:16px; letter-spacing:-0.5px; }
    .hero h1 em { font-style:italic; color:#6ee7b7; }
    .hero p { font-size:15px; color:rgba(255,255,255,0.55); line-height:1.8; max-width:520px; }
    .hero-breadcrumb { display:flex; align-items:center; gap:8px; margin-top:28px; font-size:12.5px; color:rgba(255,255,255,0.35); }
    .hero-breadcrumb a { color:rgba(255,255,255,0.5); text-decoration:none; transition:color 0.2s; }
    .hero-breadcrumb a:hover { color:var(--gold-lt); }
    .hero-breadcrumb span.sep { opacity:0.4; }
    .hero-breadcrumb span.current { color:rgba(255,255,255,0.7); }

    .main-wrap { max-width:900px; margin:0 auto; padding:52px 40px 100px; }

    /* CTA Card utama */
    .cta-card { background: var(--white); border-radius: 20px; border: 1px solid var(--border); overflow: hidden; margin-bottom: 32px; }
    .cta-card-band { height: 6px; background: linear-gradient(90deg,#065f46,#059669); }
    .cta-card-inner { padding: 36px 36px 32px; display: flex; align-items: center; gap: 32px; }
    .cta-icon-big { width: 72px; height: 72px; border-radius: 20px; background: var(--green-lt); display: flex; align-items: center; justify-content: center; font-size: 36px; flex-shrink: 0; }
    .cta-text h2 { font-size: 22px; font-weight: 800; color: var(--text); margin-bottom: 8px; }
    .cta-text p { font-size: 14px; color: var(--muted); line-height: 1.7; }
    .cta-btn-wrap { flex-shrink: 0; }
    .cta-btn { display: inline-flex; align-items: center; gap: 10px; padding: 14px 28px; background: linear-gradient(135deg,#065f46,#059669); color: #fff; font-size: 14px; font-weight: 700; border-radius: 12px; text-decoration: none; transition: all 0.25s; box-shadow: 0 6px 20px rgba(5,150,105,0.35); }
    .cta-btn:hover { filter: brightness(1.1); transform: translateY(-2px); box-shadow: 0 10px 28px rgba(5,150,105,0.45); }

    /* Info sections */
    .section-title { font-size: 16px; font-weight: 800; color: var(--text); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
    .info-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 16px; margin-bottom: 32px; }
    .info-box { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px 22px; }
    .info-box-icon { font-size: 24px; margin-bottom: 10px; }
    .info-box-title { font-size: 13px; font-weight: 700; color: var(--text); margin-bottom: 6px; }
    .info-box-desc { font-size: 13px; color: var(--muted); line-height: 1.65; }

    .steps-wrap { background: var(--white); border: 1px solid var(--border); border-radius: 20px; padding: 28px 32px; margin-bottom: 32px; }
    .step { display: flex; gap: 16px; align-items: flex-start; padding: 14px 0; border-bottom: 1px solid var(--border); }
    .step:last-child { border-bottom: none; padding-bottom: 0; }
    .step:first-child { padding-top: 0; }
    .step-num { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg,#065f46,#059669); color: #fff; font-size: 13px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px; }
    .step-text { flex: 1; }
    .step-title { font-size: 14px; font-weight: 700; color: var(--text); margin-bottom: 4px; }
    .step-desc { font-size: 13px; color: var(--muted); line-height: 1.6; }

    .notice { display:flex; align-items:center; gap:14px; background:#ecfdf5; border:1px solid #a7f3d0; border-left:4px solid var(--green); border-radius:var(--radius); padding:16px 20px; margin-bottom:32px; }
    .notice-icon { font-size:20px; flex-shrink:0; }
    .notice p { font-size:13.5px; color:#065f46; line-height:1.6; }
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

    @media (max-width:768px) { .cta-card-inner{flex-direction:column;gap:20px} .cta-btn-wrap{width:100%} .cta-btn{width:100%;justify-content:center} .info-grid{grid-template-columns:1fr} .hero{padding:44px 28px 52px} .hero h1{font-size:34px} header{padding:0 24px} .main-wrap{padding:36px 24px 72px} .footer-location{padding:18px 28px} .footer-main{padding:44px 28px 28px} .footer-grid{grid-template-columns:1fr 1fr} .steps-wrap{padding:20px} }
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
        <div class="hero-tag">Survei Kepuasan</div>
        <h1>E-Survey<br><em>Pelayanan</em></h1>
        <p>Sampaikan penilaian dan masukan atas layanan Polres Gunungkidul secara online. Suara kamu sangat berarti untuk meningkatkan kualitas pelayanan kami.</p>
        <div class="hero-breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">›</span>
            <a href="{{ route('information') }}">Informasi Pelayanan</a>
            <span class="sep">›</span>
            <span class="current">E-Survey Pelayanan</span>
        </div>
    </div>
</section>

<div class="main-wrap">

    <div class="notice">
        <div class="notice-icon">📣</div>
        <p><strong>Pendapat kamu penting!</strong> Hasil survei ini digunakan langsung oleh Polri untuk meningkatkan mutu pelayanan publik di seluruh Indonesia.</p>
    </div>

    {{-- CTA Utama --}}
    <div class="cta-card">
        <div class="cta-card-band"></div>
        <div class="cta-card-inner">
            <div class="cta-icon-big">📊</div>
            <div class="cta-text">
                <h2>Isi Survei Kepuasan Sekarang</h2>
                <p>Berikan penilaian jujur atas layanan yang telah kamu terima dari Polres Gunungkidul. Survei hanya membutuhkan waktu <strong>2–3 menit</strong>.</p>
            </div>
            <div class="cta-btn-wrap">
                <a href="https://esurveypelayanan.polri.go.id/#/reg/2466726035434743189" target="_blank" rel="noopener" class="cta-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    Mulai Isi Survei
                </a>
            </div>
        </div>
    </div>

    {{-- Info boxes --}}
    <p class="section-title">📌 Mengapa Survei Ini Penting?</p>
    <div class="info-grid">
        <div class="info-box">
            <div class="info-box-icon">🎯</div>
            <div class="info-box-title">Meningkatkan Kualitas Layanan</div>
            <div class="info-box-desc">Setiap masukan kamu menjadi bahan evaluasi langsung bagi Polres Gunungkidul untuk terus memperbaiki layanannya.</div>
        </div>
        <div class="info-box">
            <div class="info-box-icon">🔒</div>
            <div class="info-box-title">Identitas Terjaga</div>
            <div class="info-box-desc">Pengisian survei dapat dilakukan secara anonim. Data kamu aman dan hanya digunakan untuk keperluan evaluasi internal.</div>
        </div>
        <div class="info-box">
            <div class="info-box-icon">⚡</div>
            <div class="info-box-title">Cepat & Mudah</div>
            <div class="info-box-desc">Survei dirancang singkat dan simpel — cukup 2 sampai 3 menit untuk selesai, bisa diisi dari HP maupun komputer.</div>
        </div>
        <div class="info-box">
            <div class="info-box-icon">🏛️</div>
            <div class="info-box-title">Program Resmi Polri</div>
            <div class="info-box-desc">E-Survey adalah program resmi yang dikelola langsung oleh Polri untuk mengukur Indeks Kepuasan Masyarakat (IKM).</div>
        </div>
    </div>

    {{-- Langkah pengisian --}}
    <p class="section-title">📋 Cara Mengisi E-Survey</p>
    <div class="steps-wrap">
        <div class="step">
            <div class="step-num">1</div>
            <div class="step-text">
                <div class="step-title">Klik tombol "Mulai Isi Survei"</div>
                <div class="step-desc">Kamu akan diarahkan ke portal resmi E-Survey Pelayanan Polri di tab baru.</div>
            </div>
        </div>
        <div class="step">
            <div class="step-num">2</div>
            <div class="step-text">
                <div class="step-title">Pilih layanan yang pernah kamu gunakan</div>
                <div class="step-desc">Tentukan jenis layanan yang telah kamu terima, misalnya SKCK, SIM, atau layanan lainnya.</div>
            </div>
        </div>
        <div class="step">
            <div class="step-num">3</div>
            <div class="step-text">
                <div class="step-title">Isi penilaian dengan jujur</div>
                <div class="step-desc">Berikan skor dan komentar berdasarkan pengalaman nyata kamu saat menggunakan layanan tersebut.</div>
            </div>
        </div>
        <div class="step">
            <div class="step-num">4</div>
            <div class="step-text">
                <div class="step-title">Kirim survei</div>
                <div class="step-desc">Tekan tombol kirim dan survei kamu langsung masuk ke sistem Polri. Terima kasih atas partisipasinya! 🎉</div>
            </div>
        </div>
    </div>

    <div style="text-align:center;">
        <a href="https://esurveypelayanan.polri.go.id/#/reg/2466726035434743189" target="_blank" rel="noopener" class="cta-btn" style="display:inline-flex;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            Isi E-Survey Sekarang
        </a>
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