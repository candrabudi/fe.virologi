@extends('layouts.app')

@section('meta_title', 'Intelijen Kebocoran Data | RD-VIROLOGI')

@section('content')
<div class="min-h-screen py-24 px-4 relative overflow-hidden bg-[#0a0f18]">
    <!-- Background Decor -->
    <div class="absolute inset-0 -z-20 overflow-hidden pointer-events-none">
        <!-- Grid System -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#1e293b_1px,transparent_1px),linear-gradient(to_bottom,#1e293b_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-20"></div>
        
        <!-- Animated Cyber Lines -->
        <div class="absolute inset-0 cyber-lines"></div>
        
        <!-- Glowing Blobs -->
        <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-cyan-500/10 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-1/2 h-1/2 bg-emerald-500/10 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s;"></div>
        
        <!-- Scanning Line -->
        <div class="absolute inset-0 w-full h-[2px] bg-gradient-to-r from-transparent via-emerald-500/50 to-transparent scan-line"></div>
    </div>

    <div class="max-w-6xl mx-auto relative z-10">
        <!-- Header -->
        <div class="text-center mb-16" data-aos="fade-down">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-500 text-[10px] font-black uppercase tracking-[0.2em] mb-8">
                <span class="relative flex h-2 w-2 mr-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                </span>
                {{ $page->hero_subtitle ?? 'Mesin Intelijen Pelanggaran' }}
            </div>
            <h1 class="text-4xl md:text-6xl font-black heading-font text-white mb-6 tracking-tighter">
                {!! $page->hero_title ?? 'Periksa <span class="bg-clip-text text-transparent bg-gradient-to-r from-emerald-400 to-cyan-400">Eksposur Data Anda.</span>' !!}
            </h1>
            <p class="text-slate-400 max-w-2xl mx-auto text-lg">
                {{ $page->hero_description ?? 'Cari miliaran rekam data yang bocor di dark web untuk mengamankan identitas digital Anda.' }}
            </p>
        </div>

        <!-- Search Section -->
        <div class="max-w-3xl mx-auto mb-20" data-aos="fade-up">
            <div class="bg-[#111827]/80 backdrop-blur-xl rounded-[2.5rem] p-8 border border-white/10 shadow-2xl">
                <form id="leak-check-form" class="space-y-6">
                    @csrf
                    <div class="relative">
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3 ml-2">Query Intelijen (Email, Nama, atau Kunci)</label>
                        <div class="relative">
                            <input type="text" name="query" id="search-query" required
                                   class="w-full px-8 py-6 rounded-2xl border border-white/5 bg-white/5 focus:outline-none focus:border-emerald-500 focus:ring-8 focus:ring-emerald-500/5 transition-all text-xl font-medium text-white placeholder:text-slate-600"
                                   placeholder="contoh: example@gmail.com">
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none">
                                <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                        </div>
                    </div>

                    <button type="submit" id="submit-btn"
                            class="w-full py-6 bg-emerald-500 text-[#0a0f18] rounded-2xl font-black text-sm uppercase tracking-[0.3em] hover:bg-white transition-all shadow-2xl shadow-emerald-500/20 active:scale-[0.98] flex items-center justify-center space-x-4">
                        <span id="btn-text">Mulai Pemindaian Mendalam</span>
                        <div id="btn-loader" class="hidden">
                            <svg class="animate-spin h-5 w-5 text-[#0a0f18]" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </button>
                </form>
            </div>
        </div>

        <!-- Latest Scans Grid -->
        <div id="logs-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-20" data-aos="fade-up">
            <!-- Logs injected via Axios -->
        </div>

        <!-- Intelligence Dashboard (Hidden by default) -->
        <div id="results-dashboard" class="hidden space-y-12 animate-in fade-in slide-in-from-bottom-10 duration-1000">
            <!-- Top Summary Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- 100% Completed Card -->
                <div class="bg-[#111827]/80 backdrop-blur-xl rounded-[2.5rem] p-10 flex flex-col items-center justify-center text-center shadow-2xl border border-white/10">
                    <div class="relative w-32 h-32 mb-6">
                        <svg class="w-full h-full transform -rotate-90">
                            <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="8" fill="transparent" class="text-white/5"/>
                            <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="8" fill="transparent" stroke-dasharray="364.4" stroke-dashoffset="0" class="text-red-500"/>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <svg class="w-8 h-8 text-red-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            <span class="text-3xl font-black text-white leading-none">100%</span>
                        </div>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500">COMPLETED</span>
                </div>

                <!-- Category Checklist -->
                <div class="bg-[#111827]/80 backdrop-blur-xl rounded-[2.5rem] p-8 shadow-2xl border border-white/10 flex flex-col justify-between">
                    <div class="space-y-3" id="checklist-container">
                        <!-- Items injected via JS -->
                    </div>
                </div>

                <!-- Threat Level Gauge -->
                <div class="bg-[#111827]/80 backdrop-blur-xl rounded-[2.5rem] p-10 flex flex-col items-center text-center shadow-2xl border border-white/10">
                    <div class="relative w-48 h-24 overflow-hidden mb-6">
                        <div class="absolute inset-0 w-48 h-48 rounded-full border-[12px] border-white/5"></div>
                        <div class="absolute inset-0 w-48 h-48 rounded-full border-[12px] border-red-500" style="clip-path: polygon(0 0, 100% 0, 100% 50%, 0 50%); transform: rotate(45deg);"></div>
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-4 h-4 bg-white rounded-full"></div>
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1 h-16 bg-white rounded-full origin-bottom" style="transform: rotate(70deg);"></div>
                    </div>
                    <div class="mb-4">
                        <span class="text-4xl font-black text-red-500 leading-none block mb-1" id="dash-total-threats">+0</span>
                        <div class="inline-flex items-center px-4 py-1.5 bg-red-500/10 text-red-500 rounded-full border border-red-500/20">
                            <span class="w-2 h-2 rounded-full bg-red-500 mr-2 animate-pulse"></span>
                            <span class="text-[10px] font-black uppercase tracking-widest leading-none">CRITICAL THREAT LEVEL</span>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-red-400 uppercase tracking-widest">IMMEDIATE ACTION REQUIRED</span>
                </div>
            </div>

            <!-- 5 Grid Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6" id="stat-cards-container">
                <!-- Cards injected via JS -->
            </div>

            <!-- Detailed Tables Container -->
            <div class="space-y-8" id="detailed-tables-container">
                <!-- Tables injected via JS -->
            </div>
        </div>
    </div>
