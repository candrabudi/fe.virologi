<?php

namespace App\Http\Controllers;

use App\Models\LeakCheckLog;
use App\Models\LeakDataRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class LeakCheckController extends Controller
{
    public function index()
    {
        $page = \App\Models\Page::where('key', 'leak_check')->first();
        $logs = LeakCheckLog::where('user_id', Auth::id())->latest()->take(10)->get();
        return view('leak-check.index', compact('logs', 'page'));
    }

    public function check(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:4',
        ]);

        // Sanitize input to prevent XSS/Injection
        $query = strip_tags(trim($request->input('query')));

        // Fetch settings from Database
        $setting = \App\Models\LeakCheckSetting::getActive();

        if (!$setting->is_enabled) {
            return response()->json([
                'success' => false,
                'message' => 'Layanan pemindaian kebocoran data saat ini dinonaktifkan oleh administrator.'
            ], 503);
        }

        $token = $setting->api_token;
        // Basic validation if token is missing
        if (empty($token)) {
             return response()->json([
                'success' => false,
                'message' => 'Konfigurasi API Token belum diatur. Hubungi administrator.'
            ], 500);
        }

        $url = rtrim($setting->api_endpoint, '/'); 

        try {
            $response = Http::post($url, [
                'token' => $token,
                'request' => $query,
                'limit' => $setting->default_limit,
                'lang' => $setting->lang,
                'type' => 'json'
            ]);

            $data = $response->json();

            if (isset($data['Error code'])) {
                LeakCheckLog::create([
                    'user_id' => Auth::id(),
                    'query' => $query,
                    'status' => 'failed',
                    'error_message' => $data['Error code'],
                    'raw_response' => json_encode($data),
                    'ip_address' => $request->ip(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Layanan pemindaian sedang mengalami gangguan teknis. Tim kami telah diberitahu. Silakan coba beberapa saat lagi.'
                ], 400);
            }

            $dbLeaksCount = 0;
            $stealerLogsCount = 0;
            
            $categories = [
                'stealer_sale' => [],
                'stealer_logs' => [],
                'employee_data' => [],
                'credential_leaks' => [],
                'dark_web' => []
            ];

            if (isset($data['List'])) {
                foreach ($data['List'] as $dbName => $info) {
                    if ($dbName === "No results found") continue;
                    
                    $dbNameLower = strtolower($dbName);
                    $records = $info['Data'] ?? [];
                    $count = count($records);
                    
                    // Masking Data Logic
                    $maskedRecords = array_map(function($record) {
                        $masked = [];
                        foreach ($record as $key => $value) {
                            if (empty($value)) {
                                $masked[$key] = $value;
                                continue;
                            }
                            
                            $strVal = (string)$value;
                            $len = strlen($strVal);
                            
                            if (str_contains(strtolower($key), 'email')) {
                                // Mask email: ex***@domain.com
                                $parts = explode('@', $strVal);
                                if (count($parts) == 2) {
                                    $name = $parts[0];
                                    $domain = $parts[1];
                                    $maskedName = substr($name, 0, 2) . str_repeat('*', max(0, strlen($name) - 2));
                                    $masked[$key] = $maskedName . '@' . $domain;
                                } else {
                                    $masked[$key] = substr($strVal, 0, 2) . '***'; 
                                }
                            } elseif (str_contains(strtolower($key), 'password') || str_contains(strtolower($key), 'pwd')) {
                                // Mask password aggressively
                                $masked[$key] = substr($strVal, 0, 2) . str_repeat('*', 6);
                            } elseif ($len > 4) {
                                // General masking for other keys like Phone, Address, etc.
                                $visible = floor($len / 2);
                                $masked[$key] = substr($strVal, 0, $visible) . str_repeat('*', $len - $visible);
                            } else {
                                $masked[$key] = $strVal;
                            }
                        }
                        return $masked;
                    }, array_slice($records, 0, 10)); // Process first 10 for preview

                    $item = [
                        'name' => $dbName,
                        'count' => $count,
                        'data' => $maskedRecords // Use masked data
                    ];

                    // Logic categorization based on typical LeakOSINT names
                    if (str_contains($dbNameLower, 'market') || str_contains($dbNameLower, 'sale')) {
                        $categories['stealer_sale'][] = $item;
                    } elseif (str_contains($dbNameLower, 'stealer') || str_contains($dbNameLower, 'redline') || str_contains($dbNameLower, 'lumma')) {
                        $categories['stealer_logs'][] = $item;
                    } elseif (str_contains($dbNameLower, 'employee') || str_contains($dbNameLower, 'corp')) {
                        $categories['employee_data'][] = $item;
                    } elseif (str_contains($dbNameLower, 'combo') || str_contains($dbNameLower, 'mail') || str_contains($dbNameLower, 'leak')) {
                        $categories['credential_leaks'][] = $item;
                    } else {
                        $categories['dark_web'][] = $item;
                    }

                    if (str_contains($dbNameLower, 'stealer') || str_contains($dbNameLower, 'bot')) {
                        $stealerLogsCount += $count;
                    } else {
                        $dbLeaksCount += $count;
                    }
                }
            }

            $totalResults = $dbLeaksCount + $stealerLogsCount;

            $log = LeakCheckLog::create([
                'user_id' => Auth::id(),
                'query' => $query,
                'leak_count' => $totalResults,
                'raw_response' => json_encode($data),
                'status' => 'success',
                'ip_address' => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'log_id' => $log->id,
                'query' => $query,
                'db_leaks' => $dbLeaksCount,
                'stealer_logs' => $stealerLogsCount,
                'total_results' => $totalResults,
                'categories' => $categories
            ]);

        } catch (\Exception $e) {
            LeakCheckLog::create([
                'user_id' => Auth::id(),
                'query' => $query,
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'raw_response' => isset($response) ? $response->body() : null,
                'ip_address' => $request->ip(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghubungkan ke server intelijen. Silakan periksa koneksi Anda atau coba lagi nanti.'
            ], 500);
        }
    }

    public function requestData(Request $request)
    {
        $request->validate([
            'log_id' => 'required|exists:leak_check_logs,id',
            'query' => 'required|string',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'reason' => 'required|string|min:10',
            'department' => 'nullable|string|max:100',
            'requester_status' => 'required|string|max:50',
        ]);

        try {
            // Verify ownership of the log to prevent IDOR
            $log = LeakCheckLog::where('id', $request->input('log_id'))
                ->where('user_id', Auth::id())
                ->first();

            if (!$log) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data log tidak ditemukan atau Anda tidak memiliki akses.'
                ], 403);
            }

            // Eloquent's built-in parameter binding prevents SQL Injection.
            // We also sanitize inputs to prevent cross-site scripting (XSS) or other malicious payload storage.
            LeakDataRequest::create([
                'user_id' => Auth::id(),
                'leak_check_log_id' => $log->id,
                'query' => strip_tags(trim($request->input('query'))),
                'full_name' => strip_tags(trim($request->input('full_name'))),
                'email' => filter_var(trim($request->input('email')), FILTER_SANITIZE_EMAIL),
                'phone_number' => strip_tags(trim($request->input('phone_number'))),
                'reason' => strip_tags(trim($request->input('reason'))),
                'department' => strip_tags(trim($request->input('department'))),
                'requester_status' => strip_tags(trim($request->input('requester_status'))),
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Permohonan data lengkap Anda telah dikirim dan sedang ditinjau oleh tim intelijen.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim permohonan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getLogs()
    {
        $logs = LeakCheckLog::where('user_id', Auth::id())
            ->latest()
            ->take(10)
            ->get()
            ->map(function($log) {
                return [
                    'query' => $log->query,
                    'leak_count' => $log->leak_count,
                    'status' => $log->status,
                    'time_ago' => $log->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'success' => true,
            'logs' => $logs
        ]);
    }
}
