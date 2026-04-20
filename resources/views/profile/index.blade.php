@extends('layouts.app')

@section('title', 'Profil - Polres Gunungkidul')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
<style>
:root { --navy:#0a1628;--blue:#1a3a6e;--accent:#2563eb;--gold:#f0a500;--gold-lt:#fbbf24;--surface:#f4f6fa;--white:#ffffff;--text:#1a1f2e;--muted:#6b7280;--border:#e2e8f0;--radius:16px; }
*,*::before,*::after { margin:0; padding:0; box-sizing:border-box; }
html.dark { --surface: #0f1923; --white: #1a2535; --text: #e2e8f0; --muted: #94a3b8; --border: #1e2d42; }
body, .card, .vm-box, .notice, .card-title, .sambutan-text p, .mission-list li, .kapolres-name, .kapolres-title {
    transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
}
body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--surface); color:var(--text); overflow-x:hidden; }
html.dark body { background: var(--surface); color: var(--text); }
.hero { position:relative; overflow:hidden; height:480px; }
.hero-bg { position:absolute; inset:0; }
.hero-bg img { width:100%; height:100%; object-fit:cover; display:block; }
.hero-bg::after { content:''; position:absolute; inset:0; background:linear-gradient(to bottom, rgba(10,22,40,0.35) 0%, rgba(10,22,40,0.65) 100%); }
.hero-inner { position:absolute; inset:0; z-index:2; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding:0 56px; }
.hero-tag { display:inline-flex; align-items:center; gap:8px; background:rgba(240,165,0,0.18); border:1px solid rgba(240,165,0,0.4); color:var(--gold-lt); font-size:11px; font-weight:700; letter-spacing:1.2px; text-transform:uppercase; padding:6px 16px; border-radius:100px; margin-bottom:20px; }
.hero-tag::before { content:'\25cf'; font-size:8px; }
.hero h1 { font-family:'DM Serif Display',serif; font-size:56px; color:var(--white); line-height:1.1; margin-bottom:14px; letter-spacing:-0.5px; text-shadow:0 4px 24px rgba(0,0,0,0.4); }
.hero h1 em { font-style:italic; color:var(--gold-lt); }
.hero-desc { font-size:15px; color:rgba(255,255,255,0.75); line-height:1.8; max-width:520px; }
.hero-breadcrumb { display:flex; align-items:center; gap:8px; margin-top:24px; font-size:12.5px; color:rgba(255,255,255,0.5); }
.hero-breadcrumb a { color:rgba(255,255,255,0.65); text-decoration:none; transition:color 0.2s; }
.hero-breadcrumb a:hover { color:var(--gold-lt); }
.hero-breadcrumb span.sep { opacity:0.4; }
.main { max-width:1100px; margin:0 auto; padding:52px 40px 80px; }
.card { background:var(--white); border-radius:20px; border:1px solid var(--border); padding:40px; margin-bottom:24px; }
html.dark .card { background:#1a2535; border-color:#1e2d42; }
.card-title { font-size:22px; font-weight:800; color:var(--text); margin-bottom:20px; display:flex; align-items:center; gap:12px; }
.card-title-icon { width:40px; height:40px; border-radius:12px; background:#dbeafe; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
html.dark .card-title-icon { background:#1e3a5f; }
.sambutan-grid { display:grid; grid-template-columns:220px 1fr; gap:40px; align-items:flex-start; }
.kapolres-wrap { text-align:center; }
.kapolres-img { width:100%; border-radius:16px; box-shadow:0 12px 32px rgba(10,22,40,0.15); margin-bottom:14px; }
html.dark .kapolres-img { box-shadow:0 12px 32px rgba(0,0,0,0.4); }
.kapolres-name { font-size:15px; font-weight:800; color:var(--text); line-height:1.3; margin-bottom:4px; }
.kapolres-title { font-size:12px; color:var(--muted); font-weight:500; letter-spacing:0.5px; }
.sambutan-text { font-size:14.5px; line-height:1.9; color:#4b5563; }
html.dark .sambutan-text { color:#94a3b8; }
.sambutan-text p { margin-bottom:14px; }
.sambutan-text p:last-child { margin-bottom:0; }
.vm-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
.vm-box { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:28px 24px; position:relative; overflow:hidden; transition:background-color 0.3s ease, border-color 0.3s ease; }
html.dark .vm-box { background:#0f1923; border-color:#1e2d42; }
.vm-box::before { content:''; position:absolute; top:0; left:0; width:4px; height:100%; background:linear-gradient(180deg,var(--accent),var(--gold)); }
.vm-box h4 { font-size:16px; font-weight:800; color:var(--text); margin-bottom:14px; display:flex; align-items:center; gap:8px; }
.vm-box p { font-size:13.5px; line-height:1.85; color:var(--muted); }
.mission-list { list-style:none; display:flex; flex-direction:column; gap:10px; }
.mission-list li { display:flex; align-items:flex-start; gap:10px; font-size:13px; color:#4b5563; line-height:1.65; }
html.dark .mission-list li { color:#94a3b8; }
.mission-list li::before { content:'\2713'; width:17px; height:17px; border-radius:50%; background:var(--accent); color:var(--white); font-size:9px; font-weight:900; flex-shrink:0; display:flex; align-items:center; justify-content:center; margin-top:2px; }
.struktur-img { width:100%; border-radius:14px; border:1px solid var(--border); }
html.dark .struktur-img { border-color:#1e2d42; filter:brightness(0.85) contrast(1.05); }
.sejarah-content { font-size:14.5px; line-height:1.9; color:#4b5563; }
html.dark .sejarah-content { color:#94a3b8; }
.sejarah-content p { margin-bottom:14px; }
.sejarah-content p:last-child { margin-bottom:0; }
.wx-bar { background:#0d1e38; border-bottom:1px solid rgba(255,255,255,0.07); padding:0 56px; height:52px; display:flex; align-items:center; gap:0; overflow:hidden; }
html.dark .wx-bar { background:#080f1a; }
.wx-bar-current { display:flex; align-items:center; gap:10px; flex-shrink:0; padding-right:20px; border-right:1px solid rgba(255,255,255,0.08); height:32px; }
.wx-bar-icon { font-size:22px; line-height:1; }
.wx-bar-temp { font-size:18px; font-weight:800; color:#fff; letter-spacing:-0.5px; }
.wx-bar-info { display:flex; flex-direction:column; gap:1px; }
.wx-bar-desc { font-size:11.5px; font-weight:600; color:rgba(255,255,255,0.75); line-height:1; }
.wx-bar-meta { display:flex; gap:10px; font-size:10px; color:rgba(255,255,255,0.35); font-weight:500; }
.wx-bar-meta span { display:flex; align-items:center; gap:3px; }
.wx-bar-days { display:flex; align-items:center; gap:4px; flex:1; overflow-x:auto; padding:0 16px; scrollbar-width:none; }
.wx-bar-days::-webkit-scrollbar { display:none; }
.wx-bar-day { display:flex; align-items:center; gap:6px; padding:5px 12px; border-radius:100px; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.06); flex-shrink:0; transition:background 0.2s,border-color 0.2s; cursor:default; }
.wx-bar-day:hover { background:rgba(37,99,235,0.18); border-color:rgba(37,99,235,0.3); }
.wx-bar-day.wx-today-pill { background:rgba(37,99,235,0.2); border-color:rgba(37,99,235,0.45); }
.wx-bar-day-name { font-size:10.5px; font-weight:700; letter-spacing:0.5px; text-transform:uppercase; color:rgba(255,255,255,0.45); min-width:26px; }
.wx-bar-day.wx-today-pill .wx-bar-day-name { color:#fbbf24; }
.wx-bar-day-icon { font-size:16px; line-height:1; }
.wx-bar-day-temps { font-size:11px; font-weight:700; color:#fff; white-space:nowrap; }
.wx-bar-day-lo { color:rgba(255,255,255,0.35); font-weight:500; }
.wx-bar-refresh { flex-shrink:0; background:none; border:none; color:rgba(255,255,255,0.25); cursor:pointer; padding:6px; border-radius:6px; display:flex; align-items:center; transition:color 0.2s; font-family:inherit; }
.wx-bar-refresh:hover { color:rgba(255,255,255,0.7); }
.wx-bar-refresh svg { transition:transform 0.5s; }
.wx-bar-refresh.spinning svg { animation:wxSpin 0.7s linear infinite; }
@keyframes wxSpin { to{transform:rotate(360deg)} }
.wx-sk { background:rgba(255,255,255,0.07); border-radius:6px; animation:wxPulse 1.6s ease-in-out infinite; display:inline-block; }
@keyframes wxPulse { 0%,100%{opacity:.4} 50%{opacity:.9} }
@media (max-width:900px) { .hero{height:380px} .hero h1{font-size:38px} .main{padding:36px 24px 72px} .sambutan-grid{grid-template-columns:1fr} .kapolres-wrap{display:flex;align-items:center;gap:20px;text-align:left} .kapolres-img{width:100px;flex-shrink:0} .vm-grid{grid-template-columns:1fr} }
@media (max-width:768px) { .wx-bar{padding:0 20px} .wx-bar-current{padding-right:12px} .wx-bar-desc{display:none} }
@media (max-width:560px) { .hero{height:300px} .hero h1{font-size:28px} .hero-inner{padding:0 20px} }
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
            <img src="{{ Storage::disk('public')->url($heroSlides->first()->foto) }}" alt="{{ $heroSlides->first()->caption ?? 'Profil Polres Gunungkidul' }}">
        @else
            <img src="{{ asset('images/slideshow/foto1.jpeg') }}" alt="Polres Gunungkidul">
        @endif
    </div>
    <div class="hero-inner">
        <div class="hero-tag">Tentang Kami</div>
        <h1>Profil<br><em>Polres Gunungkidul</em></h1>
        <p class="hero-desc">Mengenal lebih dekat institusi kepolisian yang melayani masyarakat dengan profesional, humanis, dan berintegritas.</p>
        <div class="hero-breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="sep">›</span>
            <span>Profil</span>
        </div>
    </div>
</section>

{{-- MAIN --}}
<div class="main">

    {{-- SAMBUTAN KAPOLRES --}}
    <div class="card">
        <div class="card-title">Sambutan Kapolres</div>
        <div class="sambutan-grid">
            <div class="kapolres-wrap">
                @if($profile['foto_kapolres'])
                    <img src="{{ Storage::url($profile['foto_kapolres']) }}" class="kapolres-img" alt="Foto Kapolres" onerror="this.style.display='none'">
                @else
                    <img src="{{ asset('images/kapolres.JPEG') }}" class="kapolres-img" alt="Foto Kapolres" onerror="this.style.display='none'">
                @endif
                <div class="kapolres-name">{{ $profile['kapolres'] }}</div>
                <div class="kapolres-title">Kapolres Gunungkidul</div>
            </div>
            <div class="sambutan-text">
                @if($profile['sambutan'])
                    {!! $profile['sambutan'] !!}
                @else
                    <p>Selamat datang di website resmi {{ $profile['nama_instansi'] }}.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- VISI & MISI --}}
    <div class="card">
        <div class="card-title">Visi &amp; Misi</div>
        <div class="vm-grid">
            <div class="vm-box">
                <h4>Visi</h4>
                <p>{{ $profile['visi'] }}</p>
            </div>
            <div class="vm-box">
                <h4>Misi</h4>
                @if(count($profile['misi']) > 0)
                    <ul class="mission-list">
                        @foreach($profile['misi'] as $misi)
                            <li>{{ $misi }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>Belum ada data misi.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- SEJARAH --}}
    @if($profile['sejarah'])
    <div class="card">
        <div class="card-title">Sejarah</div>
        <div class="sejarah-content">
            {!! $profile['sejarah'] !!}
        </div>
    </div>
    @endif

    {{-- STRUKTUR ORGANISASI --}}
    <div class="card">
        <div class="card-title">Struktur Organisasi</div>
        @if($profile['struktur_organisasi'])
            <img src="{{ Storage::url($profile['struktur_organisasi']) }}" class="struktur-img" alt="Struktur Organisasi">
        @else
            <img src="{{ asset('images/STRUKTUR_ORGANISASI_POLRES.png') }}" class="struktur-img" alt="Struktur Organisasi">
        @endif
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