</div>

<!-- Scanning Overlay -->
<div id="scanning-overlay" class="fixed inset-0 z-[200] hidden items-center justify-center bg-[#0a0f18]/90 backdrop-blur-md">
    <div class="text-center relative">
        <!-- HUD Elements -->
        <div class="absolute inset-0 -m-20 border-[2px] border-emerald-500/20 rounded-full animate-[spin_10s_linear_infinite] pointer-events-none"></div>
        <div class="absolute inset-0 -m-24 border border-dashed border-cyan-500/10 rounded-full animate-[spin_20s_linear_infinite_reverse] pointer-events-none"></div>
        
        <!-- Scanner Circle -->
        <div class="relative w-48 h-48 mx-auto mb-12">
            <div class="absolute inset-0 rounded-full border-4 border-emerald-500/20"></div>
            <div class="absolute inset-0 rounded-full border-4 border-emerald-500 border-t-transparent animate-spin"></div>
            <div class="absolute inset-4 rounded-full border border-cyan-500/30 border-dashed animate-[spin_4s_linear_infinite_reverse]"></div>
            
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="w-16 h-16 text-emerald-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </div>
        
        <h3 class="text-2xl font-black text-white heading-font mb-4 tracking-widest uppercase">Initializing Deep Scan</h3>
        <div class="max-w-md mx-auto space-y-3">
            <div class="h-1 w-full bg-white/5 rounded-full overflow-hidden">
                <div class="h-full bg-emerald-500 animate-[progress_3s_ease-in-out_infinite]"></div>
            </div>
            <div class="flex justify-between text-[10px] font-mono text-emerald-400/60 uppercase tracking-widest">
                <span id="scan-status-text">Synchronizing with LeakOSINT...</span>
                <span id="scan-percentage">0%</span>
            </div>
        </div>

        <!-- Terminal Output Preview -->
        <div class="mt-12 bg-black/40 border border-white/5 p-4 rounded-xl text-left font-mono text-[9px] text-emerald-500/40 w-80 mx-auto overflow-hidden h-32">
            <div id="term-line-1">> ACCESSING DARK WEB NODES...</div>
            <div id="term-line-2">> BYPASSING CLOUDFLARE PROTECTION...</div>
            <div id="term-line-3" class="mt-1">> SEARCHING BREACHED DATABASES...</div>
            <div id="term-line-4" class="opacity-30 mt-1">> 0.002s PACKET LATENCY</div>
            <div id="term-line-5" class="opacity-20 mt-1">> ENCRYPTING TUNNEL...</div>
        </div>
    </div>
