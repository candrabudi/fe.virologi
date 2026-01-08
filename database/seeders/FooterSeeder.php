<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\FooterSetting::truncate();
        \App\Models\FooterSetting::create([
            'description' => 'Menghadirkan masa depan keamanan siber melalui inovasi AI dan riset teknologi mutakhir untuk melindungi infrastruktur digital dunia.',
            'address' => 'Gedung Cyber 2, Lt. 17, Jl. HR Rasuna Said, Jakarta',
            'email' => 'contact@rd-virologi.tech',
            'phone' => '+62 21 555 0123',
            'copyright_text' => '© 2026 RD-VIROLOGI. All rights reserved.',
            'social_links' => [
                'x' => 'https://x.com/rdvirologi',
                'linkedin' => 'https://linkedin.com/company/rd-virologi',
                'github' => 'https://github.com/rd-virologi',
                'instagram' => 'https://instagram.com/rd-virologi',
            ],
            'column_1_title' => 'Intelligence', // This is dynamic categories anyway
            'column_1_links' => [], // Empty because we use ArticleCategory
            'column_2_title' => 'Perusahaan',
            'column_2_links' => [
                ['text' => 'Tentang Kami', 'url' => '/about'],
                ['text' => 'Layanan Kami', 'url' => '/layanan'],
                ['text' => 'Hubungi Kami', 'url' => '/contact'],
                ['text' => 'Karir', 'url' => '#'],
            ],
            'column_3_title' => 'Legalitas',
            'column_3_links' => [
                ['text' => 'Kebijakan Privasi', 'url' => '#'],
                ['text' => 'Syarat & Ketentuan', 'url' => '#'],
                ['text' => 'Kepatuhan Data', 'url' => '#'],
            ],
        ]);
    }
}
