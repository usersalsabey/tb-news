@extends('layouts.app')

@section('title', $news['title'] . ' - Tribratanews Polres Gunungkidul')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    :root { --navy:#0a1628;--blue:#1a3a6e;--accent:#2563eb;--gold:#f0a500;--gold-lt:#fbbf24;--surface:#f4f6fa;--white:#ffffff;--text:#1a1f2e;--muted:#6b7280;--border:#e2e8f0; }
    html.dark { --surface:#0f1923; --white:#1a2535; --text:#e2e8f0; --muted:#94a3b8; --border:#1e2d42; }
    body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--surface); color:var(--text); overflow-x:hidden; transition:background-color 0.3s,color 0.3s; }

    /* ─── Weather Bar ─── */
    .wx-bar { background:#0d1e38; border-bottom:1px solid rgba(255,255,255,0.07); padding:0 56px; height:52px; display:flex; align-items:center; overflow:hidden; }
    html.dark .wx-bar { background:#080f1a; }
    .wx-bar-current { display:flex; align-items:center; gap:10px; flex-shrink:0; padding-right:20px; border-right:1px solid rgba(255,255,255,0.08); height:32px; }
    .wx-bar-icon { font-size:22px; } .wx-bar-temp { font-size:18px; font-weight:800; color:#fff; }
    .wx-bar-info { display:flex; flex-direction:column; gap:1px; }
    .wx-bar-desc { font-size:11.5px; font-weight:600; color:rgba(255,255,255,0.75); }
    .wx-bar-meta { display:flex; gap:10px; font-size:10px; color:rgba(255,255,255,0.35); }
    .wx-bar-days { display:flex; align-items:center; gap:4px; flex:1; overflow-x:auto; padding:0 16px; scrollbar-width:none; }
    .wx-bar-days::-webkit-scrollbar { display:none; }
    .wx-bar-day { display:flex; align-items:center; gap:6px; padding:5px 12px; border-radius:100px; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.06); flex-shrink:0; }
    .wx-bar-day.wx-today-pill { background:rgba(37,99,235,0.2); border-color:rgba(37,99,235,0.45); }
    .wx-bar-day-name { font-size:10.5px; font-weight:700; text-transform:uppercase; color:rgba(255,255,255,0.45); min-width:26px; }
    .wx-bar-day.wx-today-pill .wx-bar-day-name { color:#fbbf24; }
    .wx-bar-day-icon { font-size:16px; } .wx-bar-day-temps { font-size:11px; font-weight:700; color:#fff; white-space:nowrap; }
    .wx-bar-day-lo { color:rgba(255,255,255,0.35); }
    .wx-bar-refresh { flex-shrink:0; background:none; border:none; color:rgba(255,255,255,0.25); cursor:pointer; padding:6px; border-radius:6px; display:flex; align-items:center; }
    @keyframes wxSpin { to { transform:rotate(360deg); } }
    .wx-sk { background:rgba(255,255,255,0.07); border-radius:6px; animation:wxPulse 1.6s ease-in-out infinite; display:inline-block; }
    @keyframes wxPulse { 0%,100%{opacity:.4} 50%{opacity:.9} }

    /* ─── Hero ─── */
    .hero { position:relative; overflow:hidden; height:400px; }
    .hero-bg { position:absolute; inset:0; }
    .hero-bg img { width:100%; height:100%; object-fit:cover; display:block; }
    .hero-bg::after { content:''; position:absolute; inset:0; background:linear-gradient(to bottom, rgba(10,22,40,0.4) 0%, rgba(10,22,40,0.85) 100%); }
    .hero-inner { position:absolute; inset:0; z-index:2; display:flex; flex-direction:column; justify-content:flex-end; padding:0 56px 44px; max-width:900px; }
    .hero-badge { margin-bottom:14px; }
    .cat-badge { font-size:10.5px; font-weight:700; letter-spacing:1px; text-transform:uppercase; padding:5px 14px; border-radius:100px; color:#fff; background:var(--accent); }
    .hero-title { font-family:'DM Serif Display',serif; font-size:36px; color:#fff; line-height:1.2; margin-bottom:16px; text-shadow:0 2px 16px rgba(0,0,0,0.4); }
    .hero-meta { display:flex; align-items:center; gap:16px; flex-wrap:wrap; }
    .meta-item { display:flex; align-items:center; gap:6px; font-size:13px; color:rgba(255,255,255,0.65); font-weight:500; }
    .hero-breadcrumb { display:flex; align-items:center; gap:8px; margin-bottom:20px; font-size:12.5px; color:rgba(255,255,255,0.45); }
    .hero-breadcrumb a { color:rgba(255,255,255,0.6); text-decoration:none; }
    .hero-breadcrumb a:hover { color:var(--gold-lt); }
    .hero-breadcrumb span.sep { opacity:0.4; }

    /* ─── Layout ─── */
    .page-wrap { max-width:1100px; margin:0 auto; padding:44px 40px 80px; display:grid; grid-template-columns:1fr 320px; gap:40px; align-items:start; }

    /* ─── Article ─── */
    .article-body { background:var(--white); border-radius:20px; border:1px solid var(--border); overflow:hidden; }
    html.dark .article-body { background:#1a2535; border-color:#1e2d42; }
    .gallery-main { width:100%; height:420px; overflow:hidden; background:var(--blue); }
    .gallery-main img { width:100%; height:100%; object-fit:cover; display:block; }
    .gallery-placeholder { width:100%; height:420px; display:flex; align-items:center; justify-content:center; font-size:80px; }
    .gallery-thumbs { display:flex; gap:8px; padding:12px 24px; background:var(--surface); border-bottom:1px solid var(--border); overflow-x:auto; scrollbar-width:none; }
    html.dark .gallery-thumbs { background:#111d2b; border-color:#1e2d42; }
    .thumb { width:72px; height:52px; border-radius:8px; overflow:hidden; cursor:pointer; border:2px solid transparent; flex-shrink:0; transition:border-color 0.2s; }
    .thumb.active { border-color:var(--accent); }
    .thumb img { width:100%; height:100%; object-fit:cover; display:block; }
    .article-content { padding:36px 40px 40px; }
    .article-content h2 { font-size:20px; font-weight:800; color:var(--text); margin:28px 0 12px; }
    .article-content h3 { font-size:17px; font-weight:700; color:var(--text); margin:22px 0 10px; }
    .article-content p { font-size:15.5px; color:var(--text); line-height:1.85; margin-bottom:18px; }
    .article-content ul, .article-content ol { padding-left:22px; margin-bottom:18px; }
    .article-content li { font-size:15.5px; color:var(--text); line-height:1.85; margin-bottom:6px; }
    .article-content blockquote { border-left:4px solid var(--accent); padding:14px 20px; background:#eff6ff; border-radius:0 10px 10px 0; margin:20px 0; font-style:italic; color:var(--muted); }
    html.dark .article-content blockquote { background:#1e3a5f; }
    .article-footer { display:flex; align-items:center; justify-content:space-between; padding:20px 40px; border-top:1px solid var(--border); flex-wrap:wrap; gap:12px; }
    html.dark .article-footer { border-color:#1e2d42; }
    .source-tag { font-size:12.5px; color:var(--muted); }
    .source-tag strong { color:var(--text); }
    .share-btns { display:flex; align-items:center; gap:8px; }
    .share-label { font-size:12.5px; font-weight:700; color:var(--muted); }
    .share-btn { display:inline-flex; align-items:center; gap:6px; padding:7px 14px; border-radius:8px; font-size:12.5px; font-weight:700; text-decoration:none; transition:all 0.2s; border:none; cursor:pointer; font-family:inherit; }
    .share-btn.copy { background:var(--surface); color:var(--text); border:1px solid var(--border); }
    .share-btn.copy:hover { background:var(--border); }
    html.dark .share-btn.copy { background:#111d2b; border-color:#1e2d42; }
    .share-btn.wa { background:#25d366; color:#fff; }
    .share-btn.wa:hover { background:#1db954; }

    /* ─── Video Section ─── */
    .video-section {
        padding: 0 40px 32px;
        border-bottom: 1px solid var(--border);
    }
    html.dark .video-section { border-color: #1e2d42; }
    .video-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--accent);
        margin-bottom: 14px;
    }
    html.dark .video-label { color: #60a5fa; }
    .video-wrapper {
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* 16:9 */
        border-radius: 14px;
        overflow: hidden;
        background: #000;
        box-shadow: 0 8px 32px rgba(0,0,0,0.18);
    }
    .video-wrapper iframe,
    .video-wrapper video {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        border: none;
    }

    /* ─── Sidebar ─── */
    .sidebar { display:flex; flex-direction:column; gap:20px; }
    .sidebar-card { background:var(--white); border-radius:16px; border:1px solid var(--border); overflow:hidden; }
    html.dark .sidebar-card { background:#1a2535; border-color:#1e2d42; }
    .sidebar-title { font-size:12px; font-weight:800; letter-spacing:1px; text-transform:uppercase; color:var(--accent); padding:18px 20px 12px; border-bottom:1px solid var(--border); }
    html.dark .sidebar-title { border-color:#1e2d42; color:#60a5fa; }
    .related-item { display:flex; gap:12px; padding:14px 20px; text-decoration:none; color:inherit; border-bottom:1px solid var(--border); transition:background 0.2s; }
    .related-item:last-child { border-bottom:none; }
    .related-item:hover { background:var(--surface); }
    html.dark .related-item:hover { background:#111d2b; }
    html.dark .related-item { border-color:#1e2d42; }
    .related-thumb { width:68px; height:52px; border-radius:8px; overflow:hidden; flex-shrink:0; background:var(--blue); display:flex; align-items:center; justify-content:center; font-size:22px; }
    .related-thumb img { width:100%; height:100%; object-fit:cover; display:block; }
    .related-info { flex:1; min-width:0; }
    .related-cat { font-size:10px; font-weight:700; text-transform:uppercase; color:var(--accent); margin-bottom:4px; }
    html.dark .related-cat { color:#60a5fa; }
    .related-title { font-size:13px; font-weight:700; color:var(--text); line-height:1.35; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .related-date { font-size:11px; color:var(--muted); margin-top:4px; }
    .back-btn { display:inline-flex; align-items:center; gap:8px; padding:12px 20px; background:var(--accent); color:#fff; font-size:13.5px; font-weight:700; border-radius:10px; text-decoration:none; transition:all 0.2s; width:100%; justify-content:center; }
    .back-btn:hover { background:#1d4ed8; transform:translateY(-1px); }

    /* ─── Category colours ─── */
    .cat-umum{background:linear-gradient(135deg,#1a3a6e,#2563eb)}.cat-lalu_lintas{background:linear-gradient(135deg,#064e3b,#10b981)}.cat-sosial{background:linear-gradient(135deg,#7f1d1d,#ef4444)}.cat-pelayanan{background:linear-gradient(135deg,#78350f,#f59e0b)}.cat-kriminal{background:linear-gradient(135deg,#1e1b4b,#6366f1)}

    /* ─── Footer ─── */
    footer { background:var(--navy); color:#fff; }
    html.dark footer { background:#060d18; }
    .footer-location { background:#0d1e38; border-bottom:1px solid rgba(255,255,255,0.06); padding:20px 56px; }
    .footer-location-inner { max-width:1100px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; gap:20px; flex-wrap:wrap; }
    .footer-location-left { display:flex; align-items:center; gap:14px; }
    .location-icon-wrap { width:44px; height:44px; background:rgba(37,99,235,0.15); border:1px solid rgba(37,99,235,0.3); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; }
    .location-label { font-size:10.5px; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; color:var(--gold); margin-bottom:3px; }
    .location-address { font-size:13.5px; color:rgba(255,255,255,0.85); font-weight:600; }
    .location-city { font-size:12px; color:rgba(255,255,255,0.4); margin-top:2px; }
    .maps-btn { display:inline-flex; align-items:center; gap:9px; padding:11px 20px; background:var(--accent); color:#fff; font-size:13px; font-weight:700; border-radius:10px; text-decoration:none; transition:all 0.25s; }
    .maps-btn:hover { background:#1d4ed8; }
    .footer-main { padding:52px 56px 32px; }
    .footer-grid { max-width:1100px; margin:0 auto; display:grid; grid-template-columns:2fr 1fr 1fr; gap:48px; padding-bottom:40px; border-bottom:1px solid rgba(255,255,255,0.08); margin-bottom:28px; }
    .footer-brand p { font-size:13.5px; color:rgba(255,255,255,0.45); line-height:1.9; margin-top:14px; max-width:280px; }
    .footer-col h5 { font-size:11px; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; color:var(--gold); margin-bottom:18px; }
    .footer-col a, .footer-col p { display:block; font-size:13.5px; color:rgba(255,255,255,0.5); text-decoration:none; line-height:2.2; transition:color 0.2s; }
    .footer-col a:hover { color:#fff; }
    .footer-bottom { max-width:1100px; margin:0 auto; display:flex; justify-content:space-between; align-items:center; font-size:12.5px; color:rgba(255,255,255,0.3); }

    /* ─── Responsive ─── */
    @media (max-width:900px) { .page-wrap{grid-template-columns:1fr} .hero-title{font-size:26px} .hero-inner{padding:0 28px 32px} .footer-location{padding:18px 28px} .footer-main{padding:44px 28px 28px} .footer-grid{grid-template-columns:1fr 1fr} }
    @media (max-width:640px) { .page-wrap{padding:24px 20px 60px} .article-content{padding:24px 20px 28px} .article-footer{padding:16px 20px} .hero{height:320px} .hero-title{font-size:22px} .gallery-main{height:240px} .footer-grid{grid-template-columns:1fr} .footer-bottom{flex-direction:column;gap:8px;text-align:center} .video-section{padding:0 20px 24px} }
</style>
@endpush

@section('content')

{{-- Weather Bar --}}
<div class="wx-bar">
    <div class="wx-bar-current">
        <div class="wx-bar-icon" id="wxIcon">⏳</div>
        <div class="wx-bar-info">
            <span class="wx-bar-temp" id="wxTemp"><span class="wx-sk" style="width:42px;height:16px;border-radius:4px;display:inline-block;vertical-align:middle;"></span></span>
            <div class="wx-bar-desc" id="wxDesc">Memuat…</div>
            <div class="wx-bar-meta"><span id="wxHum">💧 --</span><span id="wxWnd">💨 --</span></div>
        </div>
    </div>
    <div class="wx-bar-days" id="wxDays">
        @for($i = 0; $i < 7; $i++)
        <div class="wx-bar-day">
            <span class="wx-bar-day-name"><span class="wx-sk" style="width:24px;height:9px;border-radius:3px;display:inline-block;"></span></span>
            <span class="wx-bar-day-icon"><span class="wx-sk" style="width:16px;height:16px;border-radius:50%;display:inline-block;"></span></span>
            <span class="wx-bar-day-temps"><span class="wx-sk" style="width:36px;height:9px;border-radius:3px;display:inline-block;"></span></span>
        </div>
        @endfor
    </div>
    <button class="wx-bar-refresh" id="wxRefresh">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M23 4v6h-6"/><path d="M1 20v-6h6"/>
            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
        </svg>
    </button>
</div>

{{-- Hero --}}
<section class="hero">
    <div class="hero-bg">
        @if(!empty($news['images']) && count($news['images']) > 0)
            <img src="{{ $news['images'][0] }}" alt="{{ $news['title'] }}">
        @elseif(!empty($news['icon']))
            <img src="{{ $news['icon'] }}" alt="{{ $news['title'] }}">
        @else
            <img src="{{ asset('images/slideshow/news.jpg') }}" alt="Tribratanews">
        @endif
    </div>
    <div class="hero-inner">
        <div class="hero-breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">›</span>
            <a href="{{ route('news') }}">Tribratanews</a>
            <span class="sep">›</span>
            <span>{{ Str::limit($news['title'], 40) }}</span>
        </div>
        <div class="hero-badge">
            <span class="cat-badge">{{ match($news['category']) {
                'lalu_lintas' => '🚦 Lalu Lintas',
                'pelayanan'   => '🆔 Pelayanan',
                'sosial'      => '🤝 Sosial',
                'kriminal'    => '🔒 Kriminal',
                default       => '📰 Umum'
            } }}</span>
        </div>
        <h1 class="hero-title">{{ $news['title'] }}</h1>
        <div class="hero-meta">
            <span class="meta-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ $news['date'] }}
            </span>
            <span class="meta-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                {{ $news['source'] }}
            </span>
        </div>
    </div>
</section>

{{-- Main Content --}}
<div class="page-wrap">
    <article class="article-body">

        {{-- Gallery --}}
        @if(!empty($news['images']) && count($news['images']) > 0)
        <div class="gallery">
            <div class="gallery-main">
                <img src="{{ $news['images'][0] }}" alt="{{ $news['title'] }}" id="mainImg">
            </div>
            @if(count($news['images']) > 1)
            <div class="gallery-thumbs">
                @foreach($news['images'] as $i => $img)
                <div class="thumb {{ $i === 0 ? 'active' : '' }}" onclick="switchImg('{{ $img }}', this)">
                    <img src="{{ $img }}" alt="Foto {{ $i + 1 }}">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        @elseif(!empty($news['icon']))
        <div class="gallery-main">
            <img src="{{ $news['icon'] }}" alt="{{ $news['title'] }}"
                 onerror="this.parentElement.classList.add('cat-{{ $news['category'] }}'); this.style.display='none';">
        </div>

        @else
        <div class="gallery-placeholder cat-{{ $news['category'] }}">📰</div>
        @endif

        {{-- ═══════════════════════════════════════════════
             VIDEO SECTION
             Prioritas: file upload dulu, kalau tidak ada
             baru cek URL YouTube / TikTok
        ════════════════════════════════════════════════ --}}
        @if(!empty($news['video_path']))
        <div class="video-section">
            <div class="video-label">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                Video Berita
            </div>
            <div class="video-wrapper">
                <video controls preload="metadata">
                    <source src="{{ asset('storage/' . $news['video_path']) }}" type="video/mp4">
                    Browser Anda tidak mendukung pemutaran video.
                </video>
            </div>
        </div>

        @elseif(!empty($news['video_embed_url']))
        <div class="video-section">
            <div class="video-label">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                Video Berita
            </div>
            <div class="video-wrapper">
                <iframe
                    src="{{ $news['video_embed_url'] }}"
                    allowfullscreen
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    loading="lazy">
                </iframe>
            </div>
        </div>
        @endif
        {{-- ═══════════════════════════════════════════════ --}}

        <div class="article-content">
            <p><strong>{{ $news['excerpt'] }}</strong></p>
            <div>{!! $news['content'] !!}</div>
        </div>

        <div class="article-footer">
            <span class="source-tag">Sumber: <strong>{{ $news['source'] }}</strong></span>
        </div>
    </article>

    <aside class="sidebar">
        <a href="{{ route('news') }}" class="back-btn">← Kembali ke Tribratanews</a>

        @if(count($related) > 0)
        <div class="sidebar-card">
            <div class="sidebar-title">Berita Terkait</div>
            @foreach($related as $item)
            <a href="{{ route('news.show', $item['slug']) }}" class="related-item">
                <div class="related-thumb">
                    @if(!empty($item['images']) && count($item['images']) > 0)
                        <img src="{{ $item['images'][0] }}" alt="{{ $item['title'] }}">
                    @elseif(!empty($item['icon']))
                        <img src="{{ $item['icon'] }}" alt="{{ $item['title'] }}"
                             onerror="this.style.display='none'; this.parentElement.textContent='📰';">
                    @else
                        📰
                    @endif
                </div>
                <div class="related-info">
                    <div class="related-cat">{{ match($item['category']) {
                        'lalu_lintas' => 'Lalu Lintas',
                        'pelayanan'   => 'Pelayanan',
                        'sosial'      => 'Sosial',
                        'kriminal'    => 'Kriminal',
                        default       => 'Umum'
                    } }}</div>
                    <div class="related-title">{{ $item['title'] }}</div>
                    <div class="related-date">{{ $item['date'] }}</div>
                </div>
            </a>
            @endforeach
        </div>
        @endif

        <div class="sidebar-card">
            <div class="sidebar-title">Info Kontak</div>
            <div style="padding:16px 20px;display:flex;flex-direction:column;gap:10px;">
                <div style="font-size:13px;color:var(--muted);display:flex;gap:8px;">📞 <span><strong style="color:var(--text);display:block;">Hotline</strong>0851-3375-0875</span></div>
                <div style="font-size:13px;color:var(--muted);display:flex;gap:8px;">🚨 <span><strong style="color:var(--text);display:block;">Darurat</strong>110</span></div>
                <div style="font-size:13px;color:var(--muted);display:flex;gap:8px;">📧 <span><strong style="color:var(--text);display:block;">Email</strong>ppidgunungkidul@gmail.com</span></div>
                <div style="font-size:13px;color:var(--muted);display:flex;gap:8px;">🕐 <span><strong style="color:var(--text);display:block;">Jam Pelayanan</strong>24 Jam</span></div>
            </div>
        </div>
    </aside>
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
// GALLERY
function switchImg(src, thumb) {
    document.getElementById('mainImg').src = src;
    document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');
}

// CUACA
(function () {
    const LAT = -7.9408, LON = 110.5993, TZ = 'Asia%2FJakarta';
    const WMO = {
        0:{e:'☀️',d:'Cerah'},1:{e:'🌤️',d:'Umumnya Cerah'},2:{e:'⛅',d:'Berawan Sebagian'},
        3:{e:'☁️',d:'Berawan'},45:{e:'🌫️',d:'Berkabut'},61:{e:'🌧️',d:'Hujan Ringan'},
        63:{e:'🌧️',d:'Hujan Sedang'},65:{e:'🌧️',d:'Hujan Lebat'},
        80:{e:'🌦️',d:'Hujan Lokal'},95:{e:'⛈️',d:'Hujan Petir'}
    };
    const HARI = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];
    function wmo(c) { return WMO[c] || {e:'🌡️',d:'—'}; }
    const API = 'https://api.open-meteo.com/v1/forecast?latitude='+LAT+'&longitude='+LON
        +'&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m'
        +'&daily=weather_code,temperature_2m_max,temperature_2m_min&timezone='+TZ+'&forecast_days=7';

    async function load() {
        try {
            const r = await fetch(API), d = await r.json(), c = d.current, dl = d.daily, w = wmo(c.weather_code);
            document.getElementById('wxIcon').textContent = w.e;
            document.getElementById('wxTemp').textContent = Math.round(c.temperature_2m) + '°C';
            document.getElementById('wxDesc').textContent = w.d;
            document.getElementById('wxHum').textContent  = '💧 ' + c.relative_humidity_2m + '%';
            document.getElementById('wxWnd').textContent  = '💨 ' + Math.round(c.wind_speed_10m) + ' km/h';
            const $days = document.getElementById('wxDays'); $days.innerHTML = '';
            dl.time.forEach((dt, i) => {
                const today = i === 0, day = new Date(dt + 'T00:00:00'), dw = wmo(dl.weather_code[i]);
                const p = document.createElement('div');
                p.className = 'wx-bar-day' + (today ? ' wx-today-pill' : '');
                p.innerHTML = '<span class="wx-bar-day-name">' + (today ? 'Hari ini' : HARI[day.getDay()]) + '</span>'
                    + '<span class="wx-bar-day-icon">' + dw.e + '</span>'
                    + '<span class="wx-bar-day-temps">' + Math.round(dl.temperature_2m_max[i])
                    + '° <span class="wx-bar-day-lo">/ ' + Math.round(dl.temperature_2m_min[i]) + '°</span></span>';
                $days.appendChild(p);
            });
        } catch(e) {}
    }
    document.getElementById('wxRefresh').addEventListener('click', load);
    load();
})();
</script>
@endpush