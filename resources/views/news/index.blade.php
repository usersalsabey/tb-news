@extends('layouts.app')

@section('title', 'Tribratanews - Polres Gunungkidul')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    :root { --navy:#0a1628;--blue:#1a3a6e;--accent:#2563eb;--gold:#f0a500;--gold-lt:#fbbf24;--surface:#f4f6fa;--white:#ffffff;--text:#1a1f2e;--muted:#6b7280;--border:#e2e8f0; }

    /* ===== DARK MODE ===== */
    html.dark {
        --surface: #0f1923;
        --white:   #1a2535;
        --text:    #e2e8f0;
        --muted:   #94a3b8;
        --border:  #1e2d42;
    }

    body, .news-card, .news-list-item, .filter-tab,
    .view-toggle, .page-btn, .result-count,
    .card-title, .card-excerpt, .list-title, .list-excerpt {
        transition: background-color 0.3s ease, color 0.3s ease,
                    border-color 0.3s ease, box-shadow 0.3s ease;
    }

    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--surface); color: var(--text); overflow-x: hidden; }
    html.dark body { background: var(--surface); color: var(--text); }

    header { background:var(--navy); padding:0 56px; display:flex; justify-content:space-between; align-items:center; height:72px; position:sticky; top:0; z-index:1000; border-bottom:1px solid rgba(255,255,255,0.06); }
    .logo { display:flex; align-items:center; gap:14px; text-decoration:none; }
    .logo img { width:44px; height:44px; object-fit:contain; }
    .logo-text { display:flex; flex-direction:column; }
    .logo-text span:first-child { font-size:15px; font-weight:800; color:var(--white); line-height:1.2; }
    .logo-text span:last-child { font-size:11px; color:var(--gold); font-weight:500; letter-spacing:0.8px; text-transform:uppercase; }

    .header-right { display:flex; align-items:center; gap:4px; }
    nav ul { display:flex; list-style:none; gap:4px; }
    nav ul li a { text-decoration:none; color:rgba(255,255,255,0.65); font-size:13.5px; font-weight:600; padding:8px 16px; border-radius:8px; transition:all 0.2s; display:block; }
    nav ul li a:hover { color:var(--white); background:rgba(255,255,255,0.08); }
    nav ul li a.active { color:var(--white); background:var(--accent); }

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
    .hero { position:relative; overflow:hidden; height:480px; }
    .hero-bg { position:absolute; inset:0; }
    .hero-bg img { width:100%; height:100%; object-fit:cover; display:block; }
    .hero-bg::after { content:''; position:absolute; inset:0; background:linear-gradient(to bottom, rgba(10,22,40,0.35) 0%, rgba(10,22,40,0.72) 100%); }
    .hero-inner { position:absolute; inset:0; z-index:2; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding:0 56px; }
    .hero-tag { display:inline-flex; align-items:center; gap:8px; background:rgba(240,165,0,0.18); border:1px solid rgba(240,165,0,0.4); color:var(--gold-lt); font-size:11px; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; padding:6px 16px; border-radius:100px; margin-bottom:20px; }
    .hero-tag::before { content:'\25cf'; font-size:8px; }
    .hero h1 { font-family:'DM Serif Display',serif; font-size:56px; color:var(--white); line-height:1.1; margin-bottom:14px; letter-spacing:-0.5px; text-shadow:0 4px 24px rgba(0,0,0,0.4); }
    .hero h1 em { font-style:italic; color:var(--gold-lt); }
    .hero-desc { font-size:15px; color:rgba(255,255,255,0.75); line-height:1.8; max-width:520px; }
    .hero-breadcrumb { display:flex; align-items:center; gap:8px; margin-top:16px; font-size:12.5px; color:rgba(255,255,255,0.5); }
    .hero-breadcrumb a { color:rgba(255,255,255,0.65); text-decoration:none; transition:color 0.2s; }
    .hero-breadcrumb a:hover { color:var(--gold-lt); }
    .hero-breadcrumb span.sep { opacity:0.4; }
    .search-wrap { margin-top:28px; display:flex; gap:10px; max-width:560px; width:100%; }
    .search-input-wrap { flex:1; position:relative; }
    .search-icon { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:rgba(255,255,255,0.35); font-size:16px; pointer-events:none; }
    .search-input { width:100%; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); color:var(--white); font-family:inherit; font-size:14px; padding:12px 16px 12px 42px; border-radius:10px; outline:none; transition:all 0.2s; backdrop-filter:blur(8px); }
    .search-input::placeholder { color:rgba(255,255,255,0.4); }
    .search-input:focus { border-color:var(--gold); background:rgba(255,255,255,0.16); }
    .search-btn { padding:12px 22px; background:var(--accent); color:var(--white); border:none; border-radius:10px; font-family:inherit; font-size:13.5px; font-weight:700; cursor:pointer; transition:all 0.2s; white-space:nowrap; }
    .search-btn:hover { background:#1d4ed8; transform:translateY(-1px); box-shadow:0 8px 24px rgba(37,99,235,0.4); }

    /* ===== MAIN ===== */
    .main-wrap { max-width:1100px; margin:0 auto; padding:40px 40px 80px; }
    .toolbar { display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:28px; flex-wrap:wrap; }
    .filter-tabs { display:flex; gap:8px; flex-wrap:wrap; }
    .filter-tab { padding:7px 16px; border-radius:100px; font-size:13px; font-weight:600; cursor:pointer; border:1.5px solid var(--border); background:var(--white); color:var(--muted); transition:all 0.2s; user-select:none; }
    .filter-tab:hover { border-color:var(--accent); color:var(--accent); }
    .filter-tab.active { background:var(--accent); border-color:var(--accent); color:var(--white); }
    html.dark .filter-tab { background:#1a2535; border-color:#1e2d42; color:#94a3b8; }
    html.dark .filter-tab:hover { border-color:#60a5fa; color:#60a5fa; }

    .toolbar-right { display:flex; align-items:center; gap:12px; }
    .result-count { font-size:13px; color:var(--muted); }
    .result-count strong { color:var(--text); }
    .view-toggle { display:flex; gap:4px; background:var(--white); border:1.5px solid var(--border); border-radius:8px; padding:3px; }
    html.dark .view-toggle { background:#1a2535; border-color:#1e2d42; }
    .view-btn { width:32px; height:32px; border-radius:6px; border:none; background:transparent; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.2s; color:var(--muted); }
    .view-btn.active { background:var(--navy); color:var(--white); }
    .view-btn:hover:not(.active) { background:var(--surface); }

    .news-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
    .news-list { display:flex; flex-direction:column; gap:14px; }

    .news-card { background:var(--white); border-radius:18px; border:1px solid var(--border); overflow:hidden; display:flex; flex-direction:column; text-decoration:none; color:inherit; transition:transform 0.25s,box-shadow 0.25s,border-color 0.25s,background-color 0.3s; }
    .news-card:hover { transform:translateY(-5px); box-shadow:0 18px 44px rgba(10,22,40,0.11); border-color:transparent; }
    html.dark .news-card { background:#1a2535; border-color:#1e2d42; }
    html.dark .news-card:hover { box-shadow:0 18px 44px rgba(0,0,0,0.4); border-color:#2d3e55; }

    .card-image { width:100%; height:200px; background:var(--blue); overflow:hidden; position:relative; flex-shrink:0; }
    .card-image img { width:100%; height:100%; object-fit:cover; display:block; transition:transform 0.4s; }
    .news-card:hover .card-image img { transform:scale(1.05); }
    .card-image-placeholder { width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:52px; }
    .cat-umum { background:linear-gradient(135deg,#1a3a6e,#2563eb); }
    .cat-lalu_lintas { background:linear-gradient(135deg,#064e3b,#10b981); }
    .cat-sosial { background:linear-gradient(135deg,#7f1d1d,#ef4444); }
    .cat-pelayanan { background:linear-gradient(135deg,#78350f,#f59e0b); }
    .cat-kriminal { background:linear-gradient(135deg,#1e1b4b,#6366f1); }
    .card-cat-badge { position:absolute; top:12px; left:12px; font-size:10.5px; font-weight:700; letter-spacing:1px; text-transform:uppercase; padding:4px 10px; border-radius:100px; color:var(--white); background:rgba(0,0,0,0.35); backdrop-filter:blur(4px); }
    .card-body { padding:20px 20px 16px; flex:1; display:flex; flex-direction:column; gap:8px; }
    .card-date { font-size:11.5px; font-weight:700; letter-spacing:0.8px; text-transform:uppercase; color:var(--accent); }
    html.dark .card-date { color:#60a5fa; }
    .card-title { font-size:15.5px; font-weight:800; color:var(--text); line-height:1.35; }
    .card-excerpt { font-size:13px; color:var(--muted); line-height:1.7; flex:1; }
    .card-readmore { display:inline-flex; align-items:center; gap:5px; font-size:12.5px; font-weight:700; color:var(--accent); margin-top:8px; transition:gap 0.2s; }
    html.dark .card-readmore { color:#60a5fa; }
    .news-card:hover .card-readmore { gap:9px; }

    .news-list-item { background:var(--white); border-radius:14px; border:1px solid var(--border); overflow:hidden; display:flex; text-decoration:none; color:inherit; transition:transform 0.2s,box-shadow 0.2s,border-color 0.2s,background-color 0.3s; }
    .news-list-item:hover { transform:translateX(4px); box-shadow:0 8px 28px rgba(10,22,40,0.09); border-color:transparent; }
    html.dark .news-list-item { background:#1a2535; border-color:#1e2d42; }
    html.dark .news-list-item:hover { box-shadow:0 8px 28px rgba(0,0,0,0.35); }
    .list-image { width:200px; min-height:140px; flex-shrink:0; overflow:hidden; position:relative; }
    .list-image img { width:100%; height:100%; object-fit:cover; display:block; transition:transform 0.3s; }
    .news-list-item:hover .list-image img { transform:scale(1.05); }
    .list-image-placeholder { width:100%; height:100%; min-height:140px; display:flex; align-items:center; justify-content:center; font-size:40px; }
    .list-body { padding:20px 22px; display:flex; flex-direction:column; justify-content:center; gap:7px; flex:1; }
    .list-meta { display:flex; align-items:center; gap:10px; }
    .list-date { font-size:11.5px; font-weight:700; letter-spacing:0.8px; text-transform:uppercase; color:var(--accent); }
    html.dark .list-date { color:#60a5fa; }
    .list-cat { font-size:10.5px; font-weight:700; letter-spacing:0.8px; text-transform:uppercase; padding:3px 9px; border-radius:100px; background:#eff6ff; color:var(--accent); }
    html.dark .list-cat { background:#1e3a5f; color:#60a5fa; }
    .list-title { font-size:17px; font-weight:800; color:var(--text); line-height:1.3; }
    .list-excerpt { font-size:13.5px; color:var(--muted); line-height:1.7; }
    .list-readmore { display:inline-flex; align-items:center; gap:5px; font-size:13px; font-weight:700; color:var(--accent); margin-top:4px; transition:gap 0.2s; }
    html.dark .list-readmore { color:#60a5fa; }
    .news-list-item:hover .list-readmore { gap:9px; }

    .empty-state { text-align:center; padding:80px 20px; display:none; }
    .empty-state-icon { font-size:56px; margin-bottom:16px; }
    .empty-state h3 { font-size:20px; font-weight:800; color:var(--text); margin-bottom:8px; }
    .empty-state p { font-size:14px; color:var(--muted); }
    .empty-state.visible { display:block; }

    .pagination-wrap { display:flex; justify-content:center; align-items:center; gap:6px; margin-top:48px; flex-wrap:wrap; }
    .page-btn { width:38px; height:38px; border-radius:9px; border:1.5px solid var(--border); background:var(--white); font-family:inherit; font-size:13.5px; font-weight:600; color:var(--text); cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.2s; }
    .page-btn:hover:not(:disabled):not(.active) { border-color:var(--accent); color:var(--accent); }
    .page-btn.active { background:var(--accent); border-color:var(--accent); color:var(--white); }
    .page-btn:disabled { opacity:0.35; cursor:not-allowed; }
    .page-btn.arrow { font-size:16px; }
    .page-dots { color:var(--muted); padding:0 4px; font-size:14px; }
    html.dark .page-btn { background:#1a2535; border-color:#1e2d42; color:#e2e8f0; }
    html.dark .page-btn:hover:not(:disabled):not(.active) { border-color:#60a5fa; color:#60a5fa; }

    /* ===== FOOTER ===== */
    footer { background:var(--navy); color:var(--white); padding:0; }
    html.dark footer { background:#060d18; }
    .footer-location { background:#0d1e38; border-bottom:1px solid rgba(255,255,255,0.06); padding:20px 56px; }
    html.dark .footer-location { background:#080f1a; }
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

    /* ===== WEATHER BAR ===== */
    .wx-bar { background: #0d1e38; border-bottom: 1px solid rgba(255,255,255,0.07); padding: 0 56px; height: 52px; display: flex; align-items: center; gap: 0; overflow: hidden; }
    html.dark .wx-bar { background:#080f1a; }
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
        .news-grid{grid-template-columns:repeat(2,1fr)} header{padding:0 24px}
        .main-wrap{padding:32px 24px 64px} .hero{height:400px} .hero h1{font-size:38px}
        .hero-inner{padding:0 32px} .footer-location{padding:18px 28px}
        .footer-main{padding:44px 28px 28px} .footer-grid{grid-template-columns:1fr 1fr}
    }
    @media (max-width:768px) { .wx-bar{padding:0 20px} .wx-bar-current{padding-right:12px} .wx-bar-desc{display:none} }
    @media (max-width:640px) {
        .news-grid{grid-template-columns:1fr} .list-image{width:120px} .list-title{font-size:15px}
        .toolbar{flex-direction:column;align-items:flex-start} .hero{height:320px}
        .hero h1{font-size:28px} .hero-inner{padding:0 20px} .search-wrap{flex-direction:column}
        .footer-location-inner{flex-direction:column;align-items:flex-start}
        .maps-btn{width:100%;justify-content:center} .footer-grid{grid-template-columns:1fr}
        .footer-bottom{flex-direction:column;gap:8px;text-align:center} nav ul li a{padding:7px 10px;font-size:12px}
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
                <li><a href="{{ route('news') }}" class="active">Tribratanews</a></li>
                <li><a href="{{ route('information') }}">Informasi Pelayanan</a></li>
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
        <img src="{{ asset('images/slideshow/news.jpg') }}" alt="Tribratanews Polres Gunungkidul">
    </div>
    <div class="hero-inner">
        <div class="hero-tag">Portal Berita</div>
        <h1>Tribrata<em>news</em></h1>
        <p class="hero-desc">Informasi terkini seputar kegiatan, layanan, dan pengamanan Polres Gunungkidul.</p>
        <div class="hero-breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">›</span>
            <span>Tribratanews</span>
        </div>
        <div class="search-wrap">
            <div class="search-input-wrap">
                <span class="search-icon">🔍</span>
                <input type="text" id="searchInput" class="search-input" placeholder="Cari berita..." autocomplete="off">
            </div>
            <button class="search-btn" onclick="applySearch()">Cari</button>
        </div>
    </div>
</section>

{{-- MAIN --}}
<div class="main-wrap">
    <div class="toolbar">
        <div class="filter-tabs" id="filterTabs">
            <span class="filter-tab active" data-cat="semua">Semua</span>
            <span class="filter-tab" data-cat="umum">Umum</span>
            <span class="filter-tab" data-cat="lalu_lintas">Lalu Lintas</span>
            <span class="filter-tab" data-cat="sosial">Sosial</span>
            <span class="filter-tab" data-cat="pelayanan">Pelayanan</span>
            <span class="filter-tab" data-cat="kriminal">Kriminal</span>
        </div>
        <div class="toolbar-right">
            <span class="result-count" id="resultCount">Menampilkan <strong>0</strong> berita</span>
            <div class="view-toggle">
                <button class="view-btn active" id="btnGrid" onclick="setView('grid')" title="Grid">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="currentColor"><rect x="0" y="0" width="6" height="6" rx="1.5"/><rect x="8" y="0" width="6" height="6" rx="1.5"/><rect x="0" y="8" width="6" height="6" rx="1.5"/><rect x="8" y="8" width="6" height="6" rx="1.5"/></svg>
                </button>
                <button class="view-btn" id="btnList" onclick="setView('list')" title="List">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="currentColor"><rect x="0" y="0" width="14" height="3" rx="1.5"/><rect x="0" y="5.5" width="14" height="3" rx="1.5"/><rect x="0" y="11" width="14" height="3" rx="1.5"/></svg>
                </button>
            </div>
        </div>
    </div>
    <div id="newsContainer" class="news-grid"></div>
    <div class="empty-state" id="emptyState">
        <div class="empty-state-icon">🔍</div>
        <h3>Berita tidak ditemukan</h3>
        <p>Coba kata kunci lain atau pilih kategori yang berbeda.</p>
    </div>
    <div class="pagination-wrap" id="paginationWrap"></div>
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
                <p>Jln. MGR Sugiyopranoto No.15, Wonosari, Gunungkidul, Yogyakarta.</p>
            </div>
            <div class="footer-col">
                <h5>Kontak</h5>
                <p>📧 ppidgunungkidul@gmail.com</p>
                <p>📞 0851-3375-0875</p>
                <p>🚨 110 (Darurat)</p>
                <p>🕐 24 Jam</p>
            </div>
            <div class="footer-col">
                <h5>Navigasi</h5>
                <a href="{{ route('profile') }}">Profil</a>
                <a href="{{ route('information') }}">Informasi Pelayanan</a>
                <a href="{{ route('news') }}">Tribratanews</a>
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

// ===== NEWS DATA & RENDER =====
const ALL_NEWS = [
    { slug:'operasi-ketertiban-lalu-lintas', title:'Operasi Ketertiban Lalu Lintas Gabungan', excerpt:'Kepolisian mengadakan operasi gabungan untuk meningkatkan keselamatan dan ketertiban masyarakat di seluruh wilayah Gunungkidul.', date:'10 Februari 2026', category:'lalu_lintas', icon:'🚦', images:[] },
    { slug:'pelayanan-sim-online', title:'Pelayanan SIM Online Kini Lebih Mudah', excerpt:'Kini masyarakat dapat memperpanjang SIM secara online melalui layanan resmi Digital Korlantas Polri tanpa antrian panjang.', date:'08 Februari 2026', category:'pelayanan', icon:'🆔', images:[] },
    { slug:'program-polisi-sahabat-anak', title:'Program Polisi Sahabat Anak Hadir di Gunungkidul', excerpt:'Inisiatif terbaru untuk mendekatkan diri dengan generasi muda dan memberikan edukasi keamanan sejak dini kepada anak-anak.', date:'05 Februari 2026', category:'sosial', icon:'👮', images:[] },
    { slug:'bakti-sosial-polres-gunungkidul', title:'Bakti Sosial Polres Gunungkidul untuk Warga Kurang Mampu', excerpt:'Polres Gunungkidul menggelar bakti sosial pembagian sembako dan layanan kesehatan gratis bagi warga yang membutuhkan.', date:'02 Februari 2026', category:'sosial', icon:'🤝', images:[] },
    { slug:'patroli-malam-kamtibmas', title:'Patroli Malam Rutin Jaga Keamanan Wilayah', excerpt:'Unit Samapta Polres Gunungkidul rutin melaksanakan patroli malam untuk memastikan keamanan dan ketertiban di seluruh wilayah.', date:'28 Januari 2026', category:'umum', icon:'🚓', images:[] },
    { slug:'sosialisasi-narkoba-di-sekolah', title:'Sosialisasi Bahaya Narkoba di SMA se-Gunungkidul', excerpt:'Satuan Narkoba Polres Gunungkidul menggelar sosialisasi bahaya narkoba kepada pelajar di berbagai sekolah menengah atas.', date:'25 Januari 2026', category:'sosial', icon:'📢', images:[] },
    { slug:'penangkapan-pelaku-curanmor', title:'Polres Gunungkidul Berhasil Tangkap Pelaku Curanmor', excerpt:'Tim Reskrim Polres Gunungkidul berhasil mengungkap jaringan pencurian kendaraan bermotor yang beroperasi di tiga kecamatan.', date:'20 Januari 2026', category:'kriminal', icon:'🔒', images:[] },
    { slug:'skck-online-gunungkidul', title:'Layanan SKCK Online Semakin Cepat dan Mudah', excerpt:'Polres Gunungkidul terus berinovasi dalam pelayanan SKCK online agar masyarakat tidak perlu antri lama di kantor polisi.', date:'15 Januari 2026', category:'pelayanan', icon:'📋', images:[] },
    { slug:'apel-perdana-tahun-2026', title:'Apel Perdana 2026: Polres Siap Tingkatkan Profesionalisme', excerpt:'Kapolres Gunungkidul memimpin apel perdana tahun 2026 dan menegaskan komitmen seluruh personel untuk meningkatkan pelayanan.', date:'02 Januari 2026', category:'umum', icon:'🏋️', images:[] },
    { slug:'pengamanan-nataru-2025', title:'Pengamanan Natal dan Tahun Baru 2025 Berjalan Aman', excerpt:'Seluruh personel Polres Gunungkidul berhasil mengamankan perayaan Natal dan Tahun Baru dengan zero insiden keamanan.', date:'01 Januari 2026', category:'umum', icon:'🛡️', images:[] },
    { slug:'tilang-elektronik-mulai-berlaku', title:'Tilang Elektronik (ETLE) Mulai Berlaku di Gunungkidul', excerpt:'Polres Gunungkidul resmi mengoperasikan sistem tilang elektronik untuk meningkatkan kepatuhan berlalu lintas secara modern.', date:'20 Desember 2025', category:'lalu_lintas', icon:'📷', images:[] },
    { slug:'donor-darah-polres-gunungkidul', title:'Donor Darah Massal: Polres Sumbang 150 Kantong Darah', excerpt:'Dalam rangka HUT Bhayangkara, Polres Gunungkidul menggelar donor darah massal yang diikuti 200 personel dan masyarakat umum.', date:'10 Desember 2025', category:'sosial', icon:'💉', images:[] },
];

let currentView='grid', currentCategory='semua', currentSearch='', currentPage=1;
const PER_PAGE = 6;

function getFiltered() {
    return ALL_NEWS.filter(i =>
        (currentCategory === 'semua' || i.category === currentCategory) &&
        (!currentSearch || i.title.toLowerCase().includes(currentSearch.toLowerCase()) || i.excerpt.toLowerCase().includes(currentSearch.toLowerCase()))
    );
}
function getPaginated(f) { const s = (currentPage - 1) * PER_PAGE; return f.slice(s, s + PER_PAGE); }
function catLabel(c) { return {umum:'Umum',lalu_lintas:'Lalu Lintas',sosial:'Sosial',pelayanan:'Pelayanan',kriminal:'Kriminal'}[c] || c; }
function catBg(c) { return {umum:'cat-umum',lalu_lintas:'cat-lalu_lintas',sosial:'cat-sosial',pelayanan:'cat-pelayanan',kriminal:'cat-kriminal'}[c] || 'cat-umum'; }
function imageOrPlaceholder(item) {
    if (item.images && item.images.length > 0)
        return `<img src="{{ asset('/') }}${item.images[0]}" alt="${item.title}" onerror="this.parentElement.innerHTML='<div class=\\'card-image-placeholder ${catBg(item.category)}\\'>${item.icon}</div>'">`;
    return `<div class="card-image-placeholder ${catBg(item.category)}">${item.icon}</div>`;
}
function renderCard(item) {
    return `<a href="{{ url('/news') }}/${item.slug}" class="news-card">
        <div class="card-image">${imageOrPlaceholder(item)}<span class="card-cat-badge">${catLabel(item.category)}</span></div>
        <div class="card-body">
            <span class="card-date">${item.date}</span>
            <div class="card-title">${item.title}</div>
            <p class="card-excerpt">${item.excerpt}</p>
            <span class="card-readmore">Selengkapnya →</span>
        </div>
    </a>`;
}
function renderListItem(item) {
    return `<a href="{{ url('/news') }}/${item.slug}" class="news-list-item">
        <div class="list-image ${catBg(item.category)}">${imageOrPlaceholder(item)}</div>
        <div class="list-body">
            <div class="list-meta"><span class="list-date">${item.date}</span><span class="list-cat">${catLabel(item.category)}</span></div>
            <div class="list-title">${item.title}</div>
            <p class="list-excerpt">${item.excerpt}</p>
            <span class="list-readmore">Selengkapnya →</span>
        </div>
    </a>`;
}
function render() {
    const f = getFiltered(), p = getPaginated(f);
    const c = document.getElementById('newsContainer'), e = document.getElementById('emptyState');
    document.getElementById('resultCount').innerHTML = `Menampilkan <strong>${f.length}</strong> berita`;
    if (p.length === 0) {
        c.innerHTML = ''; c.style.display = 'none'; e.classList.add('visible');
    } else {
        c.style.display = ''; e.classList.remove('visible');
        c.className = currentView === 'grid' ? 'news-grid' : 'news-list';
        c.innerHTML = currentView === 'grid' ? p.map(renderCard).join('') : p.map(renderListItem).join('');
    }
    renderPagination(f.length);
}
function renderPagination(total) {
    const t = Math.ceil(total / PER_PAGE), w = document.getElementById('paginationWrap');
    if (t <= 1) { w.innerHTML = ''; return; }
    let h = `<button class="page-btn arrow" onclick="goPage(${currentPage-1})" ${currentPage===1?'disabled':''}>&#8249;</button>`;
    for (let i = 1; i <= t; i++) {
        if (i===1||i===t||(i>=currentPage-1&&i<=currentPage+1)) h += `<button class="page-btn ${i===currentPage?'active':''}" onclick="goPage(${i})">${i}</button>`;
        else if (i===currentPage-2||i===currentPage+2) h += '<span class="page-dots">…</span>';
    }
    h += `<button class="page-btn arrow" onclick="goPage(${currentPage+1})" ${currentPage===t?'disabled':''}>&#8250;</button>`;
    w.innerHTML = h;
}
function goPage(p) {
    const f = getFiltered(), t = Math.ceil(f.length / PER_PAGE);
    if (p < 1 || p > t) return;
    currentPage = p; render(); window.scrollTo({top:0,behavior:'smooth'});
}
document.querySelectorAll('.filter-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active'); currentCategory = tab.dataset.cat; currentPage = 1; render();
    });
});
function applySearch() { currentSearch = document.getElementById('searchInput').value.trim(); currentPage = 1; render(); }
document.getElementById('searchInput').addEventListener('keydown', e => { if (e.key === 'Enter') applySearch(); });
function setView(mode) {
    currentView = mode;
    document.getElementById('btnGrid').classList.toggle('active', mode === 'grid');
    document.getElementById('btnList').classList.toggle('active', mode === 'list');
    render();
}
render();

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