</div>

<!-- Search Results Modal -->
<div id="results-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center px-4 transition-all duration-500">
    <div class="absolute inset-0 bg-[#020617]/40 backdrop-blur-[8px] animate-in fade-in duration-500"></div>
    <div class="relative w-full max-w-2xl bg-[#1e293b]/90 backdrop-blur-xl rounded-[2rem] border border-white/10 shadow-[0_32px_64px_-16px_rgba(0,0,0,0.5)] overflow-hidden animate-in zoom-in duration-300">
        <!-- Modal Header -->
        <div class="p-8 pb-4 flex justify-between items-start">
            <div>
                <h3 class="text-white text-xl font-bold heading-font mb-1">Statistik Pencarian</h3>
                <p class="text-slate-400 text-xs">Pratinjau data yang tersedia untuk query Anda</p>
            </div>
            <button onclick="closeModal('results-modal')" class="p-2 hover:bg-white/5 rounded-xl transition-colors text-slate-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-8 pt-4 space-y-6">
            <!-- Row 1: Search Info -->
            <div class="grid grid-cols-2 gap-4">
                <div class="p-5 bg-black/20 border border-white/5 rounded-2xl">
                    <div class="flex items-center space-x-2 text-emerald-400 mb-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span class="text-[10px] font-bold uppercase tracking-widest">Tipe Pencarian</span>
                    </div>
                    <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-[10px] font-black rounded-lg border border-emerald-500/20 uppercase" id="modal-search-type">URI/Email</span>
                </div>
                <div class="p-5 bg-black/20 border border-white/5 rounded-2xl">
                    <div class="flex items-center space-x-2 text-emerald-400 mb-3">
                        <span class="text-[10px] font-bold uppercase tracking-widest"># Query</span>
                    </div>
                    <div class="bg-black/40 px-4 py-2 rounded-xl text-emerald-400 font-mono text-xs truncate border border-white/5" id="modal-query"></div>
                </div>
            </div>

            <!-- Row 2: Statistics -->
            <div class="grid grid-cols-3 gap-4">
                <div class="p-5 bg-[#3f201d]/30 border border-red-500/20 rounded-2xl text-center">
                    <div class="flex items-center justify-center space-x-2 text-orange-400 mb-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span class="text-[9px] font-bold uppercase tracking-widest">Stealer Logs</span>
                    </div>
                    <span class="text-2xl font-black text-orange-500" id="modal-stealer-logs">0</span>
                </div>
                <div class="p-5 bg-[#3f201d]/30 border border-red-500/20 rounded-2xl text-center">
                    <div class="flex items-center justify-center space-x-2 text-orange-400 mb-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/></svg>
                        <span class="text-[9px] font-bold uppercase tracking-widest">DB Leaks</span>
                    </div>
                    <span class="text-2xl font-black text-orange-500" id="modal-db-leaks">0</span>
                </div>
                <div class="p-5 bg-[#143d34]/30 border border-emerald-500/20 rounded-2xl text-center">
                    <div class="flex items-center justify-center space-x-2 text-emerald-400 mb-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span class="text-[9px] font-bold uppercase tracking-widest">Total Hasil</span>
                    </div>
                    <span class="text-2xl font-black text-emerald-500" id="modal-total-results">0</span>
                </div>
            </div>

            <!-- Status Notice -->
            <div id="modal-status-box" class="p-5 bg-[#1e2945]/50 border border-sky-500/20 rounded-2xl flex items-start space-x-4">
                <div class="w-5 h-5 mt-0.5 text-sky-400 flex-shrink-0">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h5 class="text-sky-400 text-xs font-bold leading-none mb-2" id="modal-status-title">Ditemukan Data yang Terekspos</h5>
                    <p class="text-slate-400 text-[10px] leading-relaxed" id="modal-status-text">
                        Rekaman data sensitif cocok dengan query Anda. Untuk mendapatkan akses data lengkap, silakan ajukan permohonan melalui formulir khusus.
                    </p>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="p-8 pt-0 flex justify-end items-center space-x-4">
            <button onclick="closeModal('results-modal')" class="text-slate-400 text-xs font-bold hover:text-white transition-colors">Tutup</button>
            <button id="show-request-form-btn" class="flex items-center space-x-3 px-6 py-3 bg-emerald-500 hover:bg-white text-[#0a0f18] rounded-xl font-bold text-xs transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Ajukan Data Lengkap</span>
            </button>
        </div>
    </div>
