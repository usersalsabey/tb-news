<?php

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Resources\ProfileResource;
use App\Models\Profile;
use Filament\Resources\Pages\ListRecords;

class ListProfiles extends ListRecords
{
    protected static string $resource = ProfileResource::class;

    public function mount(): void
    {
        $profile = Profile::first();

        if (! $profile) {
            $profile = Profile::create([
                'nama_instansi' => 'Polres Gunungkidul',
                'kapolres'      => '-',
                'alamat'        => 'Jln. MGR Sugiyopranoto No.15, Wonosari, Gunungkidul',
                'telepon'       => '0851-3375-0875',
                'email'         => 'ppidgunungkidul@gmail.com',
                'jam_pelayanan' => '24 Jam',
                'visi'          => '',
                'misi'          => [],
                'sejarah'       => '',
                'statistik'     => [],
            ]);
        }

        $this->redirect(ProfileResource::getUrl('edit', ['record' => $profile]));
    }
}