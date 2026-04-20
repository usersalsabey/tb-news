@extends('layouts.app')

@section('title', 'Tribratanews - Polres Gunungkidul')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    :root { --navy:#0a1628;--blue:#1a3a6e;--accent:#2563eb;--gold:#f0a500;--gold-lt:#fbbf24;--surface:#f4f6fa;--white:#ffffff;--text:#1a1f2e;--muted:#6b7280;--border:#e2e8f0; }
    html.dark { --surface: #0f1923; --white: #1a2535; --text: #e2e8f0; --muted: #94a3b8; --border: #1e2d42; }
    body, .news-card, .news-list-item, .filter-tab, .view-toggle, .page-btn, .result-count, .card-title, .card-excerpt, .list-title, .list-excerpt {
        transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
    }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--surface); color: var(--text); overflow-x: hidden; }

    /* ─── Weather Bar ─── */
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

    /* ─── Hero ─── */
    .hero { position:relative; overflow:hidden; height:480px; }
    .hero-bg { position:absolute; inset:0; }
    .hero-bg img { width:100%; height:100%; object-fit:cover; display:block; }
    .hero-bg::after { content:''; position:absolute; inset:0; background:linear-gradient(to bottom, rgba(10,22,40,0.35) 0%, rgba(10,22,40,0.72) 100%); }
    .hero-inner { position:absolute; inset:0; z-index:2; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding:0 56px; }
    .hero-tag { display:inline-flex; align-items:center; gap:8px; background:rgba(240,165,0,0.18); border:1px solid rgba(240,165,0,0.4); color:var(--gold-lt); font-size:11px; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; padding:6px 16px; border-radius:100px; margin-bottom:20px; }
    .hero-tag::before { content:'\25cf'; font-size:8px; }
    .hero h1 { font-family:'DM Serif Display',serif; font-size:56px; color:#fff; line-height:1.1; margin-bottom:14px; letter-spacing:-0.5px; text-shadow:0 4px 24px rgba(0,0,0,0.4); }
    .hero h1 em { font-style:italic; color:var(--gold-lt); }
    .hero-desc { font-size:15px; color:rgba(255,255,255,0.75); line-height:1.8; max-width:520px; }
    .hero-breadcrumb { display:flex; align-items:center; gap:8px; margin-top:16px; font-size:12.5px; color:rgba(255,255,255,0.5); }
    .hero-breadcrumb a { color:rgba(255,255,255,0.65); text-decoration:none; transition:color 0.2s; }
    .hero-breadcrumb a:hover { color:var(--gold-lt); }
    .hero-breadcrumb span.sep { opacity:0.4; }
    .search-wrap { margin-top:28px; display:flex; gap:10px; max-width:560px; width:100%; }
    .search-input-wrap { flex:1; position:relative; }
    .search-icon { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:rgba(255,255,255,0.35); font-size:16px; pointer-events:none; line-height:1; display:flex; align-items:center; }
    .search-input { width:100%; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); color:#fff; font-family:inherit; font-size:14px; padding:12px 16px 12px 42px; border-radius:10px; outline:none; transition:all 0.2s; backdrop-filter:blur(8px); }
    .search-input::placeholder { color:rgba(255,255,255,0.4); }
    .search-input:focus { border-color:var(--gold); background:rgba(255,255,255,0.16); }
    .search-btn { padding:12px 22px; background:var(--accent); color:#fff; border:none; border-radius:10px; font-family:inherit; font-size:13.5px; font-weight:700; cursor:pointer; transition:all 0.2s; white-space:nowrap; }
    .search-btn:hover { background:#1d4ed8; transform:translateY(-1px); box-shadow:0 8px 24px rgba(37,99,235,0.4); }

    /* ─── Main / Toolbar ─── */
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

    /* ─── Cards ─── */
    .news-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
    .news-list { display:flex; flex-direction:column; gap:14px; }
    .news-card { background:var(--white); border-radius:18px; border:1px solid var(--border); overflow:hidden; display:flex; flex-direction:column; text-decoration:none; color:inherit; transition:transform 0.25s,box-shadow 0.25s,border-color 0.25s,background-color 0.3s; }
    .news-card:hover { transform:translateY(-5px); box-shadow:0 18px 44px rgba(10,22,40,0.11); border-color:transparent; }
    html.dark .news-card { background:#1a2535; border-color:#1e2d42; }
    html.dark .news-card:hover { box-shadow:0 18px 44px rgba(0,0,0,0.4); border-color:#2d3e55; }
    .card-image { width:100%; height:200px; overflow:hidden; position:relative; flex-shrink:0; display:flex; align-items:center; justify-content:center; }
    .card-image img { width:100%; height:100%; object-fit:cover; display:block; transition:transform 0.4s; }
    .news-card:hover .card-image img { transform:scale(1.05); }
    .card-image-placeholder { width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:52px; }
    .cat-umum { background:linear-gradient(135deg,#1a3a6e,#2563eb); }
    .cat-lalu_lintas { background:linear-gradient(135deg,#064e3b,#10b981); }
    .cat-sosial { background:linear-gradient(135deg,#7f1d1d,#ef4444); }
    .cat-pelayanan { background:linear-gradient(135deg,#78350f,#f59e0b); }
    .cat-kriminal { background:linear-gradient(135deg,#1e1b4b,#6366f1); }
    .card-cat-badge { position:absolute; top:12px; left:12px; font-size:10.5px; font-weight:700; letter-spacing:1px; text-transform:uppercase; padding:4px 10px; border-radius:100px; color:#fff; background:rgba(0,0,0,0.35); backdrop-filter:blur(4px); }
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
    .list-image { width:200px; min-height:140px; flex-shrink:0; overflow:hidden; position:relative; display:flex; align-items:center; justify-content:center; }
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

    /* ─── Empty / Pagination ─── */
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
    .page-dots { color:var(--muted); padding:0 4px; font-size:14px; }
    html.dark .page-btn { background:#1a2535; border-color:#1e2d42; color:#e2e8f0; }
    html.dark .page-btn:hover:not(:disabled):not(.active) { border-color:#60a5fa; color:#60a5fa; }

    /* ─── Responsive ─── */
    @media (max-width:900px) { .news-grid{grid-template-columns:repeat(2,1fr)} .main-wrap{padding:32px 24px 64px} .hero{height:400px} .hero h1{font-size:38px} .hero-inner{padding:0 32px} }
    @media (max-width:768px) { .wx-bar{padding:0 20px} .wx-bar-current{padding-right:12px} .wx-bar-desc{display:none} }
    @media (max-width:640px) { .news-grid{grid-template-columns:1fr} .list-image{width:120px} .list-title{font-size:15px} .toolbar{flex-direction:column;align-items:flex-start} .hero{height:320px} .hero h1{font-size:28px} .hero-inner{padding:0 20px} .search-wrap{flex-direction:column} }
    @media (max-width:480px) { .wx-bar-meta{display:none} }
</style>
@endpush

@section('content')

{{-- Weather Bar --}}
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
        <div class="wx-bar-day">
            <span class="wx-bar-day-name"><span class="wx-sk" style="width:24px;height:9px;border-radius:3px;display:inline-block;"></span></span>
            <span class="wx-bar-day-icon"><span class="wx-sk" style="width:16px;height:16px;border-radius:50%;display:inline-block;"></span></span>
            <span class="wx-bar-day-temps"><span class="wx-sk" style="width:36px;height:9px;border-radius:3px;display:inline-block;"></span></span>
        </div>
        @endfor
    </div>
    <button class="wx-bar-refresh" id="wxRefresh" title="Refresh cuaca">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M23 4v6h-6"/><path d="M1 20v-6h6"/>
            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
        </svg>
    </button>
</div>

{{-- Hero --}}
<section class="hero">
    <div class="hero-bg">
        @if($heroSlides->isNotEmpty())
            <img src="{{ Storage::disk('public')->url($heroSlides->first()->foto) }}" alt="{{ $heroSlides->first()->caption ?? 'Tribratanews' }}">
        @else
            <img src="{{ asset('images/slideshow/news.jpg') }}" alt="Tribratanews">
        @endif
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
{{-- ✅ TIDAK ADA <footer> di sini — sudah di-handle global dari app.blade.php --}}

@endsection

@push('scripts')
<script>
const ALL_NEWS = @json($news);
let currentView = 'grid', currentCategory = 'semua', currentSearch = '', currentPage = 1;
const PER_PAGE = 6;

function getFiltered() {
    return ALL_NEWS.filter(i =>
        (currentCategory === 'semua' || i.category === currentCategory) &&
        (!currentSearch || i.title.toLowerCase().includes(currentSearch.toLowerCase()) ||
         i.excerpt.toLowerCase().includes(currentSearch.toLowerCase()))
    );
}
function getPaginated(f) { const s = (currentPage - 1) * PER_PAGE; return f.slice(s, s + PER_PAGE); }
function catLabel(c) { return { umum:'Umum', lalu_lintas:'Lalu Lintas', sosial:'Sosial', pelayanan:'Pelayanan', kriminal:'Kriminal' }[c] || c; }
function catBg(c)    { return { umum:'cat-umum', lalu_lintas:'cat-lalu_lintas', sosial:'cat-sosial', pelayanan:'cat-pelayanan', kriminal:'cat-kriminal' }[c] || 'cat-umum'; }

function getImageSrc(item) {
    if (item.images && item.images.length > 0) return item.images[0];
    if (item.icon) return item.icon;
    return null;
}

function imageOrPlaceholder(item, placeholderClass) {
    const src = getImageSrc(item);
    if (src) {
        return `<img src="${src}" alt="${item.title.replace(/"/g, '&quot;')}"
            style="width:100%;height:100%;object-fit:cover;display:block;"
            onerror="this.style.display='none';this.parentElement.classList.add('${catBg(item.category)}');this.parentElement.innerHTML='<div class=\\'${placeholderClass} ${catBg(item.category)}\\'>📰</div>';">`;
    }
    return `<div class="${placeholderClass} ${catBg(item.category)}">📰</div>`;
}

function renderCard(item) {
    const hasSrc = !!getImageSrc(item);
    return `<a href="/news/${item.slug}" class="news-card">
        <div class="card-image${!hasSrc ? ' ' + catBg(item.category) : ''}">
            ${imageOrPlaceholder(item, 'card-image-placeholder')}
            <span class="card-cat-badge">${catLabel(item.category)}</span>
        </div>
        <div class="card-body">
            <span class="card-date">${item.date}</span>
            <div class="card-title">${item.title}</div>
            <p class="card-excerpt">${item.excerpt}</p>
            <span class="card-readmore">Selengkapnya →</span>
        </div>
    </a>`;
}

function renderListItem(item) {
    const hasSrc = !!getImageSrc(item);
    return `<a href="/news/${item.slug}" class="news-list-item">
        <div class="list-image${!hasSrc ? ' ' + catBg(item.category) : ''}">
            ${imageOrPlaceholder(item, 'list-image-placeholder')}
        </div>
        <div class="list-body">
            <div class="list-meta">
                <span class="list-date">${item.date}</span>
                <span class="list-cat">${catLabel(item.category)}</span>
            </div>
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
    let h = `<button class="page-btn arrow" onclick="goPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>&#8249;</button>`;
    for (let i = 1; i <= t; i++) {
        if (i === 1 || i === t || (i >= currentPage - 1 && i <= currentPage + 1))
            h += `<button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="goPage(${i})">${i}</button>`;
        else if (i === currentPage - 2 || i === currentPage + 2)
            h += '<span class="page-dots">…</span>';
    }
    h += `<button class="page-btn arrow" onclick="goPage(${currentPage + 1})" ${currentPage === t ? 'disabled' : ''}>&#8250;</button>`;
    w.innerHTML = h;
}

function goPage(p) {
    const f = getFiltered(), t = Math.ceil(f.length / PER_PAGE);
    if (p < 1 || p > t) return;
    currentPage = p; render(); window.scrollTo({ top: 0, behavior: 'smooth' });
}

document.querySelectorAll('.filter-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active'); currentCategory = tab.dataset.cat; currentPage = 1; render();
    });
});

function applySearch() {
    currentSearch = document.getElementById('searchInput').value.trim(); currentPage = 1; render();
}
document.getElementById('searchInput').addEventListener('keydown', e => { if (e.key === 'Enter') applySearch(); });

function setView(mode) {
    currentView = mode;
    document.getElementById('btnGrid').classList.toggle('active', mode === 'grid');
    document.getElementById('btnList').classList.toggle('active', mode === 'list');
    render();
}

render();

(function () {
    const LAT = -7.9408, LON = 110.5993, TZ = 'Asia%2FJakarta';
    const WMO = {
        0:{e:'☀️',d:'Cerah'},1:{e:'🌤️',d:'Umumnya Cerah'},2:{e:'⛅',d:'Berawan Sebagian'},
        3:{e:'☁️',d:'Berawan'},45:{e:'🌫️',d:'Berkabut'},51:{e:'🌦️',d:'Gerimis Ringan'},
        53:{e:'🌦️',d:'Gerimis Sedang'},55:{e:'🌧️',d:'Gerimis Lebat'},61:{e:'🌧️',d:'Hujan Ringan'},
        63:{e:'🌧️',d:'Hujan Sedang'},65:{e:'🌧️',d:'Hujan Lebat'},80:{e:'🌦️',d:'Hujan Lokal'},
        81:{e:'🌧️',d:'Hujan Lokal Sedang'},82:{e:'⛈️',d:'Hujan Lokal Lebat'},
        95:{e:'⛈️',d:'Hujan Petir'},96:{e:'⛈️',d:'Petir + Es'},99:{e:'⛈️',d:'Petir + Es Besar'}
    };
    const HARI = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];
    function wmo(c) { return WMO[c] || {e:'🌡️',d:'—'}; }
    const API = 'https://api.open-meteo.com/v1/forecast?latitude='+LAT+'&longitude='+LON
        +'&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m,precipitation'
        +'&daily=weather_code,temperature_2m_max,temperature_2m_min,precipitation_probability_max'
        +'&timezone='+TZ+'&forecast_days=7';
    const $i = id => document.getElementById(id);
    async function load() {
        $i('wxRefresh').classList.add('spinning');
        try {
            const r = await fetch(API); if (!r.ok) throw new Error(r.status);
            const d = await r.json(), c = d.current, dl = d.daily, w = wmo(c.weather_code);
            $i('wxIcon').textContent  = w.e;
            $i('wxTemp').textContent  = Math.round(c.temperature_2m) + '°C';
            $i('wxDesc').textContent  = w.d;
            $i('wxHum').textContent   = '💧 ' + c.relative_humidity_2m + '%';
            $i('wxWnd').textContent   = '💨 ' + Math.round(c.wind_speed_10m) + ' km/h';
            $i('wxPrcp').textContent  = '☔ ' + c.precipitation + ' mm';
            const days = $i('wxDays'); days.innerHTML = '';
            dl.time.forEach((dt, i) => {
                const today = i === 0, day = new Date(dt + 'T00:00:00'), dw = wmo(dl.weather_code[i]);
                const p = document.createElement('div');
                p.className = 'wx-bar-day' + (today ? ' wx-today-pill' : '');
                p.title = dw.d + ' · Hujan: ' + (dl.precipitation_probability_max[i] ?? 0) + '%';
                p.innerHTML = '<span class="wx-bar-day-name">' + (today ? 'Hari ini' : HARI[day.getDay()]) + '</span>'
                    + '<span class="wx-bar-day-icon">' + dw.e + '</span>'
                    + '<span class="wx-bar-day-temps">' + Math.round(dl.temperature_2m_max[i])
                    + '° <span class="wx-bar-day-lo">/ ' + Math.round(dl.temperature_2m_min[i]) + '°</span></span>';
                days.appendChild(p);
            });
        } catch(e) {
            $i('wxIcon').textContent = '⚠️'; $i('wxTemp').textContent = '--'; $i('wxDesc').textContent = 'Gagal memuat';
        } finally {
            $i('wxRefresh').classList.remove('spinning');
        }
    }
    $i('wxRefresh').addEventListener('click', load);
    load();
    setInterval(load, 10 * 60 * 1000);
})();
</script>
@endpush