<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebsiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\WebsiteSetting::updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'RD-VIROLOGI',
                'site_logo' => 'website/logo_main.png',
                'site_logo_footer' => 'website/logo_footer.png',
                'site_favicon' => 'website/favicon.png',
                'meta_title' => 'RD-VIROLOGI | Pioneering Digital Biosecurity',
                'meta_description' => 'Next-generation cybersecurity and virology research for high-consequence environments. Protecting the global digital landscape through advanced AI and pathogen analysis.',
                'meta_keywords' => 'cybersecurity, virology, biosecurity, ai research, pathogen analysis, digital defense',
                'google_analytics_id' => 'G-XXXXXXXXXX',
                'google_console_verification' => 'verification-code-here',
                'custom_head_scripts' => '<!-- Custom Head Script Placeholder -->',
                'custom_body_scripts' => '<!-- Custom Body Script Placeholder -->',
            ]
        );
    }
}
