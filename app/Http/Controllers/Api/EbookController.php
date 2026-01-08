<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use Illuminate\Http\Request;

class EbookController extends Controller
{
    public function index(Request $request)
    {
        $query = Ebook::active();

        if ($request->topic && $request->topic !== 'All Resources') {
            $query->where('topic', $request->topic);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('summary', 'LIKE', '%' . $request->search . '%');
            });
        }

        $ebooks = $query->paginate(9);

        $ebooks->getCollection()->transform(function($ebook) {
            if ($ebook->cover_image && !filter_var($ebook->cover_image, FILTER_VALIDATE_URL)) {
                $ebook->cover_image = asset('storage/' . $ebook->cover_image);
            }
            return $ebook;
        });

        return response()->json($ebooks);
    }

    public function topics()
    {
        $topics = [
            'All Resources',
            'general',
            'network_security',
            'application_security',
            'cloud_security',
            'soc',
            'pentest',
            'malware',
            'incident_response',
            'governance',
        ];

        return response()->json($topics);
    }

    public function show($slug)
    {
        $ebook = Ebook::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if ($ebook->cover_image && !filter_var($ebook->cover_image, FILTER_VALIDATE_URL)) {
            $ebook->cover_image = asset('storage/' . $ebook->cover_image);
        }

        $related = Ebook::where('id', '!=', $ebook->id)
            ->where('is_active', true)
            ->where('topic', $ebook->topic)
            ->take(3)
            ->get()
            ->map(function($e) {
                if ($e->cover_image && !filter_var($e->cover_image, FILTER_VALIDATE_URL)) {
                    $e->cover_image = asset('storage/' . $e->cover_image);
                }
                return $e;
            });

        return response()->json([
            'ebook' => $ebook,
            'related' => $related
        ]);
    }
}
