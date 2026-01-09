<?php

namespace App\Http\Controllers;

use App\Models\LeakCheckLog;
use App\Models\LeakDataRequest;
use App\Models\AiChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Statistik Utama
        $totalLeakChecks = LeakCheckLog::count();
        $totalLeakedFound = LeakCheckLog::sum('leak_count');
        $pendingRequests = LeakDataRequest::where('status', 'pending')->count();
        $totalAiInteractions = AiChatMessage::count();

        // 2. Data Grafik (7 Hari Terakhir)
        $chartData7Days = LeakCheckLog::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(leak_count) as total_leaks')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Format data 7 hari untuk Chart.js
        $labels7Days = [];
        $data7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels7Days[] = Carbon::now()->subDays($i)->format('d M');
            
            $found = $chartData7Days->firstWhere('date', $date);
            $data7Days[] = $found ? (int)$found->total_leaks : 0;
        }

        // Data Grafik 24 Jam (Per Jam)
        $chartData24Hours = LeakCheckLog::select(
                DB::raw('HOUR(created_at) as hour'),
                DB::raw('SUM(leak_count) as total_leaks')
            )
            ->where('created_at', '>=', Carbon::now()->subHours(23))
            ->groupBy('hour')
            ->orderBy('hour', 'ASC')
            ->get();

        // Format data 24 jam untuk Chart.js
        $labels24Hours = [];
        $data24Hours = [];
        for ($i = 23; $i >= 0; $i--) {
            $hour = Carbon::now()->subHours($i)->format('H');
            $labels24Hours[] = Carbon::now()->subHours($i)->format('H:00');
            
            $found = $chartData24Hours->firstWhere('hour', (int)$hour);
            $data24Hours[] = $found ? (int)$found->total_leaks : 0;
        }

        // 3. Aliran Taktis (Aktivitas Terbaru)
        $recentLogs = LeakCheckLog::latest()->take(5)->get()->map(function($log) {
            return [
                'type' => 'leak_check',
                'title' => 'Pemeriksaan Kebocoran',
                'desc' => 'Query: ' . $log->query . ' (' . $log->leak_count . ' temuan)',
                'time' => $log->created_at->diffForHumans(),
                'status' => $log->status == 'success' ? 'success' : 'failed'
            ];
        });

        $recentRequests = LeakDataRequest::latest()->take(5)->get()->map(function($req) {
            return [
                'type' => 'data_request',
                'title' => 'Permintaan Data Baru',
                'desc' => 'Oleh: ' . $req->full_name . ' (' . $req->status . ')',
                'time' => $req->created_at->diffForHumans(),
                'status' => 'pending'
            ];
        });

        $activities = $recentLogs->merge($recentRequests)->sortByDesc('time')->take(8);

        return view('dashboard.index', compact(
            'totalLeakChecks',
            'totalLeakedFound',
            'pendingRequests',
            'totalAiInteractions',
            'labels7Days',
            'data7Days',
            'labels24Hours',
            'data24Hours',
            'activities'
        ));
    }
}
