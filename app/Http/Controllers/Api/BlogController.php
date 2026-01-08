<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::where('is_published', true)
            ->with(['categories'])
            ->latest('published_at');

        // Filter by Category
        if ($request->category) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'LIKE', '%' . $request->search . '%');
            });
        }

        $posts = $query->paginate(10);

        // Map thumbnails to assets
        $posts->getCollection()->transform(function($article) {
            if ($article->thumbnail && !filter_var($article->thumbnail, FILTER_VALIDATE_URL)) {
                $article->thumbnail = asset('storage/' . $article->thumbnail);
            }
            return $article;
        });

        return response()->json($posts);
    }

    public function categories()
    {
        $categories = ArticleCategory::withCount('articles')->get();
        return response()->json($categories);
    }

    public function recent()
    {
        $recent = Article::where('is_published', true)
            ->with(['categories'])
            ->latest('published_at')
            ->take(3)
            ->get()
            ->map(function($article) {
                if ($article->thumbnail && !filter_var($article->thumbnail, FILTER_VALIDATE_URL)) {
                    $article->thumbnail = asset('storage/' . $article->thumbnail);
                }
                return $article;
            });
            
        return response()->json($recent);
    }

    public function show($slug)
    {
        $post = Article::where('slug', $slug)
            ->where('is_published', true)
            ->with(['categories', 'tags'])
            ->firstOrFail();

        if ($post->thumbnail && !filter_var($post->thumbnail, FILTER_VALIDATE_URL)) {
            $post->thumbnail = asset('storage/' . $post->thumbnail);
        }

        // Related Posts
        $related = Article::where('id', '!=', $post->id)
            ->where('is_published', true)
            ->whereHas('categories', function($q) use ($post) {
                $q->whereIn('article_categories.id', $post->categories->pluck('id'));
            })
            ->latest('published_at')
            ->take(3)
            ->get()
            ->map(function($article) {
                if ($article->thumbnail && !filter_var($article->thumbnail, FILTER_VALIDATE_URL)) {
                    $article->thumbnail = asset('storage/' . $article->thumbnail);
                }
                return $article;
            });

        return response()->json([
            'post' => $post,
            'related' => $related
        ]);
    }
}
