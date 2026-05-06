<x-filament-panels::page>
    <div class="max-w-md mx-auto">
        <div class="text-center mb-6">
            <x-filament::icon icon="heroicon-o-envelope" class="w-16 h-16 mx-auto text-primary-500 mb-4"/>
            <p class="text-gray-500">Kode OTP telah dikirim ke email Anda. Berlaku 5 menit.</p>
        </div>

        <form wire:submit="verify">
            {{ $this->form }}
            <x-filament::button type="submit" class="w-full mt-4">
                Verifikasi OTP
            </x-filament::button>
        </form>
    </div>
</x-filament-panels::page>