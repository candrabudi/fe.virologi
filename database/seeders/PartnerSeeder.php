<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            ['name' => 'ACME', 'order' => 1],
            ['name' => 'GLOBAL', 'order' => 2],
            ['name' => 'NEXUS', 'order' => 3],
            ['name' => 'CORE', 'order' => 4],
            ['name' => 'TECH', 'order' => 5],
        ];

        foreach ($partners as $partner) {
            Partner::create([
                'name' => $partner['name'],
                'logo' => null, // Logo bisa diupload nanti via admin panel
                'website_url' => null,
                'is_active' => true,
                'order' => $partner['order'],
            ]);
        }
    }
}
