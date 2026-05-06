{{-- resources/views/emails/admin/otp.blade.php --}}
<x-mail::message>
# Kode OTP Login

Halo, **{{ $user->name }}**!

Gunakan kode berikut untuk masuk ke dashboard:

<x-mail::panel>
# {{ $otp }}
</x-mail::panel>

Kode berlaku selama **5 menit**. Jangan bagikan kode ini ke siapapun.

Salam,
{{ config('app.name') }}
</x-mail::message>