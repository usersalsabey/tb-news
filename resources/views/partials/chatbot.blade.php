{{-- ============================================================
     CHATBOT WIDGET — Polres Gunungkidul
     Cara pakai: @include('partials.chatbot') sebelum </body>
     di layouts/app.blade.php

     Pastikan di routes/web.php sudah ada:
     Route::post('/chatbot', [ChatbotController::class, 'chat'])->name('chatbot.chat');
     ============================================================ --}}

<style>
/* ===== CHAT BUBBLE TRIGGER ===== */
.cb-trigger {
    position: fixed; bottom: 28px; right: 28px; z-index: 9999;
    width: 58px; height: 58px; border-radius: 50%;
    background: linear-gradient(135deg, #1e4da1, #2563eb);
    box-shadow: 0 8px 24px rgba(37,99,235,0.45);
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px;
}
.cb-trigger .cb-notif {
    position: absolute; top: 2px; right: 2px;
    width: 14px; height: 14px; background: #f0a500;
    border-radius: 50%; border: 2px solid #fff;
}

/* ===== CHAT WINDOW ===== */
.cb-window {
    position: fixed; bottom: 100px; right: 28px; z-index: 9998;
    width: 360px; max-height: 560px;
    background: #ffffff; border-radius: 20px;
    box-shadow: 0 24px 64px rgba(10,22,40,0.18);
    display: flex; flex-direction: column; overflow: hidden;
    opacity: 0; pointer-events: none;
    border: 1px solid #e2e8f0;
    transition: opacity 0.2s ease;
}
.cb-window.cb-open { opacity: 1; pointer-events: all; }

/* Header */
.cb-header {
    background: linear-gradient(135deg, #0a1628, #1a3a6e);
    padding: 16px 18px; display: flex; align-items: center; gap: 12px;
    flex-shrink: 0;
}
.cb-avatar {
    width: 40px; height: 40px; border-radius: 50%;
    background: rgba(37,99,235,0.3); border: 2px solid rgba(37,99,235,0.5);
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.cb-header-info { flex: 1; }
.cb-header-name { font-size: 14px; font-weight: 700; color: #fff; font-family: 'Plus Jakarta Sans', sans-serif; }
.cb-header-status {
    font-size: 11px; color: rgba(255,255,255,0.5);
    display: flex; align-items: center; gap: 5px; margin-top: 2px;
}
.cb-header-status::before {
    content: ''; width: 7px; height: 7px; border-radius: 50%;
    background: #22c55e; display: inline-block;
}
.cb-close {
    background: none; border: none; color: rgba(255,255,255,0.5);
    cursor: pointer; padding: 4px; border-radius: 6px;
    font-size: 18px; line-height: 1;
}
.cb-close:hover { color: #fff; }

/* Quick topics */
.cb-topics {
    padding: 12px 14px 8px; background: #f8fafc;
    border-bottom: 1px solid #e2e8f0; flex-shrink: 0;
    display: flex; gap: 6px; flex-wrap: wrap;
}
.cb-topic {
    font-size: 11px; font-weight: 600; padding: 5px 11px; border-radius: 100px;
    border: 1px solid #e2e8f0; background: #fff; color: #4b5563;
    cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif;
    white-space: nowrap; transition: background 0.15s, color 0.15s, border-color 0.15s;
}
.cb-topic:hover { background: #eff6ff; color: #2563eb; border-color: #bfdbfe; }

/* Messages */
.cb-messages {
    flex: 1; overflow-y: auto; padding: 16px 14px;
    display: flex; flex-direction: column; gap: 10px;
    scrollbar-width: thin; scrollbar-color: #e2e8f0 transparent;
}
.cb-messages::-webkit-scrollbar { width: 4px; }
.cb-messages::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }

.cb-msg { display: flex; gap: 8px; align-items: flex-end; }
.cb-msg.cb-bot  { justify-content: flex-start; }
.cb-msg.cb-user { justify-content: flex-end; }

.cb-msg-avatar {
    width: 28px; height: 28px; border-radius: 50%;
    background: linear-gradient(135deg,#1a3a6e,#2563eb);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; flex-shrink: 0;
}

.cb-bubble {
    max-width: 88%; padding: 10px 14px; border-radius: 16px;
    font-size: 13px; line-height: 1.7; font-family: 'Plus Jakarta Sans', sans-serif;
    word-break: break-word;
}
.cb-bot  .cb-bubble { background: #f1f5f9; color: #1a1f2e; border-bottom-left-radius: 4px; max-width: 92%; }
.cb-user .cb-bubble { background: linear-gradient(135deg,#1e4da1,#2563eb); color: #fff; border-bottom-right-radius: 4px; max-width: 82%; }

/* ===== MODE SELECTION (Online / Offline) ===== */
.cb-mode-opts {
    display: flex; gap: 7px; flex-wrap: wrap; margin-top: 10px;
}
.cb-mode-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 7px 14px; border-radius: 100px;
    font-size: 12px; font-weight: 700; cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif;
    border: 1.5px solid; transition: background 0.15s, transform 0.1s;
    white-space: nowrap;
}
.cb-mode-btn:active { transform: scale(0.97); }
.cb-mode-btn:disabled { opacity: 0.45; cursor: not-allowed; }

.cb-mode-btn.cb-online {
    border-color: #2563eb; color: #1d4ed8; background: #eff6ff;
}
.cb-mode-btn.cb-online:hover:not(:disabled) { background: #dbeafe; }

.cb-mode-btn.cb-offline {
    border-color: #16a34a; color: #15803d; background: #f0fdf4;
}
.cb-mode-btn.cb-offline:hover:not(:disabled) { background: #dcfce7; }

/* Label kecil di atas pilihan mode */
.cb-mode-label {
    font-size: 12px; color: #64748b; margin-bottom: 2px;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

/* Toast notifikasi "Disalin!" */
.cb-toast {
    position: fixed; bottom: 100px; right: 28px; z-index: 99999;
    background: #1e293b; color: #fff;
    font-size: 12px; font-family: 'Plus Jakarta Sans', sans-serif;
    padding: 7px 14px; border-radius: 8px;
    opacity: 0; pointer-events: none;
    transition: opacity 0.2s;
}
.cb-toast.cb-toast-show { opacity: 1; }

/* Link URL biasa */
.cb-bot .cb-bubble a.cb-url {
    color: #1d4ed8;
    text-decoration: underline;
    text-underline-offset: 2px;
    font-weight: 600;
    word-break: break-all;
}
.cb-bot .cb-bubble a.cb-url:hover { color: #1e40af; }

/* Chip copy — nomor telepon & email */
.cb-bot .cb-bubble .cb-copy {
    display: inline-flex; align-items: center; gap: 4px;
    background: #e0f2fe; color: #0369a1;
    border: 1px solid #bae6fd; border-radius: 6px;
    padding: 2px 8px; font-size: 12px; font-weight: 600;
    cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif;
    text-decoration: none; white-space: nowrap;
    vertical-align: middle;
}
.cb-bot .cb-bubble .cb-copy:hover { background: #bae6fd; }

/* Loading state */
.cb-loading .cb-bubble {
    color: #94a3b8;
    font-style: italic;
    font-size: 12px;
}

/* Error state */
.cb-error .cb-bubble {
    background: #fef2f2;
    color: #b91c1c;
    border: 1px solid #fecaca;
}

/* Input */
.cb-input-wrap {
    padding: 12px 14px; border-top: 1px solid #e2e8f0;
    display: flex; gap: 8px; align-items: center; flex-shrink: 0;
    background: #fff;
}
.cb-input {
    flex: 1; border: 1px solid #e2e8f0; border-radius: 12px;
    padding: 9px 14px; font-size: 13px; outline: none;
    font-family: 'Plus Jakarta Sans', sans-serif; color: #1a1f2e;
    transition: border-color 0.15s;
}
.cb-input:focus { border-color: #2563eb; }
.cb-input::placeholder { color: #94a3b8; }
.cb-input:disabled { background: #f8fafc; }

.cb-send {
    width: 38px; height: 38px; border-radius: 10px; border: none;
    background: linear-gradient(135deg,#1e4da1,#2563eb); color: #fff;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; transition: opacity 0.15s;
}
.cb-send:disabled { opacity: 0.5; cursor: not-allowed; }
.cb-send svg { width: 16px; height: 16px; }

@media (max-width: 420px) {
    .cb-window  { width: calc(100vw - 32px); right: 16px; bottom: 90px; }
    .cb-trigger { right: 16px; bottom: 16px; }
}
</style>

{{-- TRIGGER BUTTON --}}
<button class="cb-trigger" id="cbTrigger" title="Tanya Kami">
    💬
    <span class="cb-notif"></span>
</button>

{{-- CHAT WINDOW --}}
<div class="cb-window" id="cbWindow">
    <div class="cb-header">
        <div class="cb-avatar">👮</div>
        <div class="cb-header-info">
            <div class="cb-header-name">Asisten Polres Gunungkidul</div>
            <div class="cb-header-status">Online • Siap membantu</div>
        </div>
        <button class="cb-close" id="cbClose">✕</button>
    </div>

    <div class="cb-topics" id="cbTopics">
        {{-- data-mode="split" → tampilkan pilihan Online / Datang Langsung --}}
        {{-- data-mode="direct" → langsung kirim tanpa split --}}

        <button class="cb-topic"
            data-mode="split"
            data-label="SKCK"
            data-online="Bagaimana cara membuat SKCK secara online lewat aplikasi?"
            data-offline="Bagaimana cara membuat SKCK dengan datang langsung ke kantor Polres?">
            📋 SKCK
        </button>

        <button class="cb-topic"
            data-mode="split"
            data-label="SIM"
            data-online="Bagaimana cara membuat atau memperpanjang SIM secara online lewat aplikasi Digital Korlantas?"
            data-offline="Bagaimana cara membuat atau memperpanjang SIM dengan datang langsung ke SATPAS?">
            🚗 SIM
        </button>

        <button class="cb-topic"
            data-mode="split"
            data-label="Penerimaan Polri"
            data-online="Bagaimana cara mendaftar penerimaan Polri secara online?"
            data-offline="Bagaimana alur dan syarat penerimaan Polri jika datang langsung ke Polres?">
            👮 Penerimaan
        </button>

        <button class="cb-topic"
            data-mode="split"
            data-label="WBS / Laporan Online"
            data-online="Bagaimana cara melapor atau mengadukan melalui WBS Online atau Dumas Polri?"
            data-offline="Bagaimana cara melaporkan pengaduan dengan datang langsung ke Polres Gunungkidul?">
            🔒 WBS
        </button>

        <button class="cb-topic"
            data-mode="split"
            data-label="SAMSAT / Pajak Kendaraan"
            data-online="Bagaimana cara bayar pajak kendaraan lewat aplikasi SAMSAT Digital secara online?"
            data-offline="Bagaimana cara bayar pajak kendaraan dengan datang langsung ke kantor SAMSAT?">
            🏍️ SAMSAT
        </button>

        <button class="cb-topic"
            data-mode="direct"
            data-q="Apa itu Perpusdata Polres dan bagaimana cara mengaksesnya?">
            📂 Perpusdata
        </button>

        <button class="cb-topic"
            data-mode="direct"
            data-q="Saya ingin menyampaikan kritik dan saran untuk Polres Gunungkidul.">
            💬 Kritik &amp; Saran
        </button>

        <button class="cb-topic"
            data-mode="direct"
            data-q="Dimana alamat dan lokasi Polres Gunungkidul?">
            📍 Lokasi
        </button>
    </div>

    <div class="cb-messages" id="cbMessages"></div>

    <div class="cb-input-wrap">
        <input
            class="cb-input" id="cbInput" type="text"
            placeholder="Ketik pertanyaan kamu…"
            maxlength="300" autocomplete="off"
        >
        <button class="cb-send" id="cbSend">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"/>
                <polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </svg>
        </button>
    </div>
</div>

{{-- Toast copy --}}
<div class="cb-toast" id="cbToast">✓ Disalin!</div>

<script>
(function () {
    const $win    = document.getElementById('cbWindow');
    const $trig   = document.getElementById('cbTrigger');
    const $close  = document.getElementById('cbClose');
    const $msgs   = document.getElementById('cbMessages');
    const $input  = document.getElementById('cbInput');
    const $send   = document.getElementById('cbSend');
    const $topics = document.getElementById('cbTopics');
    const $toast  = document.getElementById('cbToast');

    let conversationHistory = [];
    let isLoading  = false;
    let opened     = false;
    let toastTimer = null;

    // ── Toast "Disalin!" ──
    function showToast(msg) {
        $toast.textContent = '✓ ' + msg + ' disalin!';
        $toast.classList.add('cb-toast-show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => $toast.classList.remove('cb-toast-show'), 2000);
    }

    // ── Copy to clipboard ──
    function copyText(text) {
        navigator.clipboard?.writeText(text).catch(() => {
            const el = document.createElement('textarea');
            el.value = text; el.style.position = 'fixed'; el.style.opacity = '0';
            document.body.appendChild(el); el.select();
            document.execCommand('copy'); document.body.removeChild(el);
        });
    }

    // ── Delegasi klik pada chip copy (nomor & email) ──
    $msgs.addEventListener('click', e => {
        const chip = e.target.closest('.cb-copy');
        if (!chip) return;
        e.preventDefault();
        const value = chip.dataset.copy;
        copyText(value);
        showToast(value);
    });

    // ── Buka / tutup window ──
    function toggle() {
        opened = !opened;
        $win.classList.toggle('cb-open', opened);
        if (opened && $msgs.children.length === 0) {
            botSay('Halo! Selamat datang di Asisten Polres Gunungkidul.\n\nSaya siap membantu informasi seputar SKCK, SIM, Penerimaan Polri, WBS, SAMSAT, Perpusdata, atau layanan lainnya.\n\nSilakan pilih topik di atas atau ketik pertanyaan Anda.');
            $trig.querySelector('.cb-notif')?.remove();
        }
        if (opened) $input.focus();
    }

    $trig.addEventListener('click', toggle);
    $close.addEventListener('click', toggle);

    // ── Quick topic buttons ──
    $topics.addEventListener('click', e => {
        const btn = e.target.closest('.cb-topic');
        if (!btn || isLoading) return;

        const mode = btn.dataset.mode;

        if (mode === 'split') {
            // Tampilkan pilihan Online / Datang Langsung di dalam chat
            const label   = btn.dataset.label   ?? 'layanan ini';
            const onlineQ  = btn.dataset.online  ?? '';
            const offlineQ = btn.dataset.offline ?? '';
            userSay(label);
            showModeOptions(label, onlineQ, offlineQ);
        } else {
            // Langsung kirim tanpa split
            handleInput(btn.dataset.q ?? '');
        }
    });

    // ── Send ──
    $send.addEventListener('click', () => handleInput($input.value));
    $input.addEventListener('keydown', e => {
        if (e.key === 'Enter' && !isLoading) handleInput($input.value);
    });

    // ── Tampilkan pilihan mode Online / Datang Langsung ──
    function showModeOptions(label, onlineQ, offlineQ) {
        const div = document.createElement('div');
        div.className = 'cb-msg cb-bot';

        // Buat bubble dulu, lalu pasang tombol via JS (aman, tanpa innerHTML injection)
        const avatar = document.createElement('div');
        avatar.className = 'cb-msg-avatar';
        avatar.textContent = '👮';

        const bubble = document.createElement('div');
        bubble.className = 'cb-bubble';

        const labelEl = document.createElement('div');
        labelEl.className = 'cb-mode-label';
        labelEl.textContent = 'Pilih cara akses layanan ' + label + ':';

        const optsEl = document.createElement('div');
        optsEl.className = 'cb-mode-opts';

        const btnOnline = document.createElement('button');
        btnOnline.className = 'cb-mode-btn cb-online';
        btnOnline.textContent = '🌐 Online (Aplikasi)';

        const btnOffline = document.createElement('button');
        btnOffline.className = 'cb-mode-btn cb-offline';
        btnOffline.textContent = '🏢 Datang Langsung';

        optsEl.appendChild(btnOnline);
        optsEl.appendChild(btnOffline);
        bubble.appendChild(labelEl);
        bubble.appendChild(optsEl);
        div.appendChild(avatar);
        div.appendChild(bubble);
        $msgs.appendChild(div);
        scrollBottom();

        function lockButtons() {
            btnOnline.disabled  = true;
            btnOffline.disabled = true;
        }

        btnOnline.addEventListener('click', () => {
            if (isLoading) return;
            lockButtons();
            handleInput(onlineQ);
        });

        btnOffline.addEventListener('click', () => {
            if (isLoading) return;
            lockButtons();
            handleInput(offlineQ);
        });
    }

    // ── Handle input utama ──
    async function handleInput(text) {
        text = text.trim();
        if (!text || isLoading) return;

        // Hanya tambahkan pesan user jika bukan dari mode-split
        // (mode-split sudah render via userSay sebelum showModeOptions)
        const fromInput = $input.value.trim() === text;
        if (fromInput) userSay(text);
        $input.value = '';

        setLoading(true);
        const loadingEl = showLoading();

        try {
            const res = await fetch('{{ route("chatbot.chat") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    message: text,
                    history: conversationHistory.slice(-8),
                }),
            });

            const data  = await res.json();
            const reply = data.reply ?? 'Maaf, terjadi kesalahan. Silakan coba lagi.';

            loadingEl.remove();
            botSay(reply);

            conversationHistory.push({ role: 'user',      content: text  });
            conversationHistory.push({ role: 'assistant', content: reply });

            if (conversationHistory.length > 20) {
                conversationHistory = conversationHistory.slice(-20);
            }

        } catch (err) {
            loadingEl.remove();
            errorSay('Koneksi gagal. Pastikan internet Anda aktif dan coba lagi, atau hubungi kami di 0851-3375-0875.');
        } finally {
            setLoading(false);
        }
    }

    // ── Render: pesan user ──
    function userSay(text) {
        const div = document.createElement('div');
        div.className = 'cb-msg cb-user';
        div.innerHTML = `<div class="cb-bubble">${escHtml(text)}</div>`;
        $msgs.appendChild(div);
        scrollBottom();
    }

    // ── Render: pesan bot ──
    function botSay(text) {
        const div = document.createElement('div');
        div.className = 'cb-msg cb-bot';
        div.innerHTML = `<div class="cb-msg-avatar">👮</div><div class="cb-bubble">${formatBotText(text)}</div>`;
        $msgs.appendChild(div);
        scrollBottom();
    }

    // ── Render: pesan error ──
    function errorSay(text) {
        const div = document.createElement('div');
        div.className = 'cb-msg cb-bot cb-error';
        div.innerHTML = `<div class="cb-msg-avatar">👮</div><div class="cb-bubble">${escHtml(text)}</div>`;
        $msgs.appendChild(div);
        scrollBottom();
    }

    // ── Loading ──
    function showLoading() {
        const div = document.createElement('div');
        div.className = 'cb-msg cb-bot cb-loading';
        div.innerHTML = `<div class="cb-msg-avatar">👮</div><div class="cb-bubble">Sedang memproses...</div>`;
        $msgs.appendChild(div);
        scrollBottom();
        return div;
    }

    // ── Disable input saat loading ──
    function setLoading(state) {
        isLoading       = state;
        $input.disabled = state;
        $send.disabled  = state;
    }

    // ── Format Bot Text ──
    function formatBotText(text) {
        const PATTERN = new RegExp(
            '(https?:\\/\\/[^\\s]+)' +
            '|((?:bit\\.ly|s\\.id|tinyurl\\.com|rb\\.gy)\\/[^\\s.,);:]+)' +
            '|([a-zA-Z0-9._%+\\-]+@[a-zA-Z0-9.\\-]+\\.[a-zA-Z]{2,})' +
            '|(\\+?62[\\s\\-]?\\d{3}[\\s\\-]?\\d{3,4}[\\s\\-]?\\d{3,5}|0\\d{2,3}[\\s\\-]?\\d{3,4}[\\s\\-]?\\d{3,5})',
            'g'
        );

        let result    = '';
        let lastIndex = 0;
        let match;

        while ((match = PATTERN.exec(text)) !== null) {
            result += escHtml(text.slice(lastIndex, match.index));

            const [full, url, shortlink, email, phone] = match;

            if (url) {
                const cleaned  = url.replace(/[.,);:\]]+$/, '');
                const trailing = url.slice(cleaned.length);
                result += `<a class="cb-url" href="${escHtml(cleaned)}" target="_blank" rel="noopener noreferrer">${escHtml(cleaned)}</a>${escHtml(trailing)}`;
            } else if (shortlink) {
                const cleaned = shortlink.replace(/[.,);:\]]+$/, '');
                result += `<a class="cb-url" href="https://${escHtml(cleaned)}" target="_blank" rel="noopener noreferrer">https://${escHtml(cleaned)}</a>`;
            } else if (email) {
                result += `<span class="cb-copy" data-copy="${escHtml(email)}" title="Klik untuk menyalin">✉ ${escHtml(email)}</span>`;
            } else if (phone) {
                const clean = phone.replace(/[\s\-]/g, '');
                result += `<span class="cb-copy" data-copy="${clean}" title="Klik untuk menyalin">📞 ${escHtml(phone)}</span>`;
            }

            lastIndex = match.index + full.length;
        }

        result += escHtml(text.slice(lastIndex));
        return result.replace(/\n/g, '<br>');
    }

    function scrollBottom() { $msgs.scrollTop = $msgs.scrollHeight; }

    function escHtml(s) {
        return String(s)
            .replace(/&/g,  '&amp;')
            .replace(/</g,  '&lt;')
            .replace(/>/g,  '&gt;')
            .replace(/"/g,  '&quot;');
    }

})();
</script>