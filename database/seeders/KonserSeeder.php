<?php

namespace Database\Seeders;

use App\Models\Konser;
use Illuminate\Database\Seeder;

class KonserSeeder extends Seeder
{
    public function run(): void
    {
        Konser::create([
            'nama_konser' => 'Jakarta Music Fest',
            'artis' => 'Sheila On 7',
            'tanggal' => '2026-12-20',
            'lokasi' => 'GBK Jakarta',
            'harga_tiket' => 200000,
            'kuota' => 100,
        ]);

        Konser::create([
            'nama_konser' => 'Surabaya FEst',
            'artis' => 'Kahitna',
            'tanggal' => '2026-11-15',
            'lokasi' => 'Grand City Surabaya',
            'harga_tiket' => 350000,
            'kuota' => 50,
        ]);
    }
}