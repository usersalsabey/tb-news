<style>
    /* ===== NAVBAR GLOBAL ===== */
    .navbar-header {
        background: #0a1628;
        padding: 0 56px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 72px;
        position: sticky;
        top: 0;
        z-index: 1000;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .logo { display: flex; align-items: center; gap: 14px; text-decoration: none; }
    .logo img { width: 44px; height: 44px; object-fit: contain; }
    .logo-text { display: flex; flex-direction: column; }
    .logo-text span:first-child { font-size: 15px; font-weight: 800; color: #ffffff; letter-spacing: 0.3px; line-height: 1.2; }
    .logo-text span:last-child { font-size: 11px; color: #f0a500; font-weight: 500; letter-spacing: 0.8px; text-transform: uppercase; }

    .header-right { display: flex; align-items: center; gap: 4px; }

    .navbar-header nav ul { display: flex; list-style: none; gap: 4px; margin: 0; padding: 0; }
    .navbar-header nav ul li a {
        text-decoration: none; color: rgba(255,255,255,0.65);
        font-size: 13.5px; font-weight: 600; padding: 8px 16px;
        border-radius: 8px; transition: all 0.2s; display: block;
    }
    .navbar-header nav ul li a:hover { color: #ffffff; background: rgba(255,255,255,0.08); }
    .navbar-header nav ul li a.active { color: #ffffff; background: #2563eb; }

    .dark-toggle {
        width: 38px; height: 38px; border-radius: 10px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.12);
        color: rgba(255,255,255,0.7);
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.25s; flex-shrink: 0; margin-left: 8px; outline: none;
    }
    .dark-toggle:hover { background: rgba(255,255,255,0.14); color: #fbbf24; border-color: rgba(240,165,0,0.4); }
    .dark-toggle svg { transition: transform 0.45s ease; pointer-events: none; }
    .dark-toggle:hover svg { transform: rotate(22deg); }
    .dark-toggle .icon-moon { display: block; }
    .dark-toggle .icon-sun  { display: none; }
    html.dark .dark-toggle .icon-moon { display: none; }
    html.dark .dark-toggle .icon-sun  { display: block; }

    /* ===== DATE ===== */
    .header-date {
        display: flex; align-items: center; gap: 7px;
        padding: 6px 13px; border-radius: 10px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.1);
        margin-left: 8px; flex-shrink: 0;
    }
    .header-date svg { color: #f0a500; flex-shrink: 0; }
    .header-date-text { display: flex; flex-direction: column; gap: 1px; }
    .header-date-day { font-size: 10px; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; color: #fbbf24; line-height: 1; }
    .header-date-full { font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.7); line-height: 1; }

    /* ===== SEARCH ===== */
    .search-wrap { display: flex; align-items: center; position: relative; margin-left: 8px; }
    .search-toggle {
        width: 38px; height: 38px; border-radius: 10px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.12);
        color: rgba(255,255,255,0.7);
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        transition: all 0.25s; flex-shrink: 0; outline: none;
    }
    .search-toggle:hover { background: rgba(255,255,255,0.14); color: #fbbf24; border-color: rgba(240,165,0,0.4); }
    .search-box {
        position: absolute; right: 0; top: calc(100% + 10px);
        display: flex; align-items: center;
        background: #0d1e38;
        border: 1px solid rgba(255,255,255,0.18);
        border-radius: 10px; overflow: hidden;
        width: 0; opacity: 0; pointer-events: none;
        transition: width 0.35s ease, opacity 0.25s ease;
        box-shadow: 0 8px 32px rgba(0,0,0,0.35);
        min-height: 42px;
    }
    .search-box.open { width: 300px; opacity: 1; pointer-events: all; }
    .search-box input {
        flex: 1; background: transparent; border: none; outline: none;
        color: #ffffff; font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13.5px; padding: 9px 14px; caret-color: #fbbf24;
    }
    .search-box input::placeholder { color: rgba(255,255,255,0.35); }
    .search-box-clear {
        background: none; border: none; color: rgba(255,255,255,0.4);
        cursor: pointer; padding: 0 10px; font-size: 16px; line-height: 1;
        transition: color 0.2s; display: none;
    }
    .search-box-clear:hover { color: #ffffff; }
    .search-box-clear.visible { display: block; }
    .search-results {
        position: absolute; right: 0; top: calc(100% + 10px);
        width: 320px; background: #0d1e38;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 14px; overflow: hidden;
        box-shadow: 0 20px 48px rgba(0,0,0,0.4);
        display: none; z-index: 2000;
    }
    html.dark .search-results { background: #0a1220; border-color: #1e2d42; }
    .search-results.open { display: block; }
    .search-results-header {
        padding: 10px 16px; font-size: 10.5px; font-weight: 700;
        letter-spacing: 1px; text-transform: uppercase;
        color: rgba(255,255,255,0.35); border-bottom: 1px solid rgba(255,255,255,0.07);
    }
    .search-result-item {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 16px; text-decoration: none; color: #ffffff;
        transition: background 0.2s; border: none;
        background: none; width: 100%; text-align: left; font-family: inherit;
    }
    .search-result-item:hover { background: rgba(255,255,255,0.07); }
    .search-result-icon {
        width: 36px; height: 36px; border-radius: 10px;
        background: rgba(37,99,235,0.2); border: 1px solid rgba(37,99,235,0.3);
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; flex-shrink: 0;
    }
    .search-result-title { font-size: 13px; font-weight: 700; line-height: 1.3; }
    .search-result-sub { font-size: 11px; color: rgba(255,255,255,0.4); margin-top: 2px; }
    .search-result-highlight { color: #fbbf24; }
    .search-no-result { padding: 20px 16px; text-align: center; font-size: 13px; color: rgba(255,255,255,0.35); }

    @media (max-width: 768px) {
        .navbar-header { padding: 0 24px; height: auto; padding-top: 14px; padding-bottom: 14px; flex-direction: column; gap: 12px; }
        .header-date { display: none; }
        .search-box.open { width: 200px; }
    }
    @media (max-width: 480px) {
        .navbar-header nav ul li a { padding: 7px 11px; font-size: 12px; }
        .search-box.open { width: 160px; }
    }
</style>

<header class="navbar-header">
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
                <li><a href="{{ route('home') }}"        class="{{ request()->routeIs('home')        ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ route('profile') }}"     class="{{ request()->routeIs('profile')     ? 'active' : '' }}">Profil</a></li>
                <li><a href="{{ route('news') }}"        class="{{ request()->routeIs('news*')       ? 'active' : '' }}">Tribratanews</a></li>
                <li><a href="{{ route('information') }}" class="{{ request()->routeIs('information*')? 'active' : '' }}">Informasi Pelayanan</a></li>
            </ul>
        </nav>

        {{-- Date --}}
        <div class="header-date">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <div class="header-date-text">
                <span class="header-date-day" id="headerDateDay"></span>
                <span class="header-date-full" id="headerDateFull"></span>
            </div>
        </div>

        {{-- Search --}}
        <div class="search-wrap" id="searchWrap">
            <div class="search-box" id="searchBox">
                <input type="text" id="searchInput" placeholder="Cari halaman, berita…" autocomplete="off">
                <button class="search-box-clear" id="searchClear" tabindex="-1">×</button>
            </div>
            <button class="search-toggle" id="searchToggle" title="Cari" aria-label="Buka pencarian">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </button>
            <div class="search-results" id="searchResults"></div>
        </div>

        {{-- Dark Mode --}}
        <button class="dark-toggle" id="darkToggle" title="Ganti tema" aria-label="Toggle dark mode">
            <svg class="icon-moon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
            </svg>
            <svg class="icon-sun" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="5"/>
                <line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
            </svg>
        </button>
    </div>
</header>

<script>
// ===== DATE =====
(function () {
    const HARI = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    function pad(n) { return String(n).padStart(2, '0'); }
    function render() {
        const now = new Date();
        document.getElementById('headerDateDay').textContent  = HARI[now.getDay()];
        document.getElementById('headerDateFull').textContent = pad(now.getDate()) + '/' + pad(now.getMonth()+1) + '/' + now.getFullYear();
    }
    render(); setInterval(render, 60000);
})();

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

// ===== SEARCH =====
(function () {
    const wrap     = document.getElementById('searchWrap');
    const box      = document.getElementById('searchBox');
    const input    = document.getElementById('searchInput');
    const clearBtn = document.getElementById('searchClear');
    const toggle   = document.getElementById('searchToggle');
    const results  = document.getElementById('searchResults');

    const pages = [
        { title: 'Beranda',              sub: 'Halaman utama',                      icon: '🏠', url: '/' },
        { title: 'Profil',               sub: 'Tentang Polres Gunungkidul',         icon: '🏛️', url: '/profile' },
        { title: 'Tribratanews',         sub: 'Berita & informasi terkini',         icon: '📰', url: '/news' },
        { title: 'Informasi Pelayanan',  sub: 'Layanan kepolisian',                 icon: '📋', url: '/information' },
        { title: 'SKCK',                 sub: 'Surat Keterangan Catatan Kepolisian', icon: '📄', url: '/information' },
        { title: 'SKCK Online',          sub: 'Pengajuan SKCK secara online',       icon: '🖥️', url: '/information' },
        { title: 'SIM',                  sub: 'Surat Izin Mengemudi',               icon: '🪪', url: '/information' },
        { title: 'Laporan Polisi',       sub: 'Buat laporan ke kepolisian',         icon: '📝', url: '/information' },
        { title: 'Pengaduan',            sub: 'Sampaikan pengaduan masyarakat',     icon: '📢', url: '/information' },
        { title: 'Visi & Misi',          sub: 'Tujuan & nilai organisasi',          icon: '🎯', url: '/#profil' },
        { title: 'Sejarah',              sub: 'Sejarah Polres Gunungkidul',         icon: '🏅', url: '/#profil' },
        { title: 'Sambutan Kapolres',    sub: 'Kata sambutan Kapolres',             icon: '👮', url: '/#profil' },
        { title: 'Kontak',               sub: 'Hubungi kami',                       icon: '📞', url: '/#kontak' },
        { title: 'Lokasi / Maps',        sub: 'Jln. MGR Sugiyopranoto No.15',      icon: '📍', url: 'https://maps.app.goo.gl/Xv8tKdyoVjMf4DkRA', external: true },
        { title: 'Instagram',            sub: '@polres.gunungkidul',                icon: '📸', url: 'https://www.instagram.com/polres.gunungkidul/', external: true },
        { title: 'Facebook',             sub: 'Polres Gunungkidul',                 icon: '👥', url: 'https://www.facebook.com/polresgunungkidul', external: true },
        { title: 'YouTube',              sub: 'Polres Gunungkidul',                 icon: '▶️', url: 'https://www.youtube.com/@polresgunungkidul', external: true },
        { title: 'TikTok',               sub: '@polres.gunungkidul',                icon: '🎵', url: 'https://www.tiktok.com/@polres.gunungkidul', external: true },
    ];

    let isOpen = false;

    function openSearch()  {
        isOpen = true; box.classList.add('open');
        toggle.style.color = '#fbbf24';
        setTimeout(() => input.focus(), 350);
    }
    function closeSearch() {
        isOpen = false; box.classList.remove('open');
        results.classList.remove('open'); results.innerHTML = '';
        input.value = ''; clearBtn.classList.remove('visible');
        toggle.style.color = '';
    }

    toggle.addEventListener('click', () => isOpen ? closeSearch() : openSearch());

    input.addEventListener('input', function () {
        const q = this.value.trim().toLowerCase();
        clearBtn.classList.toggle('visible', q.length > 0);
        if (!q) { results.classList.remove('open'); results.innerHTML = ''; return; }
        const filtered = pages.filter(p => p.title.toLowerCase().includes(q) || p.sub.toLowerCase().includes(q));
        function highlight(text, q) {
            const idx = text.toLowerCase().indexOf(q);
            if (idx < 0) return text;
            return text.slice(0, idx) + '<span class="search-result-highlight">' + text.slice(idx, idx + q.length) + '</span>' + text.slice(idx + q.length);
        }
        results.innerHTML = !filtered.length
            ? `<div class="search-no-result">Tidak ada hasil untuk "<strong>${q}</strong>"</div>`
            : `<div class="search-results-header">Hasil Pencarian</div>` + filtered.map(p =>
                `<a href="${p.url}" class="search-result-item" ${p.external ? 'target="_blank" rel="noopener"' : ''}>
                    <div class="search-result-icon">${p.icon}</div>
                    <div><div class="search-result-title">${highlight(p.title, q)}</div>
                    <div class="search-result-sub">${highlight(p.sub, q)}</div></div>
                </a>`).join('');
        results.classList.add('open');
    });

    clearBtn.addEventListener('click', () => { input.value = ''; input.focus(); clearBtn.classList.remove('visible'); results.classList.remove('open'); results.innerHTML = ''; });
    document.addEventListener('click', e => { if (isOpen && !wrap.contains(e.target)) closeSearch(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && isOpen) closeSearch(); });
})();
</script>