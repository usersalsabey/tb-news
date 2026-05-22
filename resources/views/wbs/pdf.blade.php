<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Laporan WBS</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #1a1a1a; }
        .header { text-align: center; border-bottom: 2px solid #1a3a6e; padding-bottom: 16px; margin-bottom: 24px; }
        .header h1 { font-size: 18px; font-weight: bold; color: #1a3a6e; margin: 0; }
        .header p { margin: 4px 0; font-size: 12px; color: #555; }
        .tiket { background: #eff6ff; border: 2px solid #2563eb; border-radius: 8px; padding: 12px; text-align: center; margin-bottom: 24px; }
        .tiket h2 { font-size: 22px; font-weight: bold; color: #2563eb; margin: 0; }
        .tiket p { margin: 4px 0; font-size: 12px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #1a3a6e; color: white; padding: 8px 12px; text-align: left; font-size: 13px; }
        td { padding: 8px 12px; border-bottom: 1px solid #e2e8f0; vertical-align: top; }
        td:first-child { width: 35%; font-weight: bold; color: #374151; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; background: #dcfce7; color: #166534; }
        .footer { text-align: center; margin-top: 40px; font-size: 11px; color: #9ca3af; border-top: 1px solid #e2e8f0; padding-top: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>BUKTI LAPORAN WHISTLEBLOWING SYSTEM (WBS)</h1>
        <p>Polres Gunungkidul | Jln. MGR Sugiyopranoto No.15, Wonosari, Gunungkidul</p>
        <p>Telp: 0851-3375-0875 | Email: ppidgunungkidul@gmail.com</p>
    </div>

    <div class="tiket">
        <p>Nomor Tiket Laporan</p>
        <h2>{{ $laporan->nomor_tiket }}</h2>
        <p>Tanggal: {{ $laporan->created_at->format('d F Y, H:i') }} WIB</p>
    </div>

    <table>
        <tr><th colspan="2">Data Identitas Pelapor</th></tr>
        <tr><td>Nama Lengkap</td><td>{{ $laporan->nama_pelapor }}</td></tr>
        <tr><td>NIK</td><td>{{ $laporan->nik }}</td></tr>
        <tr><td>Nomor HP/WhatsApp</td><td>{{ $laporan->no_hp }}</td></tr>
        <tr><td>Alamat</td><td>{{ $laporan->alamat }}</td></tr>
    </table>

    <table>
        <tr><th colspan="2">Informasi Laporan</th></tr>
        <tr><td>Kategori</td><td>{{ $laporan->kategori }}</td></tr>
        <tr><td>Status</td><td><span class="badge">{{ $laporan->status }}</span></td></tr>
        <tr><td>Isi Laporan</td><td>{{ $laporan->informasi }}</td></tr>
    </table>

    <div class="footer">
        <p>Dokumen ini merupakan bukti resmi penerimaan laporan WBS Polres Gunungkidul.</p>
        <p>Laporan bersifat RAHASIA dan hanya dapat diakses oleh petugas WBS yang berwenang.</p>
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>
</body>
</html>