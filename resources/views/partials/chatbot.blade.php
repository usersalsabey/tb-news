{{-- ============================================================
     CHATBOT WIDGET — Polres Gunungkidul
     Cara pakai: @include('partials.chatbot') sebelum </body>
     di layouts/app.blade.php
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
    transition: transform 0.25s, box-shadow 0.25s;
    font-size: 24px;
}
.cb-trigger:hover { transform: translateY(-3px) scale(1.05); box-shadow: 0 14px 32px rgba(37,99,235,0.55); }
.cb-trigger .cb-notif {
    position: absolute; top: 2px; right: 2px;
    width: 14px; height: 14px; background: #f0a500;
    border-radius: 50%; border: 2px solid #fff;
    animation: cbPulse 2s ease-in-out infinite;
}
@keyframes cbPulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.25)} }

/* ===== CHAT WINDOW ===== */
.cb-window {
    position: fixed; bottom: 100px; right: 28px; z-index: 9998;
    width: 360px; max-height: 560px;
    background: #ffffff; border-radius: 20px;
    box-shadow: 0 24px 64px rgba(10,22,40,0.18);
    display: flex; flex-direction: column; overflow: hidden;
    transform: scale(0.9) translateY(20px); opacity: 0; pointer-events: none;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    border: 1px solid #e2e8f0;
}
.cb-window.cb-open { transform: scale(1) translateY(0); opacity: 1; pointer-events: all; }

