@extends('layouts.app')

@section('meta_title', 'Intelijen Kebocoran Data | RD-VIROLOGI')

@section('content')
<div class="min-h-screen relative overflow-hidden bg-[#050505] font-sans selection:bg-emerald-500/30 selection:text-emerald-400">
    <!-- Ambient Background -->
    <div class="fixed inset-0 pointer-events-none">
        <div class="absolute top-[-20%] left-[-10%] w-[70vw] h-[70vw] bg-emerald-900/10 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[60vw] h-[60vw] bg-cyan-900/10 rounded-full blur-[100px] animate-pulse" style="animation-delay: 2s"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.03]"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 py-12 lg:py-24 grid lg:grid-cols-2 gap-16 lg:items-center min-h-[calc(100vh-80px)]">
        
        <!-- Left Panel: Context & Typography -->
        <div class="space-y-10 lg:pr-12" data-aos="fade-right">
            <div>
                <div class="inline-flex items-center space-x-2 mb-6">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
                    <span class="text-xs font-mono text-emerald-500 tracking-[0.2em] uppercase">System Online // v.4.0.1</span>
                </div>
                <h1 class="text-5xl lg:text-7xl font-bold text-white tracking-tighter leading-[0.9]">
                    Digital <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-br from-emerald-400 to-cyan-600">Immunity</span> <br/>
                    Scanner.
                </h1>
            </div>
            
            <p class="text-slate-400 text-lg leading-relaxed max-w-md border-l-2 border-white/10 pl-6">
                {{ $page->hero_description ?? 'Analyze your digital footprint against 40 billion compromised records in the dark web ecosystem.' }}
            </p>

            <div class="flex items-center space-x-8 text-xs font-mono text-slate-500 uppercase tracking-widest">
                <div class="flex items-center space-x-2">
                    <div class="w-1 h-4 bg-emerald-500/50"></div>
                    <span>Leakosint</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-1 h-4 bg-cyan-500/50"></div>
                    <span>Dark Metrics</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-1 h-4 bg-rose-500/50"></div>
                    <span>Threat Intel</span>
                </div>
            </div>
        </div>

        <!-- Right Panel: The "Device" Interface -->
        <div class="relative" data-aos="fade-left" data-aos-delay="200" x-data="{ searchType: 'email' }">
            
            <!-- Floating Elements -->
            <div class="absolute -top-12 -right-12 text-white/5 text-[10rem] font-black pointer-events-none select-none overflow-hidden leading-none z-0">
                SCAN
            </div>

            <!-- The Interface Card -->
            <div class="relative z-10 bg-[#0a0a0a] border border-white/10 p-1 rounded-3xl shadow-[0_0_50px_-10px_rgba(16,185,129,0.1)]">
                <!-- Inner Bezel -->
                <div class="bg-[#0f1115] rounded-[1.3rem] border border-white/5 p-6 lg:p-10 relative overflow-hidden">
                    
                    <!-- Decorative HUD corners -->
                    <div class="absolute top-4 left-4 w-4 h-4 border-l border-t border-white/20 rounded-tl-lg"></div>
                    <div class="absolute top-4 right-4 w-4 h-4 border-r border-t border-white/20 rounded-tr-lg"></div>
                    <div class="absolute bottom-4 left-4 w-4 h-4 border-l border-b border-white/20 rounded-bl-lg"></div>
                    <div class="absolute bottom-4 right-4 w-4 h-4 border-r border-b border-white/20 rounded-br-lg"></div>

                    <!-- Type Selector (Vertical on mobile, Tabs on Desktop) -->
                    <div class="mb-10">
                        <label class="block text-[10px] text-slate-500 font-mono uppercase tracking-widest mb-4">Select Target Vector</label>
                        <div class="grid grid-cols-4 gap-2">
                            <button @click="searchType = 'email'" 
                                class="col-span-1 py-3 rounded-lg border text-[10px] font-bold uppercase tracking-widest transition-all duration-300 relative group overflow-hidden"
                                :class="searchType === 'email' ? 'bg-emerald-500/10 border-emerald-500/50 text-emerald-400' : 'bg-white/5 border-transparent text-slate-500 hover:bg-white/10'">
                                <div class="absolute inset-0 bg-emerald-500/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                                <span class="relative z-10">Email</span>
                            </button>
                            <button @click="searchType = 'username'" 
                                class="col-span-1 py-3 rounded-lg border text-[10px] font-bold uppercase tracking-widest transition-all duration-300 relative group overflow-hidden"
                                :class="searchType === 'username' ? 'bg-cyan-500/10 border-cyan-500/50 text-cyan-400' : 'bg-white/5 border-transparent text-slate-500 hover:bg-white/10'">
                                <div class="absolute inset-0 bg-cyan-500/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                                <span class="relative z-10">User</span>
                            </button>
                            <button @click="searchType = 'phone'" 
                                class="col-span-1 py-3 rounded-lg border text-[10px] font-bold uppercase tracking-widest transition-all duration-300 relative group overflow-hidden"
                                :class="searchType === 'phone' ? 'bg-indigo-500/10 border-indigo-500/50 text-indigo-400' : 'bg-white/5 border-transparent text-slate-500 hover:bg-white/10'">
                                <div class="absolute inset-0 bg-indigo-500/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                                <span class="relative z-10">Phone</span>
                            </button>
                            <button @click="searchType = 'nik'" 
                                class="col-span-1 py-3 rounded-lg border text-[10px] font-bold uppercase tracking-widest transition-all duration-300 relative group overflow-hidden"
                                :class="searchType === 'nik' ? 'bg-rose-500/10 border-rose-500/50 text-rose-400' : 'bg-white/5 border-transparent text-slate-500 hover:bg-white/10'">
                                <div class="absolute inset-0 bg-rose-500/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                                <span class="relative z-10">NIK</span>
                            </button>
                        </div>
                    </div>

                    <!-- Input Area -->
                    <form id="leak-check-form">
                         @csrf
                         <input type="hidden" id="scan-type-input" x-bind:value="searchType">
                        <div class="relative group mb-8">
                            <label class="absolute -top-3 left-4 px-2 bg-[#0f1115] text-[9px] font-mono text-slate-500 uppercase tracking-widest transition-colors group-focus-within:text-white" x-text="searchType + '_INPUT_TERMINAL'"></label>
                            
                            <div class="absolute top-1/2 -translate-y-1/2 left-5 text-slate-600 transition-colors group-focus-within:text-white">
                                <span class="font-mono text-lg">></span>
                            </div>

                            <input type="text" name="query" id="search-query" required
                                class="w-full bg-[#050505] border-2 rounded-xl py-5 pl-12 pr-5 text-white font-mono text-sm placeholder:text-slate-700 outline-none transition-all duration-300"
                                :class="{
                                    'border-white/10 focus:border-emerald-500 group-hover:border-white/20': searchType === 'email',
                                    'border-white/10 focus:border-cyan-500 group-hover:border-white/20': searchType === 'username',
                                    'border-white/10 focus:border-indigo-500 group-hover:border-white/20': searchType === 'phone',
                                    'border-white/10 focus:border-rose-500 group-hover:border-white/20': searchType === 'nik'
                                }"
                                :placeholder="
                                     searchType === 'email' ? 'target@domain.com' : 
                                     (searchType === 'username' ? 'target_handle' : 
                                     (searchType === 'phone' ? '62812xxxx' : '3273xxxx'))">
                            
                            <!-- Status Light on Input -->
                            <div class="absolute top-1/2 -translate-y-1/2 right-5 w-2 h-2 rounded-full transition-colors duration-300"
                                :class="{
                                    'bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.5)]': searchType === 'email',
                                    'bg-cyan-500 shadow-[0_0_10px_rgba(6,182,212,0.5)]': searchType === 'username',
                                    'bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.5)]': searchType === 'phone',
                                    'bg-rose-500 shadow-[0_0_10px_rgba(244,63,94,0.5)]': searchType === 'nik'
                                }"></div>
                        </div>

                        <!-- Alert Box -->
                        <div id="form-alert" class="hidden mb-6 p-4 rounded-xl border border-red-500/30 bg-red-500/10 text-red-400 text-[10px] font-mono tracking-wide animate-in fade-in slide-in-from-top-2 duration-300">
                            <div class="flex items-center space-x-3">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span id="form-alert-message">INVALID INPUT DETECTED</span>
                            </div>
                        </div>

                        <!-- Main Action Button -->
                        <button type="submit" id="submit-btn" class="w-full relative group overflow-hidden rounded-xl">
                            <div class="absolute inset-0 transition-opacity duration-300"
                                :class="{
                                    'bg-emerald-600 group-hover:bg-emerald-500': searchType === 'email',
                                    'bg-cyan-600 group-hover:bg-cyan-500': searchType === 'username',
                                    'bg-indigo-600 group-hover:bg-indigo-500': searchType === 'phone',
                                    'bg-rose-600 group-hover:bg-rose-500': searchType === 'nik'
                                }"></div>
                            
                            <!-- Stripes Pattern -->
                            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9InN0cmlwZXMiIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTTAgNDBMODAgMEgwTDAgNDAiIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3N0cmlwZXMpIi8+PC9zdmc+')] opacity-20"></div>

                            <div class="relative py-5 flex items-center justify-center space-x-3">
                                <span class="font-black text-xs uppercase tracking-[0.3em] text-white" id="btn-text">Initialize Scan</span>
                                <svg class="w-4 h-4 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                <div id="btn-loader" class="hidden">
                                     <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                </div>
                            </div>
                        </button>
                    </form>

                    <!-- Bottom readout -->
                    <div class="mt-8 flex justify-between items-end border-t border-white/5 pt-6">
                        <div class="space-y-1">
                            <div class="text-[9px] text-slate-500 font-mono uppercase">Encryption</div>
                            <div class="text-[10px] text-white font-mono">AES-256 / SHA-512</div>
                        </div>
                         <div class="space-y-1 text-right">
                            <div class="text-[9px] text-slate-500 font-mono uppercase">Node Status</div>
                            <div class="flex items-center justify-end space-x-1">
                                <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></div>
                                <div class="text-[10px] text-emerald-500 font-mono">Connected</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Shadow/Glow -->
            <div class="absolute inset-x-8 -bottom-8 h-24 bg-gradient-to-t from-emerald-500/20 to-transparent blur-2xl -z-10 rounded-full opacity-50"></div>
        </div>
    </div>
    
    <!-- Logs Section (Below Fold) -->
    <div id="logs-container" class="max-w-7xl mx-auto px-6 pb-24 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-aos="fade-up">
         <!-- Logs injected -->
    </div>

    <!-- The Result Dashboard (Unique Design) -->
    <div class="max-w-7xl mx-auto px-6 pb-24">
        <div id="results-dashboard" class="hidden space-y-12 animate-in fade-in slide-in-from-bottom-10 duration-1000">
            
            <!-- Top Grid: Status & Modules -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <!-- Left: Threat Status (Span 4) -->
                <div class="lg:col-span-4 bg-[#0a0a0a] border border-white/5 p-8 relative overflow-hidden group">
                    <!-- Scanline effect -->
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-emerald-500/5 to-transparent -translate-y-full group-hover:translate-y-full transition-transform duration-[3s] ease-in-out pointer-events-none"></div>
                    
                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div>
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-2 h-2 bg-emerald-500 animate-pulse rounded-sm"></div>
                                <h3 class="text-xs font-mono text-emerald-500 uppercase tracking-widest">Status Keamanan</h3>
                            </div>
                            <div class="mb-4">
                                <span class="text-5xl font-black text-white tracking-tighter" id="dash-total-threats">0</span>
                                <span class="text-sm font-mono text-slate-500 ml-2">ANOMALI</span>
                            </div>
                            <p class="text-xs text-slate-400 leading-relaxed font-mono">
                                Sistem telah memindai basis data dark web.
                                <span id="dash-status-text" class="text-white">Tidak ditemukan kebocoran signifikan.</span>
                            </p>
                        </div>
                        
                        <div class="mt-8 pt-6 border-t border-white/5">
                            <div class="flex justify-between items-end">
                                <span class="text-[10px] uppercase text-slate-600 font-mono">Integritas</span>
                                <span class="text-xl font-bold text-white">100%</span>
                            </div>
                            <div class="h-1 w-full bg-white/5 mt-2 overflow-hidden">
                                <div class="h-full bg-emerald-500 w-full" id="integrity-bar"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Active Modules (Span 8) -->
                <div class="lg:col-span-8 bg-[#0a0a0a] border border-white/5 p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xs font-mono text-slate-500 uppercase tracking-widest">Modul Pemindaian Aktif</h3>
                        <span class="text-[10px] px-2 py-1 bg-white/5 text-slate-400 font-mono">SYSTEM_READY</span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="checklist-container">
                        <!-- Injected via JS with new unique design -->
                    </div>
                </div>
            </div>

            <!-- Middle: Stat Cards (Unique Hex/Grid Style) -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-px bg-white/5 border border-white/5" id="stat-cards-container">
                <!-- Cards injected via JS -->
            </div>

            <!-- Bottom: Detailed Tables -->
            <div class="space-y-4" id="detailed-tables-container">
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
    <div class="absolute inset-0 bg-[#000]/80 backdrop-blur-xl animate-in fade-in duration-500"></div>
    <div class="relative w-full max-w-4xl bg-[#0a0a0a] border border-white/10 rounded-sm shadow-[0_0_100px_-20px_rgba(16,185,129,0.1)] overflow-hidden animate-in zoom-in duration-300 flex flex-col max-h-[90vh]">
        
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 bg-[#0f1115] border-b border-white/5">
            <div class="flex items-center space-x-3">
                <div class="w-2 h-2 bg-emerald-500 animate-pulse"></div>
                <h3 class="text-white font-mono text-sm uppercase tracking-widest">Scan Report // <span class="text-emerald-500">Decrypted</span></h3>
            </div>
            <button onclick="closeModal('results-modal')" class="text-slate-500 hover:text-white transition-colors">
                <span class="font-mono text-xs uppercase">[CLOSE TERMINAL]</span>
            </button>
        </div>

        <!-- Body -->
        <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
            <!-- Summary Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Target Info -->
                <div class="p-6 bg-[#050505] border border-white/10 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-2 opacity-20 group-hover:opacity-50 transition-opacity">
                         <svg class="w-16 h-16 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <p class="text-[10px] text-slate-500 font-mono uppercase tracking-widest mb-1">Target Identifier</p>
                    <div class="text-xl text-white font-mono truncate" id="modal-query"></div>
                    <div class="mt-4 flex items-center space-x-2">
                        <span class="px-2 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-mono border border-emerald-500/20" id="modal-search-type">TYPE</span>
                        <span class="px-2 py-0.5 bg-white/5 text-slate-400 text-[9px] font-mono border border-white/10">ID: <span id="modal-log-id">...</span></span>
                    </div>
                </div>

                <!-- Threat Matrix -->
                <div class="grid grid-cols-3 gap-2">
                    <div class="bg-[#1a0505] border border-red-900/30 p-4 flex flex-col justify-center items-center text-center">
                        <span class="text-2xl font-mono text-red-500" id="modal-stealer-logs">0</span>
                        <span class="text-[8px] text-red-400/60 uppercase tracking-widest mt-1">Stealer</span>
                    </div>
                    <div class="bg-[#1a0505] border border-red-900/30 p-4 flex flex-col justify-center items-center text-center">
                        <span class="text-2xl font-mono text-red-500" id="modal-db-leaks">0</span>
                        <span class="text-[8px] text-red-400/60 uppercase tracking-widest mt-1">DB Leaks</span>
                    </div>
                    <div class="bg-[#051a15] border border-emerald-900/30 p-4 flex flex-col justify-center items-center text-center">
                        <span class="text-2xl font-mono text-emerald-500" id="modal-total-results">0</span>
                        <span class="text-[8px] text-emerald-400/60 uppercase tracking-widest mt-1">Total</span>
                    </div>
                </div>
            </div>

            <!-- Status Box -->
            <div id="modal-status-box" class="mb-8 p-5 bg-[#1e2945]/20 border-l-2 border-l-sky-500 border-y border-r border-white/5 flex items-start space-x-4">
                <div class="w-5 h-5 mt-0.5 text-sky-400 flex-shrink-0">!</div>
                <div>
                     <h5 class="text-sky-400 text-xs font-mono font-bold uppercase tracking-widest mb-2" id="modal-status-title">Artifacts Detected</h5>
                    <p class="text-slate-400 text-[10px] font-mono leading-relaxed" id="modal-status-text">
                        Sensitive data fragments match your query. Full decryption requires authorization.
                    </p>
                </div>
            </div>

            <!-- Action Area -->
             <div class="flex justify-end pt-4 border-t border-white/5">
                <button id="show-request-form-btn" class="group relative px-6 py-3 bg-emerald-600 hover:bg-emerald-500 transition-colors text-black font-mono text-xs font-bold uppercase tracking-widest clip-path-polygon">
                    <span class="relative z-10 flex items-center space-x-2">
                        <span>Request Access</span>
                        <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Request Form Modal -->
<div id="request-modal" class="fixed inset-0 z-[110] hidden flex items-center justify-center px-4">
    <div class="absolute inset-0 bg-[#000]/90 backdrop-blur-md animate-in fade-in duration-500"></div>
    
    <div class="relative w-full max-w-lg bg-[#0a0a0a] border border-white/10 shadow-[0_0_50px_-10px_rgba(255,255,255,0.05)] animate-in zoom-in duration-300">
        <!-- Top Tech Decoration -->
        <div class="h-1 w-full bg-gradient-to-r from-transparent via-emerald-500 to-transparent opacity-50"></div>
        
        <div class="p-8">
            <div class="mb-8 text-center">
                <h3 class="text-xl font-mono text-white uppercase tracking-[0.2em] mb-2">Authorization Request</h3>
                <p class="text-[10px] text-slate-500 font-mono">Submit credentials for data release</p>
            </div>

            <!-- Internal Alert Box -->
            <div id="request-alert" class="hidden mb-6 p-3 bg-red-900/10 border border-red-500/30 text-red-500 text-[9px] font-mono text-center">
                <span id="request-alert-message">ERROR: REQUIRED FIELD MISSING</span>
            </div>

            <form id="request-data-form" class="space-y-4">
                 @csrf
                <input type="hidden" name="query" id="request-query-val">
                <input type="hidden" name="log_id" id="request-log-id">

                <div class="grid grid-cols-2 gap-4">
                     <div class="space-y-1">
                        <label class="text-[9px] text-emerald-500/80 font-mono uppercase">Identity</label>
                        <input type="text" name="full_name" value="{{ auth()->user()->detail->full_name ?? auth()->user()->username }}" readonly
                            class="w-full bg-[#111] border border-white/10 p-2.5 text-xs text-slate-300 font-mono focus:border-emerald-500 focus:outline-none transition-colors">
                    </div>
                     <div class="space-y-1">
                        <label class="text-[9px] text-emerald-500/80 font-mono uppercase">Contact Link</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" readonly
                            class="w-full bg-[#111] border border-white/10 p-2.5 text-xs text-slate-300 font-mono focus:border-emerald-500 focus:outline-none transition-colors">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                     <div class="space-y-1">
                        <label class="text-[9px] text-slate-500 font-mono uppercase">Comm. Channel <span class="text-red-500">*</span></label>
                        <input type="text" name="phone_number" placeholder="+62..." required
                            class="w-full bg-black border border-white/10 p-2.5 text-xs text-white font-mono focus:border-emerald-500 focus:outline-none transition-colors">
                    </div>
                     <div class="space-y-1">
                        <label class="text-[9px] text-slate-500 font-mono uppercase">Rank / Status <span class="text-red-500">*</span></label>
                        <input type="text" name="requester_status" placeholder="Researcher..." required
                            class="w-full bg-black border border-white/10 p-2.5 text-xs text-white font-mono focus:border-emerald-500 focus:outline-none transition-colors">
                    </div>
                </div>
                 <div class="space-y-1">
                    <label class="text-[9px] text-slate-500 font-mono uppercase">Unit / Division</label>
                    <input type="text" name="department" placeholder="Cyber Ops..."
                        class="w-full bg-black border border-white/10 p-2.5 text-xs text-white font-mono focus:border-emerald-500 focus:outline-none transition-colors">
                </div>
                 <div class="space-y-1">
                    <label class="text-[9px] text-slate-500 font-mono uppercase">Mission Objective <span class="text-red-500">*</span></label>
                    <textarea name="reason" rows="2" placeholder="State your purpose..." required
                        class="w-full bg-black border border-white/10 p-2.5 text-xs text-white font-mono focus:border-emerald-500 focus:outline-none transition-colors"></textarea>
                </div>

                <div class="flex items-center space-x-3 pt-4">
                    <button type="button" onclick="closeModal('request-modal')" class="flex-1 py-3 border border-white/10 text-slate-500 text-[10px] uppercase tracking-widest hover:bg-white/5 transition-colors font-mono">Abort</button>
                    <button type="submit" id="request-submit-btn" class="flex-1 py-3 bg-emerald-600 text-black text-[10px] font-bold uppercase tracking-widest hover:bg-emerald-500 transition-colors font-mono clip-path-polygon">Transmit</button>
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
        // 1. Update Modal Stats (Tactical Quick View)
        document.getElementById('modal-stealer-logs').innerText = data.stealer_logs || 0;
        document.getElementById('modal-db-leaks').innerText = data.db_leaks || 0;
        document.getElementById('modal-total-results').innerText = data.total_results || 0;
        
        // Modal Status Box Logic
        const statusBox = document.getElementById('modal-status-box');
        const statusTitle = document.getElementById('modal-status-title');
        const statusText = document.getElementById('modal-status-text');
        
        if (data.total_results > 0) {
            statusBox.className = 'mb-8 p-5 bg-[#1e2945]/20 border-l-2 border-l-red-500 border-y border-r border-white/5 flex items-start space-x-4';
            statusTitle.className = 'text-red-500 text-xs font-mono font-bold uppercase tracking-widest mb-2';
            statusTitle.innerText = 'BAHAYA: ARTIFAK DITEMUKAN';
            statusText.innerText = `Pemindaian forensik mengidentifikasi ${data.total_results} indikator kompromi. Tindakan pengamanan segera disarankan.`;
        } else {
             statusBox.className = 'mb-8 p-5 bg-[#064e3b]/20 border-l-2 border-l-emerald-500 border-y border-r border-white/5 flex items-start space-x-4';
            statusTitle.className = 'text-emerald-500 text-xs font-mono font-bold uppercase tracking-widest mb-2';
            statusTitle.innerText = 'AMAN: TIDAK ADA ANCAMAN';
            statusText.innerText = 'Tidak ada vektor kompromi yang terdeteksi dalam dataset intelijen saat ini. Target tampak aman.';
        }

        // 2. Render Full Dashboard (Detailed Report Below Fold)
        const dashboard = document.getElementById('results-dashboard');
        const checklistContainer = document.getElementById('checklist-container');
        const statCardsContainer = document.getElementById('stat-cards-container');
        const tablesContainer = document.getElementById('detailed-tables-container');
        const totalThreats = document.getElementById('dash-total-threats');
        const statusTextDash = document.getElementById('dash-status-text');
        const integrityBar = document.getElementById('integrity-bar');

        // Reveal Dashboard
        dashboard.classList.remove('hidden');
        totalThreats.innerText = data.total_results.toLocaleString();

        // Update Dashboard Main Status
        if(data.total_results > 0) {
            statusTextDash.innerText = "Terdeteksi kebocoran data sensitif pada beberapa sektor.";
            statusTextDash.className = "text-red-500 font-bold";
            integrityBar.className = "h-full bg-red-500 w-[40%]"; // Visual drop
        } else {
            statusTextDash.innerText = "Tidak ditemukan kebocoran signifikan.";
            statusTextDash.className = "text-emerald-500 font-bold";
            integrityBar.className = "h-full bg-emerald-500 w-full"; 
        }

        // A. Render Checklist (Active Modules)
        const checklistItems = [
            { id: 'stealer_sale', label: 'Jual Beli Log Stealer' },
            { id: 'stealer_logs', label: 'Log Stealer Terinfeksi' },
            { id: 'employee_data', label: 'Data Karyawan (Pihak Ke-3)' },
            { id: 'credential_leaks', label: 'Kebocoran Kredensial' },
            { id: 'dark_web', label: 'Dark Web & Forum Hacker' }
        ];

        checklistContainer.innerHTML = checklistItems.map(item => {
            const hasData = data.categories[item.id].length > 0;
            return `
            <div class="flex items-center justify-between p-4 bg-[#050505] border ${hasData ? 'border-red-500/30' : 'border-white/5'} hover:border-white/10 transition-colors group">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-1.5 rounded-full ${hasData ? 'bg-red-500 animate-pulse' : 'bg-emerald-500'}"></div>
                    <span class="text-[10px] font-mono uppercase tracking-wider ${hasData ? 'text-white' : 'text-slate-500'}">${item.label}</span>
                </div>
                <span class="text-[9px] font-mono text-slate-600 group-hover:text-emerald-500 transition-colors">[AKTIF]</span>
            </div>
        `}).join('');

        // B. Render 5 Stat Cards (Clean Grid)
        const cardConfig = [
            { id: 'stealer_sale', label: 'Pasar Gelap', icon: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', color: 'red' },
            { id: 'stealer_logs', label: 'Infeksi Malware', icon: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z', color: 'red' },
            { id: 'employee_data', label: 'Eksposur Pihak Ke-3', icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', color: 'cyan' },
            { id: 'credential_leaks', label: 'Bocor Kredensial', icon: 'M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z', color: 'cyan' },
            { id: 'dark_web', label: 'Sinyal Dark Web', icon: 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', color: 'cyan' }
        ];

        statCardsContainer.innerHTML = cardConfig.map(card => {
            const count = data.categories[card.id].reduce((acc, current) => acc + current.count, 0);
            return `
                <div class="bg-[#0a0a0a] p-6 flex flex-col items-center justify-center text-center hover:bg-[#111] transition-colors group">
                    <div class="mb-3 text-slate-600 group-hover:text-emerald-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="${card.icon}"/></svg>
                    </div>
                    <span class="text-2xl font-mono font-bold text-white mb-1 tracking-tighter">${count.toLocaleString()}</span>
                    <span class="text-[9px] font-mono text-slate-500 uppercase tracking-widest">${card.label}</span>
                </div>
            `;
        }).join('');

        // C. Render Detailed Tables (Minimalist)
        tablesContainer.innerHTML = '';
        Object.entries(data.categories).forEach(([catId, items]) => {
            if (items.length === 0) return;

            const config = cardConfig.find(c => c.id === catId);
            
            items.forEach(item => {
                const tableHtml = `
                    <div class="bg-[#0a0a0a] border border-white/5 overflow-hidden" data-aos="fade-up">
                        <div class="px-6 py-4 border-b border-white/5 flex justify-between items-center bg-[#0f0f0f]">
                            <h3 class="text-xs font-mono font-bold text-emerald-500 uppercase tracking-widest flex items-center">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-sm mr-2"></span>
                                ${escapeHtml(item.name)}
                            </h3>
                            <span class="text-[9px] text-slate-500 font-mono uppercase">${config.label}</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-black/40">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-[9px] font-bold text-slate-500 uppercase tracking-widest font-mono">Aset / Identitas</th>
                                        <th class="px-6 py-3 text-left text-[9px] font-bold text-slate-500 uppercase tracking-widest font-mono">Data Terekspos</th>
                                        <th class="px-6 py-3 text-right text-[9px] font-bold text-slate-500 uppercase tracking-widest font-mono">Sumber</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    ${item.data.map((row, idx) => {
                                        const isBlurred = idx >= 2;
                                        const blurClass = isBlurred ? 'blur-[3px] select-none opacity-40 pointer-events-none' : '';
                                        
                                        let col1 = row.Email || row.email || row.NickName || row.username || row.URL || row.Url || row.Domain || row.Address || row.AutoBrand || 'Unknown Asset';
                                        if (row.FirstName) col1 = `${row.FirstName} ${row.LastName || ''}`.trim();

                                        let col2 = row.Password || row.password || row.NIK || row.EngineNumber || row.JobTitle || row.Title || 'Sensitive Data';
                                        const sourceName = item.name || 'Dark Web Database';

                                        return `
                                        <tr class="hover:bg-white/[0.02] transition-colors group">
                                            <td class="px-6 py-3">
                                                <span class="text-xs font-mono text-slate-300 ${blurClass}">
                                                    ${isBlurred ? 'HIDDEN_DATA_SECURE' : escapeHtml(col1)}
                                                </span>
                                            </td>
                                            <td class="px-6 py-3">
                                                <span class="text-[10px] font-mono text-red-400/80 bg-red-900/10 px-2 py-0.5 rounded border border-red-900/20 ${blurClass}">
                                                    ${isBlurred ? 'ENCRYPTED' : escapeHtml(col2)}
                                                </span>
                                            </td>
                                            <td class="px-6 py-3 text-right">
                                                <span class="text-[9px] font-mono text-slate-600 uppercase ${blurClass}">${escapeHtml(sourceName)}</span>
                                            </td>
                                        </tr>
                                    `}).join('')}
                                </tbody>
                            </table>
                        </div>
                        <div class="bg-[#050505] px-6 py-3 border-t border-white/5 flex justify-between items-center">
                            <span class="text-[9px] font-mono text-slate-600 uppercase tracking-wider">+${(item.count - 10 > 0 ? item.count - 10 : 0).toLocaleString()} ENTRI LAINNYA</span>
                            <button onclick="requestLogAccess('${escapeHtml(item.name)}')" class="text-[9px] font-mono text-emerald-500 hover:text-white uppercase tracking-widest transition-colors flex items-center">
                                Akses Data Lengkap <span class="ml-1">-></span>
                            </button>
                        </div>
                    </div>
                `;
                tablesContainer.insertAdjacentHTML('beforeend', tableHtml);
            });
        });
    }

    document.getElementById('leak-check-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const queryInput = document.getElementById('search-query');
        let query = queryInput.value.trim();
        const scanType = document.getElementById('scan-type-input').value; // Access data via Hidden Input

        // Reset Alert
        const alertBox = document.getElementById('form-alert');
        const alertMsg = document.getElementById('form-alert-message');
        alertBox.classList.add('hidden');

        // Validation Helper
        const showAlert = (msg) => {
            alertMsg.innerText = msg;
            alertBox.classList.remove('hidden');
            alertBox.classList.add('animate-pulse');
            setTimeout(() => alertBox.classList.remove('animate-pulse'), 500);
        };

        // Validation Logic
        if (scanType === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(query)) {
                showAlert('FORMAT EMAIL TIDAK VALID. GUNAKAN: user@domain.com');
                return;
            }
        } else if (scanType === 'phone') {
            query = query.replace(/\D/g, '');
            if (query.startsWith('0')) query = '62' + query.substring(1);
            else if (query.startsWith('8')) query = '62' + query;

            if (query.length < 10 || query.length > 15) {
                showAlert('NOMOR TELEPON TIDAK VALID. MIN. 10 DIGIT.');
                return;
            }
            queryInput.value = query;
        } else if (scanType === 'nik') {
             if (!/^\d{16}$/.test(query)) {
                showAlert('NIK HARUS TERDIRI DARI 16 DIGIT ANGKA.');
                return;
            }
        } else if (scanType === 'username') {
             if (query.length < 3) {
                showAlert('USERNAME TERLALU PENDEK (MIN. 3 KARAKTER).');
                return;
            }
        }

        const scanningOverlay = document.getElementById('scanning-overlay');
        const resultsModal = document.getElementById('results-modal');
        
        // Show Overlay
        scanningOverlay.classList.remove('hidden');
        scanningOverlay.classList.add('flex');
        
        // Progress Simulation
        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.floor(Math.random() * 10) + 1;
            if (progress >= 99) progress = 99;
            document.getElementById('scan-percentage').innerText = progress + '%';
        }, 150);

        axios.post('{{ route('leak-check.check') }}', { query: query, type: scanType })
            .then(response => {
                const data = response.data;
                clearInterval(interval);
                document.getElementById('scan-percentage').innerText = '100%';
                
                setTimeout(() => {
                    scanningOverlay.classList.add('hidden');
                    scanningOverlay.classList.remove('flex');
                    
                    if (data.success) {
                        // Populate Basic info
                        document.getElementById('modal-query').innerText = data.query;
                        document.getElementById('modal-search-type').innerText = scanType.toUpperCase();
                        document.getElementById('modal-log-id').innerText = data.log_id;
                        
                        // Populate Hidden Form
                        document.getElementById('request-query-val').value = data.query;
                        document.getElementById('request-log-id').value = data.log_id;

                        renderDashboard(data);
                        
                        document.getElementById('show-request-form-btn').onclick = () => {
                            resultsModal.classList.add('hidden');
                            document.getElementById('request-modal').classList.remove('hidden');
                        };

                        resultsModal.classList.remove('hidden');
                    }
                }, 500);
            })
            .catch(error => {
                clearInterval(interval);
                scanningOverlay.classList.add('hidden');
                scanningOverlay.classList.remove('flex');
                showAlert('CONNECTION FAILED: ' + (error.response?.data?.message || 'UNKNOWN ERROR'));
            });
    });

    document.getElementById('request-data-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = document.getElementById('request-submit-btn');
        const alertBox = document.getElementById('request-alert');
        const alertMsg = document.getElementById('request-alert-message');
        
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        submitBtn.disabled = true;
        const originalText = submitBtn.innerText;
        submitBtn.innerText = 'TRANSMITTING...';
        alertBox.classList.add('hidden');

        axios.post('{{ route('leak-check.request') }}', data)
            .then(response => {
                if (response.data.success) {
                    alertBox.className = 'mb-6 p-3 bg-emerald-900/10 border border-emerald-500/30 text-emerald-500 text-[9px] font-mono text-center';
                    alertMsg.innerText = 'AUTHORIZATION GRANTED. REQUEST LOGGED.';
                    alertBox.classList.remove('hidden');
                    
                    setTimeout(() => {
                        closeModal('request-modal');
                        submitBtn.disabled = false;
                        submitBtn.innerText = originalText;
                        form.reset();
                    }, 2000);
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.innerText = originalText;
                
                alertBox.className = 'mb-6 p-3 bg-red-900/10 border border-red-500/30 text-red-500 text-[9px] font-mono text-center animate-pulse';
                alertMsg.innerText = 'TRANSMISSION ERROR: ' + (error.response?.data?.message || 'SERVER REJECTED REQUEST');
                alertBox.classList.remove('hidden');
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
