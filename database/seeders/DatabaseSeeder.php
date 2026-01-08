<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Homepage & Auth Seeders
        $this->call([
            UserSeeder::class,
            PartnerSeeder::class,
            WebsiteSettingSeeder::class,
            FooterSeeder::class,
            HomeSectionSeeder::class,
            PageSeeder::class,
            EbookSeeder::class,
            ArticleSeeder::class,
            ProductSeeder::class,
            CyberSecurityServiceSeeder::class,
            ContactSettingSeeder::class,
            AboutSettingSeeder::class,
        ]);
    }
}
