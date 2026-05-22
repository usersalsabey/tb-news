// app/Http/Controllers/WbsController.php
<?php

namespace App\Http\Controllers;

use App\Models\LaporanWbs;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class WbsController extends Controller
{
    public function index()
    {
        return view('wbs.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelapor'  => 'required|string|max:255',
            'nik'           => 'required|digits:16',
            'no_hp'         => 'required|string|max:20',
            'alamat'        => 'required|string',
            'kategori'      => 'required|string',
            'informasi'     => 'required|string|min:200|max:5000',
            'dokumen_utama' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,mp4|max:10240',
            'dokumen_tambahan_1' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,mp4|max:10240',
            'dokumen_tambahan_2' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,mp4|max:10240',
        ], [
            'nik.digits'         => 'NIK harus 16 digit angka.',
            'informasi.min'      => 'Informasi minimal 200 karakter.',
            'informasi.max'      => 'Informasi maksimal 5000 karakter.',
            'dokumen_utama.required' => 'Dokumen pendukung wajib dilampirkan.',
        ]);

        // Generate nomor tiket unik
        $nomor_tiket = 'WBS-' . strtoupper(Str::random(8)) . '-' . date('Ymd');

        // Upload dokumen
        $dokumen_utama = $request->file('dokumen_utama')
            ->store('wbs/dokumen', 'public');

        $dokumen_tambahan_1 = $request->hasFile('dokumen_tambahan_1')
            ? $request->file('dokumen_tambahan_1')->store('wbs/dokumen', 'public')
            : null;

        $dokumen_tambahan_2 = $request->hasFile('dokumen_tambahan_2')
            ? $request->file('dokumen_tambahan_2')->store('wbs/dokumen', 'public')
            : null;

        // Simpan ke database
        $laporan = LaporanWbs::create([
            'nomor_tiket'       => $nomor_tiket,
            'nama_pelapor'      => $request->nama_pelapor,
            'nik'               => $request->nik,
            'no_hp'             => $request->no_hp,
            'alamat'            => $request->alamat,
            'kategori'          => $request->kategori,
            'informasi'         => $request->informasi,
            'dokumen_utama'     => $dokumen_utama,
            'dokumen_tambahan_1' => $dokumen_tambahan_1,
            'dokumen_tambahan_2' => $dokumen_tambahan_2,
            'status'            => 'Diterima',
        ]);

        return redirect()->route('wbs.sukses', ['tiket' => $nomor_tiket]);
    }

    public function sukses($tiket)
    {
        $laporan = LaporanWbs::where('nomor_tiket', $tiket)->firstOrFail();
        return view('wbs.sukses', compact('laporan'));
    }

    public function downloadPdf($tiket)
    {
        $laporan = LaporanWbs::where('nomor_tiket', $tiket)->firstOrFail();
        $pdf = Pdf::loadView('wbs.pdf', compact('laporan'));
        return $pdf->download('Bukti-Laporan-' . $tiket . '.pdf');
    }
}