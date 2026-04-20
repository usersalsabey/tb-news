@extends('layouts.app')

@section('title', 'TB News - Portal Kepolisian Indonesia')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
        --navy:    #0a1628;
        --blue:    #1a3a6e;
        --mid:     #1e4da1;
        --accent:  #2563eb;
        --gold:    #f0a500;
        --gold-lt: #fbbf24;
        --surface: #f4f6fa;
        --white:   #ffffff;
        --text:    #1a1f2e;
        --muted:   #6b7280;
        --border:  #e2e8f0;
        --radius:  16px;
    }

    html.dark {
        --surface: #0f1923;
        --white:   #1a2535;
        --text:    #e2e8f0;
        --muted:   #94a3b8;
        --border:  #1e2d42;
    }

    body, .vm-section, .news-section, .social-section, .ig-section,
    .vm-card, .news-card, .social-card, .social-icon-wrap,
    .section-header h2, .section-header p, .eyebrow,
    .news-title, .news-excerpt, .news-date,
    .mission-list li, .ig-username, .ig-stat strong, .ig-view-all,
    .filter-tab, .result-count, .result-count strong {
        transition: background-color 0.3s ease, color 0.3s ease,
                    border-color 0.3s ease, box-shadow 0.3s ease;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: var(--surface);
        color: var(--text);
        overflow-x: hidden;
    }
    html.dark body { background: var(--surface); color: var(--text); }
    html { scroll-behavior: smooth; }

    header {
        background: var(--navy);
        padding: 0 56px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 72px;
        position: sticky;
        top: 0;
        z-index: 1000;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }

    .logo { display: flex; align-items: center; gap: 14px; text-decoration: none; }
    .logo img { width: 44px; height: 44px; object-fit: contain; }
    .logo-text { display: flex; flex-direction: column; }
    .logo-text span:first-child { font-size: 15px; font-weight: 800; color: var(--white); letter-spacing: 0.3px; line-height: 1.2; }
    .logo-text span:last-child { font-size: 11px; color: var(--gold); font-weight: 500; letter-spacing: 0.8px; text-transform: uppercase; }

    .header-right { display: flex; align-items: center; gap: 4px; }

    nav ul { display: flex; list-style: none; gap: 4px; }
    nav ul li a {
        text-decoration: none; color: rgba(255,255,255,0.65);
        font-size: 13.5px; font-weight: 600; padding: 8px 16px;
        border-radius: 8px; transition: all 0.2s; display: block;
    }
    nav ul li a:hover { color: var(--white); background: rgba(255,255,255,0.08); }
    nav ul li a.active { color: var(--white); background: var(--accent); }

    .dark-toggle {
        width: 38px; height: 38px; border-radius: 10px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.12);
        color: rgba(255,255,255,0.7);
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.25s;
        flex-shrink: 0;
        margin-left: 8px;
        outline: none;
    }
    .dark-toggle:hover { background: rgba(255,255,255,0.14); color: var(--gold-lt); border-color: rgba(240,165,0,0.4); }
    .dark-toggle svg { transition: transform 0.45s ease; pointer-events: none; }
    .dark-toggle:hover svg { transform: rotate(22deg); }
    .dark-toggle .icon-moon { display: block; }
    .dark-toggle .icon-sun  { display: none; }
    html.dark .dark-toggle .icon-moon { display: none; }
    html.dark .dark-toggle .icon-sun  { display: block; }

    .search-wrap { display: flex; align-items: center; position: relative; margin-left: 8px; }
    .search-toggle {
        width: 38px; height: 38px; border-radius: 10px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.12);
        color: rgba(255,255,255,0.7);
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.25s; flex-shrink: 0; outline: none;
    }
    .search-toggle:hover { background: rgba(255,255,255,0.14); color: var(--gold-lt); border-color: rgba(240,165,0,0.4); }
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
        color: var(--white); font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13.5px; padding: 9px 14px;
        caret-color: var(--gold-lt);
    }
    .search-box input::placeholder { color: rgba(255,255,255,0.35); }
    .search-box-clear {
        background: none; border: none; color: rgba(255,255,255,0.4);
        cursor: pointer; padding: 0 10px; font-size: 16px; line-height: 1;
        transition: color 0.2s; display: none;
    }
    .search-box-clear:hover { color: var(--white); }
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
        padding: 12px 16px; text-decoration: none; color: var(--white);
        transition: background 0.2s; cursor: pointer; border: none;
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
    .search-result-highlight { color: var(--gold-lt); }
    .search-no-result { padding: 20px 16px; text-align: center; font-size: 13px; color: rgba(255,255,255,0.35); }

    .header-date {
        display: flex; align-items: center; gap: 7px;
        padding: 6px 13px; border-radius: 10px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.1);
        margin-left: 8px; flex-shrink: 0;
    }
    .header-date svg { color: var(--gold); flex-shrink: 0; }
    .header-date-text { display: flex; flex-direction: column; gap: 1px; }
    .header-date-day { font-size: 10px; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; color: var(--gold-lt); line-height: 1; }
    .header-date-full { font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.7); line-height: 1; }

    .hero { position: relative; height: 580px; overflow: hidden; display: flex; align-items: center; justify-content: center; }
    .hero-slides-wrapper { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; }
    .hero-slides-wrapper .hero-slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 1.2s ease-in-out; }
    .hero-slides-wrapper .hero-slide.active { opacity: 1; }
    .hero-slides-wrapper .hero-slide img { display: block; width: 100%; height: 100%; object-fit: cover; object-position: center; }
    .hero-slides-wrapper .hero-slide.active:nth-child(1) img { animation: kb1 20s ease-in-out infinite alternate; }
    .hero-slides-wrapper .hero-slide.active:nth-child(2) img { animation: kb2 20s ease-in-out infinite alternate; }
    .hero-slides-wrapper .hero-slide.active:nth-child(3) img { animation: kb3 20s ease-in-out infinite alternate; }
    .hero-slides-wrapper .hero-slide.active:nth-child(4) img { animation: kb4 20s ease-in-out infinite alternate; }
    @keyframes kb1 { 0% { transform: scale(1)    translate(0,0);    } 100% { transform: scale(1.12) translate(-2%,-1%); } }
    @keyframes kb2 { 0% { transform: scale(1.1)  translate(-2%,0);  } 100% { transform: scale(1)    translate(2%,-2%);  } }
    @keyframes kb3 { 0% { transform: scale(1)    translate(2%,1%);  } 100% { transform: scale(1.1)  translate(-1%,-2%); } }
    @keyframes kb4 { 0% { transform: scale(1.08) translate(1%,-1%); } 100% { transform: scale(1)    translate(-2%,1%);  } }
    .hero-overlay { position: absolute; inset: 0; background: linear-gradient(135deg, rgba(10,22,40,0.80) 0%, rgba(26,58,110,0.65) 60%, rgba(10,22,40,0.78) 100%); z-index: 1; }
    .hero-content { position: relative; z-index: 2; text-align: center; color: var(--white); max-width: 820px; padding: 40px; }
    .hero-tag {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(240,165,0,0.12); border: 1px solid rgba(240,165,0,0.3);
        color: var(--gold-lt); font-size: 11px; font-weight: 700; letter-spacing: 1.2px;
        text-transform: uppercase; padding: 6px 14px; border-radius: 100px; margin-bottom: 22px;
    }
    .hero-tag::before { content: '●'; font-size: 8px; }
    .hero-content h1 { font-family: 'DM Serif Display', serif; font-size: 62px; font-weight: 400; line-height: 1.1; margin-bottom: 18px; letter-spacing: -0.5px; }
    .hero-content h1 em { font-style: italic; color: var(--gold-lt); }
    .hero-content p { font-size: 16px; color: rgba(255,255,255,0.65); line-height: 1.8; margin-bottom: 32px; max-width: 520px; margin-left: auto; margin-right: auto; }
    .hero-btn { display: inline-block; padding: 14px 36px; background: var(--gold); color: var(--navy); font-weight: 700; font-size: 14px; border-radius: 10px; text-decoration: none; transition: all 0.25s; letter-spacing: 0.3px; }
    .hero-btn:hover { background: var(--gold-lt); transform: translateY(-3px); box-shadow: 0 12px 32px rgba(240,165,0,0.35); }
    .hero-arrow { position: absolute; top: 50%; transform: translateY(-50%); z-index: 3; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: var(--white); width: 46px; height: 46px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; cursor: pointer; backdrop-filter: blur(8px); transition: all 0.25s; outline: none; }
    .hero-arrow:hover { background: var(--gold); border-color: var(--gold); color: var(--navy); transform: translateY(-50%) scale(1.08); }
    .hero-arrow.prev { left: 28px; }
    .hero-arrow.next { right: 28px; }
    .hero-dots { position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 3; display: flex; gap: 8px; align-items: center; }
    .hero-dot { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.35); border: 1.5px solid rgba(255,255,255,0.5); cursor: pointer; transition: all 0.35s; }
    .hero-dot.active { background: var(--gold); border-color: var(--gold); width: 24px; border-radius: 4px; }
    .hero-caption { position: absolute; bottom: 58px; left: 0; right: 0; z-index: 3; text-align: center; }
    .hero-caption-text { display: inline-block; background: rgba(10,22,40,0.55); backdrop-filter: blur(6px); color: rgba(255,255,255,0.85); font-size: 13px; font-weight: 500; letter-spacing: 0.8px; padding: 5px 18px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.15); opacity: 0; transition: opacity 0.6s ease; }
    .hero-caption-text.visible { opacity: 1; }
    .hero-progress { position: absolute; bottom: 0; left: 0; height: 3px; background: linear-gradient(90deg, var(--gold), var(--gold-lt)); z-index: 3; width: 0%; }

    .section-wrap { max-width: 1100px; margin: 0 auto; padding: 72px 40px; }
    .section-header { margin-bottom: 44px; }
    .section-header .eyebrow { display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--accent); margin-bottom: 10px; }
    html.dark .section-header .eyebrow { color: #60a5fa; }
    .section-header h2 { font-family: 'DM Serif Display', serif; font-size: 38px; color: var(--text); line-height: 1.15; font-weight: 400; }
    .section-header p { font-size: 15px; color: var(--muted); line-height: 1.75; margin-top: 10px; max-width: 480px; }
    .section-divider { width: 48px; height: 3px; background: linear-gradient(90deg, var(--accent), var(--gold)); border-radius: 2px; margin-top: 14px; }

    .vm-section { background: var(--white); }
    html.dark .vm-section { background: #141f2e; }
    .vm-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
    .vm-card { background: var(--surface); border: 1px solid var(--border); border-radius: 20px; padding: 36px 32px; position: relative; overflow: hidden; transition: box-shadow 0.25s, transform 0.25s, background-color 0.3s, border-color 0.3s; }
    .vm-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(10,22,40,0.1); }
    html.dark .vm-card { background: #1a2535; border-color: #1e2d42; }
    html.dark .vm-card:hover { box-shadow: 0 16px 40px rgba(0,0,0,0.4); }
    .vm-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: linear-gradient(180deg, var(--accent), var(--gold)); }
    .vm-card h3 { font-size: 20px; font-weight: 800; color: var(--text); margin-bottom: 14px; }
    .vm-card p { font-size: 14px; line-height: 1.85; color: var(--muted); }
    .mission-list { list-style: none; display: flex; flex-direction: column; gap: 10px; }
    .mission-list li { display: flex; align-items: flex-start; gap: 10px; font-size: 13.5px; color: #4b5563; line-height: 1.65; }
    html.dark .mission-list li { color: #94a3b8; }
    .mission-list li::before { content: '✓'; width: 18px; height: 18px; border-radius: 50%; background: var(--accent); color: var(--white); font-size: 9px; font-weight: 900; flex-shrink: 0; display: flex; align-items: center; justify-content: center; margin-top: 2px; }

    .news-section { background: var(--surface); }
    html.dark .news-section { background: #0f1923; }
    .news-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
    .news-card { background: var(--white); border-radius: 18px; border: 1px solid var(--border); overflow: hidden; display: flex; flex-direction: column; transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s, background-color 0.3s; text-decoration: none; color: inherit; }
    .news-card:hover { transform: translateY(-5px); box-shadow: 0 18px 44px rgba(10,22,40,0.11); border-color: transparent; }
    html.dark .news-card { background: #1a2535; border-color: #1e2d42; }
    html.dark .news-card:hover { box-shadow: 0 18px 44px rgba(0,0,0,0.4); border-color: #2d3e55; }
    .news-image { width: 100%; height: 200px; position: relative; overflow: hidden; background: var(--blue); }
    .news-image > img, .news-slide img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.4s ease; }
    .news-card:hover .news-image > img { transform: scale(1.05); }
    .news-slideshow { position: relative; width: 100%; height: 100%; }
    .news-slide { position: absolute; width: 100%; height: 100%; opacity: 0; transition: opacity 1s ease-in-out; }
    .news-slide.active { opacity: 1; }
    .slideshow-dots { position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); display: flex; gap: 6px; z-index: 10; }
    .dot { width: 7px; height: 7px; border-radius: 50%; background: rgba(255,255,255,0.5); cursor: pointer; transition: all 0.3s; }
    .dot.active { background: var(--white); width: 20px; border-radius: 3px; }
    .news-icon-placeholder { width: 100%; height: 100%; background: linear-gradient(135deg, var(--blue), var(--accent)); display: flex; align-items: center; justify-content: center; font-size: 60px; }
    .news-body { padding: 22px 22px 18px; flex: 1; display: flex; flex-direction: column; gap: 8px; }
    .news-date { font-size: 11.5px; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; color: var(--accent); }
    html.dark .news-date { color: #60a5fa; }
    .news-title { font-size: 16px; font-weight: 800; color: var(--text); line-height: 1.35; }
    .news-excerpt { font-size: 13.5px; color: var(--muted); line-height: 1.7; flex: 1; }
    .news-readmore { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 700; color: var(--accent); text-decoration: none; margin-top: 8px; transition: gap 0.2s; }
    html.dark .news-readmore { color: #60a5fa; }
    .news-readmore:hover { gap: 10px; }

    .wx-bar { background: #0d1e38; border-bottom: 1px solid rgba(255,255,255,0.07); padding: 0 56px; height: 52px; display: flex; align-items: center; gap: 0; overflow: hidden; position: relative; }
    html.dark .wx-bar { background: #080f1a; }
    .wx-bar-current { display: flex; align-items: center; gap: 10px; flex-shrink: 0; padding-right: 20px; border-right: 1px solid rgba(255,255,255,0.08); height: 32px; }
    .wx-bar-icon   { font-size: 22px; line-height: 1; }
    .wx-bar-temp   { font-size: 18px; font-weight: 800; color: var(--white); letter-spacing: -0.5px; }
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
    .wx-bar-day.wx-today-pill .wx-bar-day-name { color: var(--gold-lt); }
    .wx-bar-day-icon  { font-size: 16px; line-height: 1; }
    .wx-bar-day-temps { font-size: 11px; font-weight: 700; color: var(--white); white-space: nowrap; }
    .wx-bar-day-lo    { color: rgba(255,255,255,0.35); font-weight: 500; }
    .wx-bar-refresh { flex-shrink: 0; background: none; border: none; color: rgba(255,255,255,0.25); cursor: pointer; padding: 6px; border-radius: 6px; display: flex; align-items: center; transition: color 0.2s; font-family: 'Plus Jakarta Sans', sans-serif; }
    .wx-bar-refresh:hover { color: rgba(255,255,255,0.7); }
    .wx-bar-refresh svg { transition: transform 0.5s; }
    .wx-bar-refresh.spinning svg { animation: wxSpin 0.7s linear infinite; }
    @keyframes wxSpin { to { transform: rotate(360deg); } }
    .wx-sk { background: rgba(255,255,255,0.07); border-radius: 6px; animation: wxPulse 1.6s ease-in-out infinite; display: inline-block; }
    @keyframes wxPulse { 0%,100%{opacity:.4} 50%{opacity:.9} }

    .social-section { background: var(--white); }
    html.dark .social-section { background: #141f2e; }
    .social-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
    .social-card { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 24px 20px; display: flex; align-items: center; gap: 16px; text-decoration: none; color: var(--text); transition: all 0.25s; cursor: pointer; }
    .social-card:hover { background: var(--navy); color: var(--white); border-color: var(--navy); transform: translateY(-4px); box-shadow: 0 12px 32px rgba(10,22,40,0.15); }
    .social-card:hover .social-handle { color: rgba(255,255,255,0.55); }
    html.dark .social-card { background: #1a2535; border-color: #1e2d42; color: #e2e8f0; }
    html.dark .social-card:hover { background: #2563eb; border-color: #2563eb; color: #fff; }
    .social-icon-wrap { width: 46px; height: 46px; border-radius: 12px; background: var(--white); display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid var(--border); overflow: hidden; }
    html.dark .social-icon-wrap { background: #0f1923; border-color: #1e2d42; }
    .social-card:hover .social-icon-wrap { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.15); }
    .social-name { font-size: 14px; font-weight: 700; }
    .social-handle { font-size: 12px; color: var(--muted); margin-top: 2px; }
    html.dark .social-handle { color: #64748b; }

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
    .footer-col a, .footer-col p { display: block; font-size: 13.5px; color: rgba(255,255,255,0.5); text-decoration: none; line-height: 2.2; transition: color 0.2s; }
    .footer-col a:hover { color: var(--white); }
    .footer-bottom { max-width: 1100px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; font-size: 12.5px; color: rgba(255,255,255,0.3); }

    .fade-up { opacity: 0; transform: translateY(32px); transition: opacity 0.65s ease, transform 0.65s ease; }
    .fade-up.visible { opacity: 1; transform: translateY(0); }

    .sambutan-section { background: var(--white); }
    html.dark .sambutan-section { background: #141f2e; }
    .sambutan-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 48px; align-items: center; }
    .sambutan-photo-wrap { width: 100%; aspect-ratio: 3/4; border-radius: 20px; overflow: hidden; background: linear-gradient(135deg, var(--blue), var(--accent)); box-shadow: 0 20px 52px rgba(10,22,40,0.18); position: relative; }
    html.dark .sambutan-photo-wrap { box-shadow: 0 20px 52px rgba(0,0,0,0.4); }
    .sambutan-photo-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .sambutan-photo-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 72px; }
    .sambutan-body { display: flex; flex-direction: column; gap: 20px; }
    .sambutan-text { font-size: 14.5px; line-height: 1.9; color: var(--muted); }
    .sambutan-name { font-size: 15px; font-weight: 800; color: var(--text); }
    .sambutan-jabatan { font-size: 12px; color: var(--muted); margin-top: 2px; }

    .sejarah-section { background: var(--surface); }
    html.dark .sejarah-section { background: #0f1923; }
    .sejarah-content { font-size: 15px; line-height: 2; color: var(--muted); }
    .sejarah-content p + p { margin-top: 16px; }

    @media (max-width: 1024px) {
        .news-grid { grid-template-columns: repeat(2, 1fr); }
        .social-grid { grid-template-columns: repeat(2, 1fr); }
        .vm-grid { grid-template-columns: 1fr; }
        .footer-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 768px) {
        header { padding: 0 24px; height: auto; padding-top: 14px; padding-bottom: 14px; flex-direction: column; gap: 12px; }
        .hero { height: 480px; }
        .hero-content h1 { font-size: 40px; }
        .hero-arrow { display: none; }
        .section-wrap { padding: 52px 24px; }
        .news-grid { grid-template-columns: 1fr; }
        .social-grid { grid-template-columns: repeat(2, 1fr); }
        .footer-grid { grid-template-columns: 1fr; }
        .footer-location { padding: 18px 28px; }
        .footer-main { padding: 44px 28px 28px; }
        .footer-bottom { flex-direction: column; gap: 8px; text-align: center; }
        .wx-bar { padding: 0 20px; }
        .wx-bar-current { padding-right: 12px; }
        .wx-bar-desc { display: none; }
        .search-box.open { width: 200px; }
        .header-date { display: none; }
        .sambutan-grid { grid-template-columns: 1fr; }
        .sambutan-photo-wrap { aspect-ratio: 1/1; max-width: 280px; margin: 0 auto; }
    }
    @media (max-width: 480px) {
        .hero-content h1 { font-size: 30px; }
        .social-grid { grid-template-columns: 1fr; }
        nav ul li a { padding: 7px 11px; font-size: 12px; }
        .wx-bar-meta { display: none; }
        .search-box.open { width: 160px; }
    }
</style>
@endpush

@section('content')

{{-- ===== WEATHER BAR ===== --}}
<div class="wx-bar" id="wxBar">
    <div class="wx-bar-current">
        <div class="wx-bar-icon" id="wxIcon">⏳</div>
        <div class="wx-bar-info">
            <div style="display:flex;align-items:baseline;gap:6px;">
                <span class="wx-bar-temp" id="wxTemp"><span class="wx-sk" style="width:42px;height:16px;border-radius:4px;display:inline-block;vertical-align:middle;"></span></span>
            </div>
            <div class="wx-bar-desc" id="wxDesc">Memuat…</div>
            <div class="wx-bar-meta" id="wxMeta">
                <span id="wxHum">💧 --</span>
                <span id="wxWnd">💨 --</span>
                <span id="wxPrcp">☔ --</span>
            </div>
        </div>
    </div>
    <div class="wx-bar-days" id="wxDays">
        @for($i = 0; $i < 7; $i++)
        <div class="wx-bar-day">
            <span class="wx-bar-day-name"><span class="wx-sk" style="width:26px;height:9px;border-radius:3px;display:inline-block;"></span></span>
            <span class="wx-bar-day-icon"><span class="wx-sk" style="width:16px;height:16px;border-radius:50%;display:inline-block;"></span></span>
            <span class="wx-bar-day-temps"><span class="wx-sk" style="width:38px;height:9px;border-radius:3px;display:inline-block;"></span></span>
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

{{-- ===== HERO ===== --}}
<section class="hero">
    <div class="hero-slides-wrapper" id="heroSlidesWrapper">
        @forelse($heroSlides as $index => $slide)
        <div class="hero-slide {{ $index === 0 ? 'active' : '' }}"
             data-caption="{{ $slide->caption ?? '' }}">
            <img src="{{ Storage::disk('public')->url($slide->foto) }}"
                 alt="{{ $slide->caption ?? 'Slide '.($index+1) }}"
                 loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
        </div>
        @empty
        <div class="hero-slide active" data-caption="Melayani Masyarakat Gunungkidul">
            <img src="{{ asset('images/hero/slide1.jpg') }}" alt="Slide 1">
        </div>
        <div class="hero-slide" data-caption="Keamanan & Ketertiban Bersama">
            <img src="{{ asset('images/hero/slide2.jpeg') }}" alt="Slide 2">
        </div>
        <div class="hero-slide" data-caption="Profesional dalam Bertugas">
            <img src="{{ asset('images/hero/slide3.jpg') }}" alt="Slide 3">
        </div>
        <div class="hero-slide" data-caption="Bersama Menjaga Nusantara">
            <img src="{{ asset('images/hero/slide4.jpg') }}" alt="Slide 4">
        </div>
        @endforelse
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="hero-tag">Portal Resmi Polres Gunungkidul</div>
        <h1>TB News <em>Polri</em></h1>
        <p>Melayani Dengan Sepenuh Hati, Menjaga Dengan Tanggung Jawab</p>
        <a href="#berita" class="hero-btn">Lihat Berita Terbaru</a>
    </div>
    <button class="hero-arrow prev" id="heroPrev" aria-label="Sebelumnya">&#8592;</button>
    <button class="hero-arrow next" id="heroNext" aria-label="Selanjutnya">&#8594;</button>
    <div class="hero-dots" id="heroDots"></div>
    <div class="hero-caption"><span class="hero-caption-text" id="heroCaption"></span></div>
    <div class="hero-progress" id="heroProgress"></div>
</section>

{{-- ===== SAMBUTAN ===== --}}
@if($sambutan)
<section class="sambutan-section">
    <div class="section-wrap">
        <div class="section-header fade-up">
            <span class="eyebrow">Kata Pengantar</span>
            <h2>Sambutan Kapolres</h2>
            <div class="section-divider"></div>
        </div>
        <div class="sambutan-grid fade-up">
            <div class="sambutan-photo-wrap">
                @if(!empty($kapolres['foto']))
                    <img src="{{ Storage::url($kapolres['foto']) }}" alt="{{ $kapolres['nama'] }}">
                @else
                    <div class="sambutan-photo-placeholder">👮</div>
                @endif
            </div>
            <div class="sambutan-body">
                <div class="sambutan-text">{!! $sambutan !!}</div>
                <div>
                    <div class="sambutan-name">{{ $kapolres['nama'] }}</div>
                    <div class="sambutan-jabatan">Kapolres Gunungkidul</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ===== SEJARAH ===== --}}
@if($sejarah)
<section class="sejarah-section">
    <div class="section-wrap">
        <div class="section-header fade-up">
            <span class="eyebrow">Latar Belakang</span>
            <h2>Sejarah Polres Gunungkidul</h2>
            <div class="section-divider"></div>
        </div>
        <div class="sejarah-content fade-up">
            {!! $sejarah !!}
        </div>
    </div>
</section>
@endif

{{-- ===== VISI & MISI ===== --}}
<section class="vm-section" id="profil">
    <div class="section-wrap">
        <div class="section-header fade-up">
            <span class="eyebrow">Tentang Kami</span>
            <h2>Visi & Misi</h2>
            <p>Fondasi kami dalam melayani bangsa dan negara dengan profesional dan berintegritas.</p>
            <div class="section-divider"></div>
        </div>
        <div class="vm-grid fade-up">
            <div class="vm-card">
                <h3>Visi Kami</h3>
                <p>{{ $vision }}</p>
            </div>
            <div class="vm-card">
                <h3>Misi Kami</h3>
                <ul class="mission-list">
                    @foreach($mission as $point)
                    <li>{{ $point }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ===== BERITA ===== --}}
<section class="news-section" id="berita">
    <div class="section-wrap">
        <div class="section-header fade-up">
            <span class="eyebrow">Informasi Terkini</span>
            <h2>Berita Terbaru</h2>
            <p>Informasi terkini seputar kegiatan dan layanan kepolisian Gunungkidul.</p>
            <div class="section-divider"></div>
        </div>
        <div class="news-grid fade-up">
            @forelse($news as $item)
            <a href="{{ route('news.show', $item['slug']) }}" class="news-card">
                <div class="news-image">
                    @if(!empty($item['images']))
                        <div class="news-slideshow" data-slideshow>
                            @foreach($item['images'] as $index => $image)
                            <div class="news-slide {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ $image }}" alt="{{ $item['title'] }}">
                            </div>
                            @endforeach
                            @if(count($item['images']) > 1)
                            <div class="slideshow-dots">
                                @foreach($item['images'] as $index => $image)
                                <span class="dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    @elseif(!empty($item['icon']))
                        <img src="{{ $item['icon'] }}" alt="{{ $item['title'] }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div class="news-icon-placeholder">📰</div>
                    @endif
                </div>
                <div class="news-body">
                    <span class="news-date">{{ $item['date'] }}</span>
                    <div class="news-title">{{ $item['title'] }}</div>
                    <p class="news-excerpt">{{ $item['excerpt'] }}</p>
                    <span class="news-readmore">Selengkapnya →</span>
                </div>
            </a>
            @empty
            <p style="color: var(--muted); font-size: 14px; grid-column: 1/-1;">
                Belum ada berita yang dipublikasikan.
            </p>
            @endforelse
        </div>
    </div>
</section>

{{-- ===== SOSIAL MEDIA ===== --}}
<section class="social-section" id="informasi">
    <div class="section-wrap">
        <div class="section-header fade-up">
            <span class="eyebrow">Media Sosial</span>
            <h2>Ikuti Kami</h2>
            <p>Tetap terhubung dan dapatkan informasi terbaru melalui media sosial resmi kami.</p>
            <div class="section-divider"></div>
        </div>
        <div class="social-grid fade-up">
            @forelse($socialMedia as $sm)
            <a href="{{ $sm->url }}" target="_blank" rel="noopener" class="social-card">
                <div class="social-icon-wrap">
                    @switch(strtolower($sm->name))
                        @case('instagram')
                            <svg viewBox="0 0 48 48" width="36" height="36" xmlns="http://www.w3.org/2000/svg">
                                <defs><radialGradient id="ig-grad-{{ $loop->index }}" cx="30%" cy="107%" r="150%">
                                    <stop offset="0%" stop-color="#ffd600"/>
                                    <stop offset="25%" stop-color="#ff7a00"/>
                                    <stop offset="50%" stop-color="#ff0069"/>
                                    <stop offset="100%" stop-color="#7638fa"/>
                                </radialGradient></defs>
                                <rect width="48" height="48" rx="12" fill="url(#ig-grad-{{ $loop->index }})"/>
                                <rect x="13" y="13" width="22" height="22" rx="6" fill="none" stroke="white" stroke-width="2.5"/>
                                <circle cx="24" cy="24" r="5.5" fill="none" stroke="white" stroke-width="2.5"/>
                                <circle cx="34" cy="14" r="1.6" fill="white"/>
                            </svg>
                            @break
                        @case('facebook')
                            <svg viewBox="0 0 48 48" width="36" height="36" xmlns="http://www.w3.org/2000/svg">
                                <rect width="48" height="48" rx="12" fill="#1877F2"/>
                                <path d="M32 24h-5v-3c0-1.4.7-2 2-2h3v-5h-4c-4 0-6 2.5-6 6v4h-4v5h4v13h5V29h3.5l.5-5z" fill="white"/>
                            </svg>
                            @break
                        @case('youtube')
                            <svg viewBox="0 0 48 48" width="36" height="36" xmlns="http://www.w3.org/2000/svg">
                                <rect width="48" height="48" rx="12" fill="#FF0000"/>
                                <path d="M38.5 17.5s-.4-2.5-1.6-3.6c-1.5-1.6-3.2-1.6-4-1.7C28.8 12 24 12 24 12s-4.8 0-8.9.2c-.8.1-2.5.1-4 1.7-1.2 1.1-1.6 3.6-1.6 3.6S9 20.3 9 23.1v2.6c0 2.8.5 5.6.5 5.6s.4 2.5 1.6 3.6c1.5 1.6 3.5 1.5 4.4 1.7C18.5 37 24 37 24 37s4.8 0 8.9-.4c.8-.1 2.5-.1 4-1.7 1.2-1.1 1.6-3.6 1.6-3.6s.5-2.8.5-5.6v-2.6c0-2.8-.5-5.6-.5-5.6zm-15.9 11.4v-9.8l8.6 4.9-8.6 4.9z" fill="white"/>
                            </svg>
                            @break
                        @case('tiktok')
                            <svg viewBox="0 0 48 48" width="36" height="36" xmlns="http://www.w3.org/2000/svg">
                                <rect width="48" height="48" rx="12" fill="#010101"/>
                                <path d="M34 18.5c-1.8-.5-3.2-1.7-4-3.3v14.3c0 3.5-2.8 6.3-6.3 6.3s-6.3-2.8-6.3-6.3 2.8-6.3 6.3-6.3c.3 0 .7 0 1 .1v4.2c-.3-.1-.6-.1-1-.1-1.4 0-2.5 1.1-2.5 2.5s1.1 2.5 2.5 2.5 2.5-1.1 2.5-2.5V11h4c.4 2.8 2.6 4.9 5.3 5.1v2.4h-1.5z" fill="white"/>
                            </svg>
                            @break
                        @case('twitter/x')
                        @case('twitter')
                        @case('x')
                            <svg viewBox="0 0 48 48" width="36" height="36" xmlns="http://www.w3.org/2000/svg">
                                <rect width="48" height="48" rx="12" fill="#000000"/>
                                <path d="M26.37 21.85L34.2 13h-1.85l-6.82 7.88L20.27 13H14l8.22 11.93L14 35.5h1.85l7.19-8.31 5.74 8.31H35L26.37 21.85zm-2.55 2.95l-.83-1.19L16.52 14.4h2.86l5.35 7.65.83 1.19 6.95 9.93h-2.86l-5.83-8.37z" fill="white"/>
                            </svg>
                            @break
                        @case('whatsapp')
                            <svg viewBox="0 0 48 48" width="36" height="36" xmlns="http://www.w3.org/2000/svg">
                                <rect width="48" height="48" rx="12" fill="#25D366"/>
                                <path d="M24 11C16.82 11 11 16.82 11 24c0 2.27.61 4.4 1.67 6.24L11 37l6.95-1.64A13 13 0 0 0 24 37c7.18 0 13-5.82 13-13S31.18 11 24 11zm6.41 17.29c-.27.76-1.57 1.45-2.14 1.54-.55.09-1.23.13-1.99-.12-.46-.15-1.05-.35-1.8-.68-3.17-1.37-5.23-4.56-5.39-4.77-.16-.21-1.29-1.72-1.29-3.28s.82-2.33 1.11-2.65c.29-.32.63-.4.84-.4l.6.01c.19 0 .45-.07.7.54l1.01 2.46c.09.22.15.48.01.77l-.38.56-.56.62c.18.3.74 1.14 1.6 1.86 1.1.93 2.02 1.22 2.3 1.36.29.14.46.12.63-.07l.86-1.01c.22-.28.44-.22.74-.13l2.33.99c.55.22.55.44.55.63 0 .19-.02 1.01-.29 1.77z" fill="white"/>
                            </svg>
                            @break
                        @default
                            <svg viewBox="0 0 48 48" width="36" height="36" xmlns="http://www.w3.org/2000/svg">
                                <rect width="48" height="48" rx="12" fill="#2563eb"/>
                                <path d="M24 12C17.37 12 12 17.37 12 24s5.37 12 12 12 12-5.37 12-12S30.63 12 24 12zm0 2c2.28 0 4.38.76 6.06 2.03l-15.03 15.03A9.94 9.94 0 0 1 14 24c0-5.52 4.48-10 10-10zm0 20c-2.28 0-4.38-.76-6.06-2.03l15.03-15.03A9.94 9.94 0 0 1 34 24c0 5.52-4.48 10-10 10z" fill="white"/>
                            </svg>
                    @endswitch
                </div>
                <div>
                    <div class="social-name">{{ $sm->name }}</div>
                    <div class="social-handle">{{ $sm->handle }}</div>
                </div>
            </a>
            @empty
            <p style="color: var(--muted); font-size: 14px; grid-column: 1/-1;">
                Belum ada media sosial yang ditambahkan.
            </p>
            @endforelse
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// ===== HERO SLIDER =====
(function () {
    const wrapper     = document.getElementById('heroSlidesWrapper');
    const slides      = wrapper.querySelectorAll('.hero-slide');
    const dotsWrapper = document.getElementById('heroDots');
    const captionEl   = document.getElementById('heroCaption');
    const progressEl  = document.getElementById('heroProgress');
    const prevBtn     = document.getElementById('heroPrev');
    const nextBtn     = document.getElementById('heroNext');
    const INTERVAL = 5000;
    let current = 0, timer = null;
    if (!slides.length) return;
    slides.forEach((_, i) => {
        const dot = document.createElement('span');
        dot.className = 'hero-dot' + (i === 0 ? ' active' : '');
        dot.addEventListener('click', () => goTo(i, true));
        dotsWrapper.appendChild(dot);
    });
    const getDots = () => dotsWrapper.querySelectorAll('.hero-dot');
    function goTo(index, resetTimer = false) {
        slides[current].classList.remove('active');
        getDots()[current].classList.remove('active');
        current = ((index % slides.length) + slides.length) % slides.length;
        slides[current].classList.add('active');
        getDots()[current].classList.add('active');
        const caption = slides[current].dataset.caption || '';
        captionEl.textContent = caption;
        captionEl.classList.remove('visible');
        requestAnimationFrame(() => requestAnimationFrame(() => captionEl.classList.add('visible')));
        startProgress();
        if (resetTimer) restartTimer();
    }
    function startProgress() {
        progressEl.style.transition = 'none'; progressEl.style.width = '0%';
        void progressEl.offsetWidth;
        progressEl.style.transition = `width ${INTERVAL}ms linear`; progressEl.style.width = '100%';
    }
    function pauseProgress() {
        const w = getComputedStyle(progressEl).width;
        progressEl.style.transition = 'none'; progressEl.style.width = w;
    }
    function startTimer()   { timer = setInterval(() => goTo(current + 1), INTERVAL); }
    function stopTimer()    { clearInterval(timer); }
    function restartTimer() { stopTimer(); startTimer(); }
    prevBtn.addEventListener('click', () => goTo(current - 1, true));
    nextBtn.addEventListener('click', () => goTo(current + 1, true));
    const heroEl = document.querySelector('.hero');
    heroEl.addEventListener('mouseenter', () => { stopTimer(); pauseProgress(); });
    heroEl.addEventListener('mouseleave', () => { startProgress(); restartTimer(); });
    let touchStartX = 0;
    heroEl.addEventListener('touchstart', e => { touchStartX = e.changedTouches[0].clientX; }, { passive: true });
    heroEl.addEventListener('touchend', e => {
        const diff = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) diff > 0 ? goTo(current + 1, true) : goTo(current - 1, true);
    }, { passive: true });
    document.addEventListener('keydown', e => {
        if (e.key === 'ArrowLeft')  goTo(current - 1, true);
        if (e.key === 'ArrowRight') goTo(current + 1, true);
    });
    goTo(0); startTimer();
})();

// ===== NEWS SLIDESHOW =====
function initNewsSlideshow() {
    document.querySelectorAll('[data-slideshow]').forEach(slideshow => {
        const slides = slideshow.querySelectorAll('.news-slide');
        const dots   = slideshow.querySelectorAll('.dot');
        let current  = 0, interval;
        function showSlide(index) {
            slides.forEach(s => s.classList.remove('active'));
            dots.forEach(d => d.classList.remove('active'));
            current = ((index % slides.length) + slides.length) % slides.length;
            slides[current].classList.add('active');
            if (dots[current]) dots[current].classList.add('active');
        }
        function start() { interval = setInterval(() => showSlide(current + 1), 3000); }
        function stop()  { clearInterval(interval); }
        dots.forEach((dot, i) => {
            dot.addEventListener('click', e => { e.preventDefault(); stop(); showSlide(i); start(); });
        });
        slideshow.addEventListener('mouseenter', stop);
        slideshow.addEventListener('mouseleave', start);
        if (slides.length > 1) start();
    });
}
document.addEventListener('DOMContentLoaded', initNewsSlideshow);

// ===== WEATHER =====
(function () {
    const LAT = -7.9408, LON = 110.5993, TZ = 'Asia%2FJakarta';
    const WMO = {
        0:{e:'☀️',d:'Cerah'}, 1:{e:'🌤️',d:'Umumnya Cerah'}, 2:{e:'⛅',d:'Berawan Sebagian'},
        3:{e:'☁️',d:'Berawan'}, 45:{e:'🌫️',d:'Berkabut'}, 48:{e:'🌫️',d:'Kabut Beku'},
        51:{e:'🌦️',d:'Gerimis Ringan'}, 53:{e:'🌦️',d:'Gerimis Sedang'}, 55:{e:'🌧️',d:'Gerimis Lebat'},
        61:{e:'🌧️',d:'Hujan Ringan'}, 63:{e:'🌧️',d:'Hujan Sedang'}, 65:{e:'🌧️',d:'Hujan Lebat'},
        80:{e:'🌦️',d:'Hujan Lokal'}, 81:{e:'🌧️',d:'Hujan Lokal Sedang'}, 82:{e:'⛈️',d:'Hujan Lokal Lebat'},
        95:{e:'⛈️',d:'Hujan Petir'}, 96:{e:'⛈️',d:'Petir + Es'}, 99:{e:'⛈️',d:'Petir + Es Besar'},
    };
    const HARI = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];
    function wmo(c) { return WMO[c] || {e:'🌡️',d:'—'}; }
    const API = 'https://api.open-meteo.com/v1/forecast?latitude='+LAT+'&longitude='+LON+'&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m,precipitation&daily=weather_code,temperature_2m_max,temperature_2m_min,precipitation_probability_max&timezone='+TZ+'&forecast_days=7';
    const $icon=document.getElementById('wxIcon'), $temp=document.getElementById('wxTemp'),
          $desc=document.getElementById('wxDesc'), $hum=document.getElementById('wxHum'),
          $wnd=document.getElementById('wxWnd'),   $prcp=document.getElementById('wxPrcp'),
          $days=document.getElementById('wxDays'), $btn=document.getElementById('wxRefresh');
    async function load() {
        $btn.classList.add('spinning');
        try {
            const r = await fetch(API); if (!r.ok) throw new Error(r.status);
            const d = await r.json(), c = d.current, dl = d.daily, w = wmo(c.weather_code);
            $icon.textContent = w.e; $temp.textContent = Math.round(c.temperature_2m)+'°C'; $desc.textContent = w.d;
            $hum.textContent  = '💧 '+c.relative_humidity_2m+'%';
            $wnd.textContent  = '💨 '+Math.round(c.wind_speed_10m)+' km/h';
            $prcp.textContent = '☔ '+c.precipitation+' mm';
            $days.innerHTML = '';
            dl.time.forEach((dt, i) => {
                const isToday = i===0, day = new Date(dt+'T00:00:00'), dw = wmo(dl.weather_code[i]);
                const hi = Math.round(dl.temperature_2m_max[i]), lo = Math.round(dl.temperature_2m_min[i]);
                const p = document.createElement('div');
                p.className = 'wx-bar-day'+(isToday?' wx-today-pill':'');
                p.title = dw.d+' · Hujan: '+(dl.precipitation_probability_max[i]??0)+'%';
                p.innerHTML = '<span class="wx-bar-day-name">'+(isToday?'Hari ini':HARI[day.getDay()])+'</span>'
                            + '<span class="wx-bar-day-icon">'+dw.e+'</span>'
                            + '<span class="wx-bar-day-temps">'+hi+'° <span class="wx-bar-day-lo">/ '+lo+'°</span></span>';
                $days.appendChild(p);
            });
        } catch(e) { $icon.textContent='⚠️'; $temp.textContent='--'; $desc.textContent='Gagal memuat'; }
        finally { $btn.classList.remove('spinning'); }
    }
    $btn.addEventListener('click', load); load(); setInterval(load, 10*60*1000);
})();

// ===== FADE UP OBSERVER =====
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.12, rootMargin: '0px 0px -80px 0px' });
document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

// ===== SMOOTH SCROLL =====
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});
</script>
@endpush