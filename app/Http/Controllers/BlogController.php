<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        return view('blog.index');
    }

    public function category($category)
    {
        return view('blog.category', ['categorySlug' => $category]);
    }

    public function show($slug)
    {
        $post = \App\Models\Article::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('blog.show', compact('post'));
    }
}