/* Header */
.cb-header {
    background: linear-gradient(135deg, #0a1628, #1a3a6e);
    padding: 16px 18px; display: flex; align-items: center; gap: 12px;
    flex-shrink: 0;
}
.cb-avatar {
    width: 40px; height: 40px; border-radius: 50%;
    background: rgba(37,99,235,0.3); border: 2px solid rgba(37,99,235,0.5);
    display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;
}
.cb-header-info { flex: 1; }
.cb-header-name { font-size: 14px; font-weight: 700; color: #fff; font-family: 'Plus Jakarta Sans', sans-serif; }
.cb-header-status { font-size: 11px; color: rgba(255,255,255,0.5); display: flex; align-items: center; gap: 5px; margin-top: 2px; }
.cb-header-status::before { content:''; width:7px; height:7px; border-radius:50%; background:#22c55e; display:inline-block; }
.cb-close { background: none; border: none; color: rgba(255,255,255,0.5); cursor: pointer; padding: 4px; border-radius: 6px; font-size: 18px; line-height: 1; transition: color 0.2s; }
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
    cursor: pointer; transition: all 0.2s; font-family: 'Plus Jakarta Sans', sans-serif;
    white-space: nowrap;
}
.cb-topic:hover { background: #eff6ff; color: #2563eb; border-color: #bfdbfe; }

/* Messages */
.cb-messages {
    flex: 1; overflow-y: auto; padding: 16px 14px;
    display: flex; flex-direction: column; gap: 12px;
    scrollbar-width: thin; scrollbar-color: #e2e8f0 transparent;
}
.cb-messages::-webkit-scrollbar { width: 4px; }
.cb-messages::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }

.cb-msg { display: flex; gap: 8px; align-items: flex-end; animation: cbMsgIn 0.25s ease; }
@keyframes cbMsgIn { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }

.cb-msg.cb-bot { justify-content: flex-start; }
.cb-msg.cb-user { justify-content: flex-end; }

.cb-msg-avatar { width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg,#1a3a6e,#2563eb); display:flex; align-items:center; justify-content:center; font-size:13px; flex-shrink:0; }

.cb-bubble {
    max-width: 78%; padding: 10px 14px; border-radius: 16px;
    font-size: 13px; line-height: 1.65; font-family: 'Plus Jakarta Sans', sans-serif;
}
.cb-bot .cb-bubble { background: #f1f5f9; color: #1a1f2e; border-bottom-left-radius: 4px; }
.cb-user .cb-bubble { background: linear-gradient(135deg,#1e4da1,#2563eb); color: #fff; border-bottom-right-radius: 4px; }
.cb-bubble a { color: #2563eb; font-weight: 600; }
.cb-bot .cb-bubble a { color: #2563eb; }
.cb-user .cb-bubble a { color: #bfdbfe; }

/* Typing indicator */
.cb-typing .cb-bubble { padding: 12px 16px; }
.cb-typing-dots { display: flex; gap: 4px; align-items: center; }
.cb-typing-dots span { width: 7px; height: 7px; border-radius: 50%; background: #94a3b8; animation: cbDot 1.2s ease-in-out infinite; }
.cb-typing-dots span:nth-child(2) { animation-delay: 0.2s; }
.cb-typing-dots span:nth-child(3) { animation-delay: 0.4s; }
@keyframes cbDot { 0%,60%,100%{transform:translateY(0)} 30%{transform:translateY(-6px)} }

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
    transition: border-color 0.2s;
}
.cb-input:focus { border-color: #2563eb; }
.cb-input::placeholder { color: #94a3b8; }
.cb-send {
    width: 38px; height: 38px; border-radius: 10px; border: none;
    background: linear-gradient(135deg,#1e4da1,#2563eb); color: #fff;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: all 0.2s; flex-shrink: 0;
}
.cb-send:hover { filter: brightness(1.1); transform: translateY(-1px); }
.cb-send svg { width: 16px; height: 16px; }

@media (max-width: 420px) {
    .cb-window { width: calc(100vw - 32px); right: 16px; bottom: 90px; }
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
        <button class="cb-topic" data-q="Syarat SKCK">📋 SKCK</button>
        <button class="cb-topic" data-q="Cara perpanjang SIM">🚗 SIM</button>
        <button class="cb-topic" data-q="Daftar penerimaan Polri">👮 Penerimaan</button>
        <button class="cb-topic" data-q="Jam pelayanan">🕐 Jam Buka</button>
        <button class="cb-topic" data-q="Alamat Polres">📍 Lokasi</button>
        <button class="cb-topic" data-q="Lapor kehilangan">🚨 Laporan</button>
    </div>

    <div class="cb-messages" id="cbMessages"></div>

    <div class="cb-input-wrap">
        <input class="cb-input" id="cbInput" type="text" placeholder="Ketik pertanyaan kamu…" maxlength="200" autocomplete="off">
        <button class="cb-send" id="cbSend">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </svg>
        </button>
    </div>
</div>

<script>
(function () {

    // ============================================================
    // DATABASE JAWABAN — tambah/edit sesuai kebutuhan
    // ============================================================
    const KB = [
        {
            keys: ['skck', 'surat keterangan', 'catatan kepolisian'],
            answer: `📋 <b>Syarat SKCK Online:</b><br>
• KTP asli + fotokopi<br>
• Kartu Keluarga (KK)<br>
• Akta Kelahiran / Ijazah<br>
• Pas foto 4×6 (latar merah, 6 lembar)<br>
• Biaya Rp 30.000<br><br>
Daftar lewat <b>Super App Polri</b>:<br>
<a href="https://play.google.com/store/apps/details?id=superapps.polri.presisi.presisi" target="_blank">▶ Google Play</a> &nbsp;|&nbsp;
<a href="https://apps.apple.com/id/app/super-app-polri/id1617509708" target="_blank"> App Store</a>`
        },
        {
            keys: ['sim', 'surat izin mengemudi', 'perpanjang sim', 'bikin sim'],
            answer: `🚗 <b>Perpanjang SIM Online:</b><br>
Gunakan aplikasi <b>Digital Korlantas Polri</b>.<br><br>
Syarat:<br>
• SIM lama masih berlaku / maks. 1 tahun kadaluarsa<br>
• KTP aktif<br>
• Foto diri terbaru<br>
• Lulus tes psikologi online (di aplikasi)<br><br>
SIM akan dikirim ke alamat rumah kamu 📦<br><br>
<a href="https://play.google.com/store/apps/details?id=id.qoin.korlantas.user" target="_blank">▶ Google Play</a> &nbsp;|&nbsp;
<a href="https://apps.apple.com/id/app/digital-korlantas-polri/id1565558949" target="_blank"> App Store</a>`
        },
        {
            keys: ['penerimaan', 'daftar polri', 'akpol', 'bintara', 'tamtama', 'sipss', 'rekrutmen', 'masuk polri'],
            answer: `👮 <b>Penerimaan Anggota Polri:</b><br>
Jalur yang tersedia:<br>
• <b>Akpol</b> — Perwira (min. SMA/sederajat)<br>
• <b>Bintara</b> — min. SMA/sederajat<br>
• <b>Tamtama</b> — min. SMP/sederajat<br>
• <b>SIPSS</b> — Sarjana/D4<br><br>
⚠️ Pendaftaran <b>GRATIS</b> — waspada calo!<br><br>
Daftar di portal resmi:<br>
<a href="https://penerimaan.polri.go.id/" target="_blank">🌐 penerimaan.polri.go.id</a>`
        },
        {
            keys: ['jam', 'buka', 'tutup', 'operasional', 'pelayanan jam', 'waktu'],
            answer: `🕐 <b>Jam Pelayanan Polres Gunungkidul:</b><br>
• Senin – Kamis: 08.00 – 15.00 WIB<br>
• Jumat: 08.00 – 11.30 WIB<br>
• Sabtu – Minggu: Tutup<br><br>
🚨 <b>Layanan darurat 24 jam</b> — hubungi <b>110</b>`
        },
        {
            keys: ['alamat', 'lokasi', 'dimana', 'kantor', 'polres', 'letak', 'maps'],
            answer: `📍 <b>Polres Gunungkidul:</b><br>
Jln. MGR Sugiyopranoto No.15, Wonosari<br>
Kabupaten Gunungkidul, D.I. Yogyakarta 55813<br><br>
<a href="https://maps.app.goo.gl/Xv8tKdyoVjMf4DkRA" target="_blank">🗺️ Buka di Google Maps</a>`
        },
        {
            keys: ['lapor', 'kehilangan', 'pengaduan', 'melapor', 'laporan', 'laporan polisi'],
            answer: `🚨 <b>Cara Melapor:</b><br>
• Datang langsung ke <b>SPKT Polres Gunungkidul</b> buka 24 jam<br>
• Telepon darurat: <b>110</b><br>
• Atau melalui aplikasi <b>Super App Polri</b> → menu Lapor<br><br>
Siapkan KTP dan kronologi kejadian ya 👍`
        },
        {
            keys: ['wbs', 'whistle', 'blowing', 'pengaduan rahasia', 'lapor anggota', 'pelanggaran polisi'],
            answer: `🔒 <b>Whistle Blowing System (WBS):</b><br>
Untuk melaporkan dugaan pelanggaran anggota Polri secara <b>aman & rahasia</b>.<br><br>
• Identitas pelapor dijamin tidak dibocorkan<br>
• Laporan ditangani secara profesional<br>
• Pelapor dilindungi dari tindakan balasan<br><br>
Info lebih lanjut tersedia di halaman <b>Informasi Pelayanan</b> website ini.`
        },
        {
            keys: ['kontak', 'telepon', 'nomor', 'hubungi', 'telp', 'hp'],
            answer: `📞 <b>Kontak Polres Gunungkidul:</b><br>
• Telepon: <b>(0274) 391110</b><br>
• Darurat / Hotline: <b>110</b><br>
• Jam kantor: Senin–Kamis 08.00–15.00 WIB<br><br>
Atau kunjungi langsung di Jln. MGR Sugiyopranoto No.15, Wonosari.`
        },
        {
            keys: ['halo', 'hai', 'hi', 'hello', 'selamat', 'hei', 'assalamualaikum'],
            answer: `👋 Halo! Selamat datang di <b>Asisten Polres Gunungkidul</b>.<br><br>
Saya siap membantu kamu dengan informasi seputar:<br>
📋 SKCK &nbsp;🚗 SIM &nbsp;👮 Penerimaan Polri<br>
📍 Lokasi &nbsp;🕐 Jam Buka &nbsp;🚨 Laporan<br><br>
Silakan ketik pertanyaanmu! 😊`
        },
        {
            keys: ['terima kasih', 'makasih', 'thanks', 'thx'],
            answer: `😊 Sama-sama! Semoga informasinya membantu.<br>Jika ada pertanyaan lain, jangan ragu untuk bertanya ya!`
        },
    ];

    const FALLBACK = `Maaf, saya belum punya jawaban untuk pertanyaan itu. 😅<br><br>
Silakan hubungi kami langsung:<br>
📞 <b>(0274) 391110</b> &nbsp;|&nbsp; 🚨 <b>110</b> (darurat)<br>
atau datang ke kantor Polres Gunungkidul.`;

    // ============================================================

    const $win   = document.getElementById('cbWindow');
    const $trig  = document.getElementById('cbTrigger');
    const $close = document.getElementById('cbClose');
    const $msgs  = document.getElementById('cbMessages');
    const $input = document.getElementById('cbInput');
    const $send  = document.getElementById('cbSend');
    const $topics = document.getElementById('cbTopics');

    let opened = false;

    function toggle() {
        opened = !opened;
        $win.classList.toggle('cb-open', opened);
        if (opened && $msgs.children.length === 0) {
            botSay(`👋 Halo! Selamat datang di <b>Asisten Polres Gunungkidul</b>.<br><br>Saya siap membantu informasi seputar SKCK, SIM, Penerimaan Polri, dan lainnya.<br>Pilih topik di atas atau ketik pertanyaanmu! 😊`);
            $trig.querySelector('.cb-notif')?.remove();
        }
        if (opened) setTimeout(() => $input.focus(), 300);
    }

    $trig.addEventListener('click', toggle);
    $close.addEventListener('click', toggle);

    // Quick topic buttons
    $topics.addEventListener('click', e => {
        const btn = e.target.closest('.cb-topic');
        if (!btn) return;
        handleInput(btn.dataset.q);
    });

    // Send
    $send.addEventListener('click', () => handleInput($input.value));
    $input.addEventListener('keydown', e => { if (e.key === 'Enter') handleInput($input.value); });

    function handleInput(text) {
        text = text.trim();
        if (!text) return;
        $input.value = '';
        userSay(text);
        showTyping(() => {
            const answer = findAnswer(text);
            botSay(answer);
        });
    }

    function findAnswer(text) {
        const t = text.toLowerCase();
        for (const item of KB) {
            if (item.keys.some(k => t.includes(k))) return item.answer;
        }
        return FALLBACK;
    }

    function userSay(text) {
        const div = document.createElement('div');
        div.className = 'cb-msg cb-user';
        div.innerHTML = `<div class="cb-bubble">${escHtml(text)}</div>`;
        $msgs.appendChild(div);
        scrollBot();
    }

    function botSay(html) {
        const div = document.createElement('div');
        div.className = 'cb-msg cb-bot';
        div.innerHTML = `<div class="cb-msg-avatar">👮</div><div class="cb-bubble">${html}</div>`;
        $msgs.appendChild(div);
        scrollBot();
    }

    function showTyping(cb) {
        const div = document.createElement('div');
        div.className = 'cb-msg cb-bot cb-typing';
        div.id = 'cbTyping';
        div.innerHTML = `<div class="cb-msg-avatar">👮</div><div class="cb-bubble"><div class="cb-typing-dots"><span></span><span></span><span></span></div></div>`;
        $msgs.appendChild(div);
        scrollBot();
        setTimeout(() => {
            div.remove();
            cb();
        }, 900);
    }

    function scrollBot() { $msgs.scrollTop = $msgs.scrollHeight; }
    function escHtml(s) { return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

})();
</script>