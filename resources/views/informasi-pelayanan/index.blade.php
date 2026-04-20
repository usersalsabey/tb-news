@extends('layouts.app')

@section('title', 'Informasi Pelayanan - Polres Gunungkidul')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    :root { --navy:#0a1628;--blue:#1a3a6e;--mid:#1e4da1;--accent:#2563eb;--gold:#f0a500;--gold-lt:#fbbf24;--surface:#f4f6fa;--white:#ffffff;--text:#1a1f2e;--muted:#6b7280;--border:#e2e8f0;--radius:16px; }
    html.dark { --surface: #0f1923; --white: #1a2535; --text: #e2e8f0; --muted: #94a3b8; --border: #1e2d42; }
    body, .card, .notice, .ext-badge, .card-title, .card-desc {
        transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
    }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--surface); color: var(--text); overflow-x: hidden; }
    html.dark body { background: var(--surface); color: var(--text); }
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
    @media (max-width:900px) { .grid{grid-template-columns:1fr} .hero{height:400px} .hero h1{font-size:38px} .hero-inner{padding:0 32px} .main-wrap{padding:36px 24px 72px} }
    @media (max-width:768px) { .wx-bar{padding:0 20px} .wx-bar-current{padding-right:12px} .wx-bar-desc{display:none} }
    @media (max-width:560px) { .hero{height:320px} .hero h1{font-size:28px} .hero-inner{padding:0 20px} }
    @media (max-width:480px) { .wx-bar-meta{display:none} }
</style>
@endpush

@section('content')

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
        @if($heroSlides->isNotEmpty())
            <img src="{{ Storage::disk('public')->url($heroSlides->first()->foto) }}" alt="{{ $heroSlides->first()->caption ?? 'Informasi Pelayanan' }}">
        @else
            <img src="{{ asset('images/slideshow/pelayanan.jpg') }}" alt="Informasi Pelayanan">
        @endif
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
        @forelse($pelayananItems as $item)
        @php
            $warna = $item->warna ?? 'blue';
            $bandMap  = ['blue'=>'band-blue','green'=>'band-green','red'=>'band-red','yellow'=>'band-amber','teal'=>'band-green','purple'=>''];
            $chipMap  = ['blue'=>'chip-blue','green'=>'chip-green','red'=>'chip-red','yellow'=>'chip-amber','teal'=>'chip-green','purple'=>''];
            $checkMap = ['blue'=>'check-blue','green'=>'check-green','red'=>'check-red','yellow'=>'check-amber','teal'=>'check-green','purple'=>''];
            $gradMap  = ['purple'=>'background:linear-gradient(90deg,#4c1d95,#7c3aed)','teal'=>'background:linear-gradient(90deg,#065f46,#10b981)'];
            $chipStyleMap  = ['purple'=>'background:#f5f3ff;color:#7c3aed','teal'=>'background:#ecfdf5;color:#059669'];
            $checkStyleMap = ['purple'=>'background:#7c3aed','teal'=>'background:#059669'];
            $bandClass  = $bandMap[$warna]  ?? '';
            $bandStyle  = $gradMap[$warna]  ?? '';
            $chipClass  = $chipMap[$warna]  ?? 'chip-blue';
            $chipStyle  = $chipStyleMap[$warna]  ?? '';
            $checkClass = $checkMap[$warna] ?? 'check-blue';
            $checkStyle = $checkStyleMap[$warna] ?? '';
            $fitur = is_array($item->fitur) ? $item->fitur : (json_decode($item->fitur, true) ?? []);
            $links = is_array($item->links) ? $item->links : (json_decode($item->links, true) ?? []);
        @endphp
        <div class="card">
            <div class="card-band {{ $bandClass }}" @if($bandStyle) style="{{ $bandStyle }}" @endif></div>
            <div class="card-inner">
                <div class="card-meta">
                    <span class="card-chip {{ $chipClass }}" @if($chipStyle) style="{{ $chipStyle }}" @endif>{{ $item->kategori }}</span>
                </div>
                <div class="card-title">{{ $item->judul }}</div>
                <p class="card-desc">{{ $item->deskripsi }}</p>
                @if(!empty($fitur))
                <ul class="card-list">
                    @foreach($fitur as $f)
                    <li>
                        <span class="check {{ $checkClass }}" @if($checkStyle) style="{{ $checkStyle }}" @endif>✓</span>
                        {{ is_array($f) ? ($f['item'] ?? '') : $f }}
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
            @if(!empty($links))
            <div class="ext-links">
                @if($item->link_label)
                <span class="ext-links-label">{{ $item->link_label }}</span>
                @endif
                @foreach($links as $link)
                <a href="{{ $link['url'] ?? '#' }}" target="_blank" rel="noopener" class="ext-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    {{ $link['label'] ?? 'Buka Link' }}
                </a>
                @endforeach
            </div>
            @endif
        </div>
        @empty
        <div style="grid-column:1/-1;text-align:center;padding:60px 0;color:var(--muted);">
            <p style="font-size:15px;">Belum ada data pelayanan. Tambahkan melalui panel admin.</p>
        </div>
        @endforelse
    </div>
