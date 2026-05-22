<?php

namespace Database\Seeders;

use App\Models\Pengumuman;
use Illuminate\Database\Seeder;

class PengumumanSeeder extends Seeder
{
    public function run()
    {
        Pengumuman::create([
            'title' => 'Kerja Bakti Lingkungan',
            'content' => 'Akan dilaksanakan kerja bakti lingkungan pada hari Minggu, 12 Mei 2024. Mohon partisipasi seluruh warga.',
            'date' => '2024-05-05',
            'created_by' => 1,
            'is_pinned' => true,
            'is_active' => true,
        ]);

        Pengumuman::create([
            'title' => 'Pembayaran Iuran Mei 2024',
            'content' => 'Pembayaran Iuran RT bulan Mei 2024 sudah dibuka. Terima kasih kepada warga yang sudah membayar.',
            'date' => '2024-05-01',
            'created_by' => 1,
            'is_pinned' => false,
            'is_active' => true,
        ]);

        Pengumuman::create([
            'title' => 'Rapat Pengurus RT',
            'content' => 'Rapat rutin pengurus RT akan dilaksanakan pada hari Sabtu, 4 Mei 2024 pukul 19.30 WIB di Pos RT.',
            'date' => '2024-04-28',
            'created_by' => 1,
            'is_pinned' => false,
            'is_active' => true,
        ]);
    }
}
