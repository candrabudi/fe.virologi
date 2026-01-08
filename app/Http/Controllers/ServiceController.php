<?php

namespace App\Http\Controllers;

use App\Models\CyberSecurityService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return view('services.index');
    }

    public function show($slug)
    {
        $service = CyberSecurityService::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('services.show', compact('service'));
    }
}