</div>
{{-- ✅ TIDAK ADA <footer> di sini — sudah di-handle global dari app.blade.php --}}

@endsection

@push('scripts')
<script>
(function () {
    const LAT=-7.9408,LON=110.5993,TZ='Asia%2FJakarta';
    const WMO={0:{e:'☀️',d:'Cerah'},1:{e:'🌤️',d:'Umumnya Cerah'},2:{e:'⛅',d:'Berawan Sebagian'},3:{e:'☁️',d:'Berawan'},45:{e:'🌫️',d:'Berkabut'},51:{e:'🌦️',d:'Gerimis Ringan'},53:{e:'🌦️',d:'Gerimis Sedang'},55:{e:'🌧️',d:'Gerimis Lebat'},61:{e:'🌧️',d:'Hujan Ringan'},63:{e:'🌧️',d:'Hujan Sedang'},65:{e:'🌧️',d:'Hujan Lebat'},80:{e:'🌦️',d:'Hujan Lokal'},81:{e:'🌧️',d:'Hujan Lokal Sedang'},82:{e:'⛈️',d:'Hujan Lokal Lebat'},95:{e:'⛈️',d:'Hujan Petir'},96:{e:'⛈️',d:'Petir + Es'},99:{e:'⛈️',d:'Petir + Es Besar'}};
    const HARI=['Min','Sen','Sel','Rab','Kam','Jum','Sab'];
    function wmo(c){return WMO[c]||{e:'🌡️',d:'—'};}
    const API='https://api.open-meteo.com/v1/forecast?latitude='+LAT+'&longitude='+LON+'&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m,precipitation&daily=weather_code,temperature_2m_max,temperature_2m_min,precipitation_probability_max&timezone='+TZ+'&forecast_days=7';
    const $i=id=>document.getElementById(id);
    async function load(){
        $i('wxRefresh').classList.add('spinning');
        try{
            const r=await fetch(API);if(!r.ok)throw new Error(r.status);
            const d=await r.json(),c=d.current,dl=d.daily,w=wmo(c.weather_code);
            $i('wxIcon').textContent=w.e;$i('wxTemp').textContent=Math.round(c.temperature_2m)+'°C';$i('wxDesc').textContent=w.d;
            $i('wxHum').textContent='💧 '+c.relative_humidity_2m+'%';$i('wxWnd').textContent='💨 '+Math.round(c.wind_speed_10m)+' km/h';$i('wxPrcp').textContent='☔ '+c.precipitation+' mm';
            const days=$i('wxDays');days.innerHTML='';
            dl.time.forEach((dt,i)=>{
                const today=i===0,day=new Date(dt+'T00:00:00'),dw=wmo(dl.weather_code[i]);
                const p=document.createElement('div');
                p.className='wx-bar-day'+(today?' wx-today-pill':'');
                p.title=dw.d+' · Hujan: '+(dl.precipitation_probability_max[i]??0)+'%';
                p.innerHTML='<span class="wx-bar-day-name">'+(today?'Hari ini':HARI[day.getDay()])+'</span><span class="wx-bar-day-icon">'+dw.e+'</span><span class="wx-bar-day-temps">'+Math.round(dl.temperature_2m_max[i])+'° <span class="wx-bar-day-lo">/ '+Math.round(dl.temperature_2m_min[i])+'°</span></span>';
                days.appendChild(p);
            });
        }catch(e){$i('wxIcon').textContent='⚠️';$i('wxTemp').textContent='--';$i('wxDesc').textContent='Gagal memuat';}
        finally{$i('wxRefresh').classList.remove('spinning');}
    }
    $i('wxRefresh').addEventListener('click',load);load();setInterval(load,10*60*1000);
})();
</script>
@endpush