<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\Http\Request;

class EbookController extends Controller
{
    public function index()
    {
        return view('ebooks.index');
    }

    public function show($slug)
    {
        $ebook = Ebook::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('ebooks.show', compact('ebook'));
    }
}
