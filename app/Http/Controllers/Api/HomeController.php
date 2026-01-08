<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Models\Ebook;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Get all homepage data
     */
    public function index()
    {
        return response()->json([
            'hero' => HomeSection::byKey('hero')->active()->first(),
            'sections' => HomeSection::active()->get(),
            'ebooks' => Ebook::active()
                ->get()
                ->map(function($ebook) {
                    if ($ebook->cover_image && !filter_var($ebook->cover_image, FILTER_VALIDATE_URL)) {
                        $ebook->cover_image = asset('storage/' . $ebook->cover_image);
                    }
                    return $ebook;
                }),
            'articles' => \App\Models\Article::where('is_published', true)
                ->with(['categories'])
                ->latest('published_at')
                ->take(4)
                ->get()
                ->map(function($article) {
                    if ($article->thumbnail && !filter_var($article->thumbnail, FILTER_VALIDATE_URL)) {
                        $article->thumbnail = asset('storage/' . $article->thumbnail);
                    }
                    return $article;
                }),
            'products' => \App\Models\Product::active()
                ->with('primaryImage')
                ->aiRecommended()
                ->take(4)
                ->get()
                ->map(function($product) {
                    if ($product->thumbnail && !filter_var($product->thumbnail, FILTER_VALIDATE_URL)) {
                        $product->thumbnail = asset('storage/' . $product->thumbnail);
                    }
                    if ($product->primaryImage && !filter_var($product->primaryImage->image_path, FILTER_VALIDATE_URL)) {
                        $product->primaryImage->image_path = asset('storage/' . $product->primaryImage->image_path);
                    }
                    return $product;
                }),
            'services' => \App\Models\CyberSecurityService::active()
                ->take(6)
                ->get()
                ->map(function($service) {
                    if ($service->thumbnail && !filter_var($service->thumbnail, FILTER_VALIDATE_URL)) {
                        $service->thumbnail = asset('storage/' . $service->thumbnail);
                    }
                    return $service;
                }),
        ]);
    }

    /**
     * Get hero section
     */
    public function hero()
    {
        return response()->json(HomeSection::byKey('hero')->active()->first());
    }

    /**
     * Get specific section by key
     */
    public function section($key)
    {
        $section = HomeSection::byKey($key)->active()->first();
        
        if (!$section) {
            return response()->json(['message' => 'Section not found'], 404);
        }

        return response()->json($section);
    }

    /**
     * Get all sections
     */
    public function sections()
    {
        return response()->json(HomeSection::active()->get());
    }

    /**
     * Get ebooks
     */
    public function ebooks()
    {
        return response()->json(Ebook::active()->get());
    }
}
