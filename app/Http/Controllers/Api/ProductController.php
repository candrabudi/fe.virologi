<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->with('primaryImage');

        // Filter by product type
        if ($request->product_type) {
            $query->byType($request->product_type);
        }

        // Filter by AI domain
        if ($request->ai_domain && $request->ai_domain !== 'all') {
            $query->byDomain($request->ai_domain);
        }

        // Filter by AI level
        if ($request->ai_level && $request->ai_level !== 'all') {
            $query->byLevel($request->ai_level);
        }

        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('summary', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('subtitle', 'LIKE', '%' . $request->search . '%');
            });
        }

        $products = $query->paginate(9);

        // Map thumbnails to full URLs
        $products->getCollection()->transform(function($product) {
            $this->formatProductUrls($product);
            return $product;
        });

        return response()->json($products);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['images', 'primaryImage'])
            ->firstOrFail();

        // Format URLs for main product
        $this->formatProductUrls($product);

        // Format URLs for additional images
        if ($product->images) {
            $product->images->transform(function($image) {
                if ($image->image_path && !filter_var($image->image_path, FILTER_VALIDATE_URL)) {
                    $image->image_path = asset('storage/' . $image->image_path);
                }
                return $image;
            });
        }

        // Get related products
        $related = Product::active()
            ->where('id', '!=', $product->id)
            ->where('ai_domain', $product->ai_domain)
            ->with('primaryImage')
            ->take(3)
            ->get()
            ->map(function($p) {
                $this->formatProductUrls($p);
                return $p;
            });

        // Increment view count
        $product->increment('ai_view_count');

        return response()->json([
            'product' => $product,
            'related' => $related
        ]);
    }

    private function formatProductUrls($product)
    {
        if ($product->thumbnail && !filter_var($product->thumbnail, FILTER_VALIDATE_URL)) {
            $product->thumbnail = asset('storage/' . $product->thumbnail);
        }
        
        if ($product->primaryImage && $product->primaryImage->image_path && !filter_var($product->primaryImage->image_path, FILTER_VALIDATE_URL)) {
            $product->primaryImage->image_path = asset('storage/' . $product->primaryImage->image_path);
        }
    }

    public function domains()
    {
        return response()->json([
            'all',
            'general',
            'network_security',
            'application_security',
            'cloud_security',
            'soc',
            'pentest',
            'malware',
            'incident_response',
            'governance',
        ]);
    }

    public function types()
    {
        return response()->json([
            'all',
            'digital',
            'hardware',
            'service',
            'bundle',
        ]);
    }
}
