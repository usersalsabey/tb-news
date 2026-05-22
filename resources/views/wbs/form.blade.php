@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-3xl">
    <h1 class="text-2xl font-bold text-center mb-2">Formulir Whistleblowing System (WBS)</h1>
    <p class="text-center text-gray-500 mb-8">Laporan Anda bersifat rahasia dan hanya dapat diakses oleh petugas WBS.</p>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul>@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('wbs.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow p-8 space-y-6">
        @csrf

        <h2 class="text-lg font-semibold border-b pb-2">Data Identitas Pelapor</h2>

        <div>
            <label class="block text-sm font-medium mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="nama_pelapor" value="{{ old('nama_pelapor') }}"
                class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Nama lengkap sesuai KTP" required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">NIK <span class="text-red-500">*</span></label>
            <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16"
                class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="16 digit NIK" required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Nomor HP/WhatsApp <span class="text-red-500">*</span></label>
            <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Contoh: 08123456789" required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Alamat <span class="text-red-500">*</span></label>
            <textarea name="alamat" rows="3"
                class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Alamat lengkap" required>{{ old('alamat') }}</textarea>
        </div>

        <h2 class="text-lg font-semibold border-b pb-2">Informasi Laporan</h2>

        <div>
            <label class="block text-sm font-medium mb-1">Kategori <span class="text-red-500">*</span></label>
            <select name="kategori" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="">--- Pilih Kategori ---</option>
                @foreach([
                    'Penyalahgunaan Wewenang',
                    'Korupsi/Gratifikasi',
                    'Pelanggaran Disiplin',
                    'Pungutan Liar (Pungli)',
                    'Kekerasan/Intimidasi',
                    'Pelanggaran Kode Etik',
                    'Lainnya',
                ] as $kat)
                    <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Informasi Laporan <span class="text-red-500">*</span></label>
            <textarea name="informasi" id="informasi" rows="8" maxlength="5000"
                class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Masukkan informasi laporan Anda (minimal 200 karakter)" required>{{ old('informasi') }}</textarea>
            <p class="text-sm text-gray-500 mt-1" id="charCount">5000 karakter tersisa (minimal 200 karakter).</p>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Dokumen Pendukung <span class="text-red-500">*</span></label>
            <p class="text-xs text-gray-500 mb-1">Format: foto/video/PDF/Word/Excel. Maks 10MB.</p>
            <input type="file" name="dokumen_utama"
                class="w-full border rounded-lg px-4 py-2" required
                accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx,.mp4">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Dokumen Tambahan 1 <span class="text-gray-400">(tidak wajib)</span></label>
            <input type="file" name="dokumen_tambahan_1"
                class="w-full border rounded-lg px-4 py-2"
                accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx,.mp4">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Dokumen Tambahan 2 <span class="text-gray-400">(tidak wajib)</span></label>
            <input type="file" name="dokumen_tambahan_2"
                class="w-full border rounded-lg px-4 py-2"
                accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx,.mp4">
        </div>

        <div class="flex gap-4 pt-4">
            <button type="reset" class="flex-1 border border-gray-400 text-gray-700 py-3 rounded-lg hover:bg-gray-100 font-semibold">
                Reset
            </button>
            <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold">
                Kirim Laporan
            </button>
        </div>
    </form>
</div>

<script>
const textarea = document.getElementById('informasi');
const counter  = document.getElementById('charCount');
textarea.addEventListener('input', function() {
    const remaining = 5000 - this.value.length;
    counter.textContent = remaining + ' karakter tersisa (minimal 200 karakter).';
});
</script>
@endsection