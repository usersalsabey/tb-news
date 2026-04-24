{{--
    ===== FOOTER PARTIAL =====
    Simpan di: resources/views/partials/footer.blade.php
--}}

<style>
/* ===== FOOTER ===== */
footer {
    background: #0a1628;
    color: #ffffff;
    padding: 0;
}

/* ─── Lokasi Banner ─── */
.footer-location {
    background: #0d1e38;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    padding: 20px 56px;
}
.footer-location-inner {
    max-width: 1100px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}
.footer-location-left {
    display: flex;
    align-items: center;
    gap: 14px;
}
.location-icon-wrap {
    width: 44px; height: 44px;
    background: rgba(37,99,235,0.15);
    border: 1px solid rgba(37,99,235,0.3);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.location-text {}
.location-label {
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: #f0a500;
    margin-bottom: 3px;
}
.location-address {
    font-size: 13.5px;
    color: rgba(255,255,255,0.8);
    font-weight: 600;
    line-height: 1.4;
}
.location-city {
    font-size: 12px;
    color: rgba(255,255,255,0.4);
    margin-top: 2px;
}

.maps-btn {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 11px 20px;
    background: #2563eb;
    color: #ffffff;
    font-size: 13px;
    font-weight: 700;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.25s;
    white-space: nowrap;
    flex-shrink: 0;
    border: 1px solid rgba(255,255,255,0.1);
}
.maps-btn:hover {
    background: #1d4ed8;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(37,99,235,0.4);
}
.maps-btn svg {
    flex-shrink: 0;
}

/* ─── Footer Grid ─── */
.footer-main {
    padding: 52px 56px 32px;
}
.footer-grid {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: 48px;
    padding-bottom: 40px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
    margin-bottom: 28px;
}
.footer-brand .logo {
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
    margin-bottom: 14px;
}
.footer-brand .logo img { width: 44px; height: 44px; object-fit: contain; }
.footer-brand .logo-text { display: flex; flex-direction: column; }
.footer-brand .logo-text span:first-child { font-size: 15px; font-weight: 800; color: #fff; line-height: 1.2; }
.footer-brand .logo-text span:last-child { font-size: 11px; color: #f0a500; font-weight: 500; letter-spacing: 0.8px; text-transform: uppercase; }
.footer-brand p {
    font-size: 13.5px;
    color: rgba(255,255,255,0.45);
    line-height: 1.9;
    max-width: 280px;
}

.footer-col h5 {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: #f0a500;
    margin-bottom: 18px;
}
.footer-col a,
.footer-col p {
    display: block;
    font-size: 13.5px;
    color: rgba(255,255,255,0.5);
    text-decoration: none;
    line-height: 2.2;
    transition: color 0.2s;
}
.footer-col a:hover { color: #ffffff; }

/* ─── Footer Bottom ─── */
.footer-bottom {
    max-width: 1100px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12.5px;
    color: rgba(255,255,255,0.3);
}

/* ─── Responsive ─── */
@media (max-width: 900px) {
    .footer-location { padding: 18px 28px; }
    .footer-main { padding: 44px 28px 28px; }
    .footer-grid { grid-template-columns: 1fr 1fr; gap: 32px; }
}
@media (max-width: 640px) {
    .footer-location-inner { flex-direction: column; align-items: flex-start; }
    .maps-btn { width: 100%; justify-content: center; }
    .footer-grid { grid-template-columns: 1fr; }
    .footer-bottom { flex-direction: column; gap: 8px; text-align: center; }
}
</style>

<footer>

    {{-- ─── LOKASI BANNER ─── --}}
    <div class="footer-location">
        <div class="footer-location-inner">
            <div class="footer-location-left">
                <div class="location-icon-wrap">📍</div>
                <div class="location-text">
                    <div class="location-label">Lokasi {{ $footerProfile->nama_instansi ?? 'Polres Gunungkidul' }}</div>
                    <div class="location-address">{{ $footerProfile->alamat ?? 'Jln. MGR Sugiyopranoto No.15, Wonosari' }}</div>
                </div>
            </div>

            <a href="{{ $footerProfile->maps_url ?? 'https://maps.google.com/?q=Polres+Gunungkidul' }}"
               target="_blank"
               rel="noopener"
               class="maps-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
                Buka di Google Maps
            </a>
        </div>
    </div>

    {{-- ─── FOOTER MAIN ─── --}}
    <div class="footer-main">
        <div class="footer-grid">

            {{-- Brand --}}
            <div class="footer-brand">
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ asset('images/new.PNG') }}" alt="Logo Polri">
                    <div class="logo-text">
                        <span>Tribrata News Gunungkidul</span>
                        <span>{{ $footerProfile->nama_instansi ?? 'Polres Gunungkidul' }}</span>
                    </div>
                </a>
            </div>

            {{-- Kontak --}}
            <div class="footer-col">
                <h5>Kontak</h5>
                <p>📧 {{ $contact['email']   ?? 'ppidgunungkidul@gmail.com' }}</p>
                <p>📞 {{ $contact['phone']   ?? '0851-3375-0875' }}</p>
                <p>🚨 {{ $contact['hotline'] ?? '110 (Darurat)' }}</p>
                <p>🕐 {{ $contact['hours']   ?? '24 Jam' }}</p>
            </div>

            {{-- Navigasi --}}
            <div class="footer-col">
                <h5>Navigasi</h5>
                @if(isset($aboutLinks))
                    @foreach($aboutLinks as $link)
                        <a href="{{ $link['url'] }}">{{ $link['name'] }}</a>
                    @endforeach
                @else
                    <a href="{{ route('home') }}">Beranda</a>
                    <a href="{{ route('profile') }}">Profil Lembaga</a>
                    <a href="{{ route('news') }}">Tribratanews</a>
                    <a href="{{ route('information') }}">Informasi Pelayanan</a>
                @endif
            </div>

        </div>

        <div class="footer-bottom">
            <span>© {{ date('Y') }} {{ $footerProfile->copyright ?? 'Polres Gunungkidul — Melayani Dengan Hati' }}</span>
            <span>Tribrata News Gunungkidul</span>
        </div>
    </div>

</footer>