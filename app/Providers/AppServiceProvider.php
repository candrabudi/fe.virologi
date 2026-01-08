<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('partials.footer', function ($view) {
            $settings = null;
            if (Schema::hasTable('footer_settings')) {
                $settings = \App\Models\FooterSetting::first();
            }
            
            $categories = [];
            if (Schema::hasTable('article_categories')) {
                $categories = \App\Models\ArticleCategory::orderBy('name', 'asc')->get();
            }

            $view->with([
                'footer_settings' => $settings,
                'footer_categories' => $categories
            ]);
        });

        View::composer('*', function ($view) {
            $web_settings = null;
            if (Schema::hasTable('website_settings')) {
                $web_settings = \App\Models\WebsiteSetting::first();
            }
            $view->with('website_settings', $web_settings);

            $contact_settings = null;
            if (Schema::hasTable('contact_settings')) {
                $contact_settings = \App\Models\ContactSetting::first();
            }
            $view->with('contact_settings', $contact_settings);

            $about_settings = null;
            if (Schema::hasTable('about_settings')) {
                $about_settings = \App\Models\AboutSetting::first();
            }
            $view->with('about_settings', $about_settings);
        });
    }
}