</div>

<!-- Request Form Modal -->
<div id="request-modal" class="fixed inset-0 z-[110] hidden flex items-center justify-center px-4 transition-all duration-500 mt-5" style="margin-top: 80px;">
    <div class="absolute inset-0 bg-[#020617]/40 backdrop-blur-[8px] animate-in fade-in duration-500"></div>
    <div class="relative w-full max-w-xl bg-[#111827]/90 backdrop-blur-2xl rounded-[2.5rem] border border-white/10 shadow-[0_32px_64px_-16px_rgba(0,0,0,0.8)] overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="p-8 lg:p-12">
            <div class="mb-10 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-emerald-500/10 text-emerald-500 mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-2xl font-black heading-font text-white mb-2">Formulir Pengajuan Data</h3>
                <p class="text-slate-400 text-sm">Berikan alasan kuat untuk mendapatkan izin akses data intelijen.</p>
            </div>

            <form id="request-data-form" class="space-y-5">
                @csrf
                <input type="hidden" name="query" id="request-query-val">
                <input type="hidden" name="log_id" id="request-log-id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                        <input type="text" name="full_name" required value="{{ auth()->user()->detail->full_name ?? auth()->user()->username }}"
                               class="w-full px-5 py-4 rounded-xl border border-white/10 bg-white/5 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/5 transition-all text-white font-medium"
                               placeholder="Nama sesuai identitas..." readonly>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Email Aktif</label>
                        <input type="email" name="email" required value="{{ auth()->user()->email }}"
                               class="w-full px-5 py-4 rounded-xl border border-white/10 bg-white/5 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/5 transition-all text-white font-medium"
                               placeholder="email@instansi.com" readonly>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Nomor Telepon / WA</label>
                        <input type="text" name="phone_number" required
                               class="w-full px-5 py-4 rounded-xl border border-white/10 bg-white/5 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/5 transition-all text-white font-medium"
                               placeholder="+62 812...">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Status Pemohon</label>
                        <input type="text" name="requester_status" required
                               class="w-full px-5 py-4 rounded-xl border border-white/10 bg-white/5 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/5 transition-all text-white font-medium"
                               placeholder="Staff IT, Mahasiswa, Peneliti, dll...">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Departemen / Instansi (Opsional)</label>
                    <input type="text" name="department"
                           class="w-full px-5 py-4 rounded-xl border border-white/10 bg-white/5 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/5 transition-all text-white font-medium"
                           placeholder="Cyber Security Dev, BIN, Universitas, dll...">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Alasan Pengajuan</label>
                    <textarea name="reason" required rows="3"
                              class="w-full px-5 py-4 rounded-xl border border-white/10 bg-white/5 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/5 transition-all text-white font-medium italic"
                              placeholder="Jelaskan mengapa Anda membutuhkan data ini... (Min. 10 karakter)"></textarea>
                </div>

                <div class="pt-4 flex items-center space-x-4">
                    <button type="button" onclick="closeModal('request-modal')" class="flex-1 py-4 text-slate-400 font-bold text-xs uppercase tracking-widest hover:text-white transition-colors">Batal</button>
                    <button type="submit" id="request-submit-btn"
                            class="flex-[2] py-4 bg-emerald-500 text-[#0a0f18] rounded-xl font-black text-xs uppercase tracking-[0.2em] hover:bg-white transition-all shadow-xl shadow-emerald-500/20 active:scale-[0.98]">
                        Kirim Permohonan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function openRequestModal() {
        document.getElementById('results-modal').classList.add('hidden');
        document.getElementById('request-modal').classList.remove('hidden');
    }

    // Security: Escape HTML to prevent XSS
    function escapeHtml(text) {
        if (!text) return text;
        return text
            .toString()
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function renderDashboard(data) {
        const dashboard = document.getElementById('results-dashboard');
        const checklistContainer = document.getElementById('checklist-container');
        const statCardsContainer = document.getElementById('stat-cards-container');
        const tablesContainer = document.getElementById('detailed-tables-container');
        const totalThreats = document.getElementById('dash-total-threats');

        dashboard.classList.remove('hidden');
        totalThreats.innerText = '+' + data.total_results.toLocaleString();

        // 1. Render Checklist
        const checklistItems = [
            { id: 'stealer_sale', label: 'Stealer logs for sale' },
            { id: 'stealer_logs', label: 'Stealer logs from infected machines' },
            { id: 'employee_data', label: 'Company Employee - Stealer Log at Third Party Websites' },
            { id: 'credential_leaks', label: 'Employee Credential Leak' },
            { id: 'dark_web', label: 'Dark Web & Hacker Channel Mentions' }
        ];

        checklistContainer.innerHTML = checklistItems.map(item => `
            <div class="flex items-center space-x-3 p-3 rounded-xl ${data.categories[item.id].length > 0 ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-white/5 text-slate-500 opacity-50 border border-transparent'}">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span class="text-[10px] font-bold uppercase tracking-wider">${item.label}</span>
            </div>
        `).join('');

        // 2. Render 5 Stat Cards
        const cardConfig = [
            { id: 'stealer_sale', label: 'Stealer Logs for Sale', icon: 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4', color: 'red', critical: true },
            { id: 'stealer_logs', label: 'Stealer Logs', icon: 'M9 12l2 2 4-4m5.618-4.016A3.323 3.323 0 0010.603 2.112a3.323 3.323 0 00-4.586 1.104 3.323 3.323 0 00-1.104 4.586 3.323 3.323 0 001.104 4.586l4.586 4.586a1 1 0 001.414 0l4.586-4.586a3.323 3.323 0 001.104-4.586z', color: 'red', critical: true },
            { id: 'employee_data', label: 'Employee Data at Third Party Sites', icon: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z', color: 'cyan', critical: false },
            { id: 'credential_leaks', label: 'Employee Credential Leak', icon: 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', color: 'cyan', critical: false },
            { id: 'dark_web', label: 'Dark Web & Hacker Channel Mentions', icon: 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9', color: 'cyan', critical: false }
        ];

        statCardsContainer.innerHTML = cardConfig.map(card => {
            const count = data.categories[card.id].reduce((acc, current) => acc + current.count, 0);
            const colorClass = card.color === 'red' ? 'text-red-500 bg-red-500/10' : 'text-cyan-500 bg-cyan-500/10';
            
            return `
                <div class="bg-[#111827]/80 backdrop-blur-xl rounded-[2rem] p-6 shadow-2xl border border-white/10 relative overflow-hidden group">
                    ${card.critical && count > 0 ? '<span class="absolute top-4 right-4 px-2 py-0.5 bg-red-500 text-white text-[8px] font-black rounded-full shadow-lg shadow-red-500/20 uppercase">CRITICAL</span>' : ''}
                    <div class="w-12 h-12 rounded-2xl ${colorClass} flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${card.icon}"/></svg>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-2xl font-black text-white leading-none">${count.toLocaleString()}${count > 0 ? '+' : ''}</h4>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest leading-tight">${card.label}</p>
                    </div>
                </div>
            `;
        }).join('');

        // 3. Render Detailed Tables
        tablesContainer.innerHTML = '';
        Object.entries(data.categories).forEach(([catId, items]) => {
            if (items.length === 0) return;

            const config = cardConfig.find(c => c.id === catId);
            const colorClass = config.color === 'red' ? 'bg-red-500' : 'bg-cyan-500';
            
            items.forEach(item => {
                const tableHtml = `
                    <div class="bg-[#111827]/80 backdrop-blur-xl rounded-[2.5rem] shadow-2xl border border-white/10 overflow-hidden" data-aos="fade-up">
                        <div class="p-8 border-b border-white/5 flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-2xl ${colorClass} text-white flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${config.icon}"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-black text-white heading-font">${escapeHtml(item.name)}</h3>
                                    <p class="text-slate-500 text-xs">${config.label} detected on dark web marketplaces</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="px-4 py-1.5 bg-emerald-500/10 text-emerald-400 text-[10px] font-black rounded-full border border-emerald-500/20 flex items-center">
                                    <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    COMPLETED
                                </span>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-white/5">
                                    <tr>
                                        <th class="px-8 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">IDENTITY / ASSET</th>
                                        <th class="px-8 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">EXPOSED DATA</th>
                                        <th class="px-8 py-4 text-right text-[10px] font-black text-slate-500 uppercase tracking-widest">SOURCE</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    ${item.data.map((row, idx) => {
                                        const isBlurred = idx >= 2;
                                        const blurClass = isBlurred ? 'blur-sm select-none opacity-50 pointer-events-none' : '';
                                        
                                        // Priority Logic for Columns
                                        let col1 = row.Email || row.email || row.NickName || row.username || row.URL || row.Url || row.Domain || row.Address || row.AutoBrand || 'Unknown Asset';
                                        
                                        // Handle special case for LinkedIn data structure
                                        if (row.FirstName) {
                                            col1 = `${row.FirstName} ${row.LastName || ''}`.trim();
                                        }

                                        let col2 = row.Password || row.password || row.NIK || row.EngineNumber || row.JobTitle || row.Title || 'Sensitive Data';
                                        
                                        // Source Logic
                                        const sourceName = item.name || 'Dark Web Database';

                                        return `
                                        <tr class="hover:bg-white/[0.02] transition-colors relative group">
                                            <td class="px-8 py-5">
                                                <div class="flex items-center space-x-3 ${blurClass}">
                                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                    <span class="text-sm font-bold text-slate-300 bg-white/5 px-3 py-1 rounded-lg border border-white/10 uppercase font-mono tracking-tight max-w-[220px] truncate block" title="${isBlurred ? '' : escapeHtml(col1)}">
                                                        ${isBlurred ? 'HIDDEN-ASSET-DATA' : escapeHtml(col1)}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-8 py-5">
                                                <div class="inline-flex items-center px-4 py-1.5 bg-black/40 text-emerald-400 text-[10px] font-bold rounded-lg border border-emerald-500/20 uppercase italic ${blurClass} max-w-[200px] truncate">
                                                    ${isBlurred ? 'ENCRYPTED' : escapeHtml(col2)}
                                                </div>
                                            </td>
                                            <td class="px-8 py-5 text-right">
                                                <span class="text-[10px] font-bold text-slate-500 font-mono tracking-widest italic ${blurClass}">${escapeHtml(sourceName)}</span>
                                            </td>
                                        </tr>
                                    `}).join('')}
                                </tbody>
                            </table>
                        </div>
                        <div class="bg-black/40 p-4 border-t border-white/5 flex justify-between items-center">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-4">+${(item.count - 10 > 0 ? item.count - 10 : 0).toLocaleString()} More Items in Black Market</span>
                            <button onclick="openRequestModal()" class="px-6 py-2 bg-white/5 hover:bg-emerald-500 text-slate-500 hover:text-[#0a0f18] border border-white/10 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all">Request Full Decryption</button>
                        </div>
                    </div>
                `;
                tablesContainer.insertAdjacentHTML('beforeend', tableHtml);
            });
        });
        
        // Final smooth scroll to results
        setTimeout(() => {
            dashboard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 500);
    }

    document.getElementById('leak-check-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const query = document.getElementById('search-query').value;
        const submitBtn = document.getElementById('submit-btn');
        const btnText = document.getElementById('btn-text');
        const btnLoader = document.getElementById('btn-loader');
        const resultsModal = document.getElementById('results-modal');
        const scanningOverlay = document.getElementById('scanning-overlay');
        
        const modalQuery = document.getElementById('modal-query');
        const modalStealerCount = document.getElementById('modal-stealer-logs');
        const modalDbCount = document.getElementById('modal-db-leaks');
        const modalTotalCount = document.getElementById('modal-total-results');
        
        const modalStatusBox = document.getElementById('modal-status-box');
        const modalStatusTitle = document.getElementById('modal-status-title');
        const modalStatusText = document.getElementById('modal-status-text');

        // Show Overlay
        scanningOverlay.classList.remove('hidden');
        scanningOverlay.classList.add('flex');
        
        // Simple UI Progress Simulation
        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.floor(Math.random() * 10) + 1;
            if (progress >= 99) progress = 99;
            document.getElementById('scan-percentage').innerText = progress + '%';
        }, 150);

        axios.post('{{ route('leak-check.check') }}', { query })
            .then(response => {
                const data = response.data;
                clearInterval(interval);
                document.getElementById('scan-percentage').innerText = '100%';
                
                setTimeout(() => {
                    scanningOverlay.classList.add('hidden');
                    scanningOverlay.classList.remove('flex');
                    
                    if (data.success) {
                        modalQuery.innerText = data.query;
                        modalStealerCount.innerText = data.stealer_logs;
                        modalDbCount.innerText = data.db_leaks;
                        modalTotalCount.innerText = data.total_results;
                        
                        document.getElementById('request-query-val').value = data.query;
                        document.getElementById('request-log-id').value = data.log_id;

                        if (data.total_results > 0) {
                            modalStatusBox.classList.remove('bg-black/20', 'border-white/5');
                            modalStatusBox.classList.add('bg-[#3f201d]/20', 'border-red-500/20');
                            modalStatusTitle.innerText = 'Data Terkompromi';
                            modalStatusTitle.className = 'text-red-500 text-xs font-bold leading-none mb-2';
                            modalStatusText.innerText = `Kami mendeteksi ${data.total_results} rekaman yang terekspos. Untuk akses data lengkap, silakan ajukan formulir khusus pemohon.`;
                            document.getElementById('show-request-form-btn').classList.remove('hidden');
                            
                            renderDashboard(data);
                        } else {
                            modalStatusBox.classList.remove('bg-[#3f201d]/20', 'border-red-500/20');
                            modalStatusBox.classList.add('bg-[#143d34]/20', 'border-emerald-500/20');
                            modalStatusTitle.innerText = 'Bersih dari Rekaman';
                            modalStatusTitle.className = 'text-emerald-500 text-xs font-bold leading-none mb-2';
                            modalStatusText.innerText = "Tidak ada hasil ditemukan. Integritas database tetap utuh untuk akun / query ini.";
                            document.getElementById('show-request-form-btn').classList.add('hidden');
                            document.getElementById('results-dashboard').classList.add('hidden');
                        }

                        resultsModal.classList.remove('hidden');

                        document.getElementById('show-request-form-btn').onclick = () => {
                            resultsModal.classList.add('hidden');
                            document.getElementById('request-modal').classList.remove('hidden');
                        };

                        loadLogs();
                    }
                }, 500);
            })
            .catch(error => {
                clearInterval(interval);
                scanningOverlay.classList.add('hidden');
                scanningOverlay.classList.remove('flex');
                alert(error.response?.data?.message || 'Pemindaian terinterupsi. Gagal koneksi.');
                loadLogs();
            });
    });

    document.getElementById('request-data-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = document.getElementById('request-submit-btn');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        submitBtn.disabled = true;
        submitBtn.innerText = 'Mengirim Permohonan...';

        axios.post('{{ route('leak-check.request') }}', data)
            .then(response => {
                if (response.data.success) {
                    alert(response.data.message);
                    closeModal('request-modal');
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.innerText = 'Kirim Permohonan';
                alert(error.response?.data?.message || 'Gagal mengirim permohonan.');
            });
    });
</script>

<style>
    .glossy-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
    }

    .cyber-lines {
        background-image: 
            radial-gradient(circle at 2px 2px, rgba(16, 185, 129, 0.1) 1px, transparent 0);
        background-size: 40px 40px;
    }

    .scan-line {
        top: -100px;
        animation: scan 8s linear infinite;
        box-shadow: 0 0 20px rgba(16, 185, 129, 0.2);
    }

    @keyframes scan {
        0% { transform: translateY(0); opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { transform: translateY(100vh); opacity: 0; }
    }

    /* Animasi tambahan untuk garis cyber */
    .cyber-lines::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, 
            transparent 0%, 
            rgba(6, 182, 212, 0.05) 50%, 
            transparent 100%);
        width: 200%;
        animation: cyber-move 15s linear infinite;
    }

    @keyframes cyber-move {
        from { transform: translateX(-50%); }
        to { transform: translateX(0); }
    }

    @keyframes progress {
        0% { transform: translateX(-100%); }
        50% { transform: translateX(0); }
        100% { transform: translateX(100%); }
    }
</style>
@endsection
