<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CyberSecurityService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = CyberSecurityService::active();

        if ($request->category && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('summary', 'LIKE', '%' . $request->search . '%');
            });
        }

        $services = $query->get()->map(function($svc) {
            if ($svc->thumbnail && !filter_var($svc->thumbnail, FILTER_VALIDATE_URL)) {
                $svc->thumbnail = asset('storage/' . $svc->thumbnail);
            }
            return $svc;
        });

        return response()->json($services);
    }

    public function show($slug)
    {
        $service = CyberSecurityService::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if ($service->thumbnail && !filter_var($service->thumbnail, FILTER_VALIDATE_URL)) {
            $service->thumbnail = asset('storage/' . $service->thumbnail);
        }

        $related = CyberSecurityService::active()
            ->where('id', '!=', $service->id)
            ->where('category', $service->category)
            ->take(3)
            ->get()
            ->map(function($svc) {
                if ($svc->thumbnail && !filter_var($svc->thumbnail, FILTER_VALIDATE_URL)) {
                    $svc->thumbnail = asset('storage/' . $svc->thumbnail);
                }
                return $svc;
            });

        return response()->json([
            'service' => $service,
            'related' => $related
        ]);
    }

    public function categories()
    {
        return response()->json([
            'all',
            'soc',
            'pentest',
            'audit',
            'incident_response',
            'cloud_security',
            'governance',
            'training',
            'consulting',
        ]);
    }
}
