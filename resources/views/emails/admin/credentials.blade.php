<x-mail::message>
# Akun Admin Telah Dibuat

Halo, **{{ $user->name }}**!

Akun admin untuk sistem **Polres Gunungkidul** telah dibuat. Berikut kredensial Anda:

<x-mail::panel>
**Email:** {{ $user->email }}
**Password:** {{ $password }}
</x-mail::panel>

Harap segera verifikasi email Anda dan **ganti password** setelah login pertama.

<x-mail::button :url="$verifyUrl" color="blue">
Verifikasi Email Saya
</x-mail::button>

Link verifikasi berlaku selama **24 jam**.

Salam,
{{ config('app.name') }}
</x-mail::message>