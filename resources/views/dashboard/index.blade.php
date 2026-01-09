@extends('layouts.app')

@section('meta_title', 'Pusat Intelijen | RD-VIROLOGI')

@section('content')
<div class="pt-24 pb-12 lg:pt-32 relative min-h-screen">
    <!-- Sophisticated Background Decors -->
    <div class="fixed top-0 right-0 w-1/2 h-full bg-gradient-to-l from-sky-100/10 to-transparent pointer-events-none"></div>
    <div class="fixed bottom-0 left-0 w-1/2 h-full bg-gradient-to-r from-indigo-100/5 to-transparent pointer-events-none"></div>

    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-12 relative z-10">
        <!-- Dashboard Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12" data-aos="fade-down">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-emerald-500/10 text-emerald-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-full border border-emerald-500/20">Level Operasional 5</span>
                    <div class="h-[1px] w-12 bg-slate-200"></div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Waktu Sistem: {{ now()->format('H:i:s') }} UTC</span>
                </div>
                <h2 class="text-5xl font-black text-slate-900 tracking-tighter leading-none">Pusat <span class="text-sky-500">Intelijen.</span></h2>
                <p class="text-slate-500 mt-4 max-w-xl text-sm leading-relaxed font-medium">
                    Mengakses arsitektur neural terpusat. Pantau vektor ancaman global dan kelola aset strategis Anda dari konsol aman ini.
                </p>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Skor Integritas</p>
                    <div class="flex items-center gap-2">
                        <div class="w-32 h-2 bg-slate-100 rounded-full overflow-hidden border border-slate-200/50">
                            <div class="w-[94%] h-full bg-gradient-to-r from-sky-500 to-indigo-600 rounded-full animate-pulse"></div>
                        </div>
                        <span class="text-xs font-black text-slate-900 leading-none">94.8%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Panel: Tactical Stats -->
            <div class="lg:col-span-8 space-y-8" data-aos="fade-up">
                <!-- Summary Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="glossy-card rounded-[2.5rem] p-8 border border-white shadow-xl group hover:shadow-2xl transition-all duration-500">
                        <div class="flex justify-between items-start mb-8">
                            <div class="w-14 h-14 bg-sky-500/10 rounded-2xl flex items-center justify-center text-sky-600 group-hover:bg-sky-500 group-hover:text-white transition-all transform group-hover:rotate-6 shadow-sm border border-sky-500/10">
                                <i class="ri-shield-flash-fill text-2xl"></i>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-500/10 px-2 py-1 rounded-lg border border-emerald-500/20 uppercase">+Aktif</span>
                        </div>
                        <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ number_format($totalLeakedFound) }}</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-2">Identitas Terekspos</p>
                        <div class="mt-6 pt-6 border-t border-slate-50 flex items-center justify-between text-[9px] font-bold uppercase tracking-widest">
                            <span class="text-slate-400">Total Kebocoran Terdeteksi</span>
                            <a href="{{ route('leak-check.index') }}" class="text-sky-600 hover:text-sky-700 transition-colors">Audit &rarr;</a>
                        </div>
                    </div>

                    <div class="glossy-card rounded-[2.5rem] p-8 border border-white shadow-xl group hover:shadow-2xl transition-all duration-500">
                        <div class="flex justify-between items-start mb-8">
                            <div class="w-14 h-14 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-600 group-hover:bg-indigo-500 group-hover:text-white transition-all transform group-hover:rotate-6 shadow-sm border border-indigo-500/10">
                                <i class="ri-pulse-fill text-2xl"></i>
                            </div>
                            <span class="text-[10px] font-bold text-sky-600 bg-sky-500/10 px-2 py-1 rounded-lg border border-sky-500/20 uppercase">Audit Intel</span>
                        </div>
                        <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ number_format($totalLeakChecks) }}</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-2">Pemeriksaan Sistem</p>
                        <div class="mt-6 pt-6 border-t border-slate-50">
                            <div class="flex gap-1.5 h-4 items-end">
                                @for($i=0; $i<12; $i++)
                                    <div class="w-full bg-indigo-100 rounded-full overflow-hidden group-hover:bg-indigo-200 transition-colors" style="height: {{ rand(40, 100) }}%">
                                        <div class="bg-indigo-500 w-full animate-pulse" style="height: 100%; animation-delay: {{ $i * 0.1 }}s"></div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="glossy-card rounded-[2.5rem] p-8 border border-white shadow-xl group hover:shadow-2xl transition-all duration-500 bg-slate-900 border-none">
                        <div class="flex justify-between items-start mb-8">
                            <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center text-sky-400 group-hover:bg-sky-400 group-hover:text-slate-900 transition-all transform group-hover:rotate-6 shadow-inner">
                                <i class="ri-robot-2-fill text-2xl"></i>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                                <span class="text-[9px] font-black text-emerald-400 uppercase tracking-[0.2em]">Neural Up</span>
                            </div>
                        </div>
                        <h3 class="text-4xl font-black text-black tracking-tighter">{{ number_format($totalAiInteractions) }}</h3>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mt-2 text-black/50">Interaksi AI Taktis</p>
                        <div class="mt-6 pt-6 border-t border-white/5">
                            <div class="flex justify-between items-center">
                                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Antrean Data: {{ $pendingRequests }}</span>
                                <div class="w-20 h-1.5 bg-white/5 rounded-full overflow-hidden">
                                     <div class="w-2/3 h-full bg-sky-500"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Global Threat Chart -->
                <div class="glossy-card rounded-[3rem] p-10 border border-white shadow-2xl relative overflow-hidden">
                    <div class="flex items-center justify-between mb-10 relative z-10">
                        <div>
                            <h4 class="text-xl font-black text-slate-900 uppercase tracking-tighter">Indeks Anomali Jaringan</h4>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-1">Data Telemetri Satelit • Pembaruan Langsung</p>
                        </div>
                        <div class="flex bg-slate-100 p-1.5 rounded-2xl border border-slate-200/50">
                            <button id="btn24h" onclick="switchChartPeriod('24h')" class="px-6 py-2 bg-white rounded-xl shadow-sm text-[10px] font-black uppercase tracking-widest text-slate-900 transition-all">24 Jam</button>
                            <button id="btn7d" onclick="switchChartPeriod('7d')" class="px-6 py-2 text-slate-400 text-[10px] font-black uppercase tracking-widest hover:text-slate-600 transition-all">7 Hari</button>
                        </div>
                    </div>
                    <div class="h-[400px] w-full relative z-10">
                        <canvas id="threatChartBig"></canvas>
                    </div>
                    <i class="ri-broadcast-fill absolute -bottom-20 -right-20 text-[25rem] text-slate-50 opacity-40 pointer-events-none"></i>
                </div>
            </div>

            <!-- Right Panel: Operations & Logs -->
            <div class="lg:col-span-4 space-y-8" data-aos="fade-left" data-aos-delay="200">
                <!-- User Card -->
                <div class="glossy-card rounded-[2.5rem] p-8 border border-white shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-[0.03]">
                        <i class="ri-user-secret-fill text-9xl"></i>
                    </div>
                    <div class="flex items-center gap-6 mb-8 relative z-10">
                        <div class="relative">
                            <div class="w-20 h-20 rounded-[2rem] overflow-hidden border-4 border-white shadow-xl group-hover:scale-105 transition-transform duration-500">
                                <img src="{{ auth()->user()->detail->avatar_url }}" class="w-full h-full object-cover" alt="profile">
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-7 h-7 bg-emerald-500 rounded-xl flex items-center justify-center border-4 border-white text-white shadow-lg">
                                <i class="ri-check-double-line text-sm"></i>
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-sky-600 uppercase tracking-[0.3em] mb-1">Terobervasi</p>
                            <h3 class="text-2xl font-black text-slate-900 tracking-tighter">{{ auth()->user()->username }}</h3>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="px-2.5 py-1 bg-slate-900 text-white rounded-lg text-[9px] font-black uppercase tracking-widest">ID: #{{ str_pad(auth()->id(), 4, '0', STR_PAD_LEFT) }}</span>
                                <span class="px-2.5 py-1 bg-sky-100 text-sky-700 rounded-lg text-[9px] font-black uppercase tracking-widest">Akses Alpha</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-3">
                        <a href="{{ route('profile.index') }}" class="flex flex-col items-center justify-center p-4 bg-slate-50 hover:bg-sky-50 transition-all rounded-[1.5rem] border border-slate-100 group">
                            <i class="ri-settings-4-fill text-xl text-slate-400 group-hover:text-sky-500 mb-2 transition-transform group-hover:rotate-90"></i>
                            <span class="text-[9px] font-black text-slate-500 group-hover:text-sky-600 uppercase tracking-widest text-center">Pengaturan</span>
                        </a>
                        <a href="/ai-agent/chat" class="flex flex-col items-center justify-center p-4 bg-slate-50 hover:bg-indigo-50 transition-all rounded-[1.5rem] border border-slate-100 group">
                            <i class="ri-robot-2-fill text-xl text-slate-400 group-hover:text-indigo-500 mb-2 transition-transform group-hover:scale-110"></i>
                            <span class="text-[9px] font-black text-slate-500 group-hover:text-indigo-600 uppercase tracking-widest text-center">Konsultasi</span>
                        </a>
                        <a href="{{ route('logout') }}" class="flex flex-col items-center justify-center p-4 bg-slate-50 hover:bg-rose-50 transition-all rounded-[1.5rem] border border-slate-100 group">
                            <i class="ri-logout-box-r-fill text-xl text-slate-400 group-hover:text-rose-500 mb-2"></i>
                            <span class="text-[9px] font-black text-slate-500 group-hover:text-rose-600 uppercase tracking-widest text-center">Keluar</span>
                        </a>
                    </div>
                </div>

                <!-- Tactical Feeds -->
                <div class="glossy-card rounded-[2.5rem] p-8 border border-white shadow-xl flex flex-col h-[650px]">
                    <h4 class="text-sm font-black text-slate-900 uppercase tracking-[0.2em] mb-8 flex items-center gap-3">
                        <div class="w-10 h-10 bg-sky-500/20 rounded-xl flex items-center justify-center text-sky-600 shadow-sm">
                             <i class="ri-radar-fill animate-spin-slow text-xl"></i>
                        </div>
                        Aliran Taktis Langsung
                    </h4>
                    
                    <div class="flex-1 overflow-y-auto space-y-4 custom-scrollbar pr-2">
                        @forelse($activities as $act)
                        <div class="group flex gap-5 p-5 rounded-[2rem] hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100 hover:shadow-sm">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center {{ $act['type'] == 'leak_check' ? 'text-sky-500 bg-sky-500/10' : 'text-indigo-500 bg-indigo-500/10' }} flex-shrink-0 group-hover:scale-110 transition-transform shadow-inner">
                                <i class="{{ $act['type'] == 'leak_check' ? 'ri-shield-keyhole-fill' : 'ri-folder-user-fill' }} text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start mb-1">
                                    <p class="text-[11px] font-black text-slate-900 truncate uppercase tracking-tighter">{{ $act['title'] }}</p>
                                    <span class="text-[8px] font-black text-slate-400 flex-shrink-0 uppercase">{{ $act['time'] }}</span>
                                </div>
                                <p class="text-[10px] text-slate-500 leading-relaxed font-medium">{{ $act['desc'] }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="h-full flex flex-col items-center justify-center text-center p-8">
                            <i class="ri-inbox-archive-fill text-4xl text-slate-200 mb-4"></i>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Belum ada aktivitas taktis terdeteksi</p>
                        </div>
                        @endforelse
                    </div>
                    
                    <button class="w-full py-5 mt-8 bg-slate-900 text-white rounded-[1.5rem] font-black text-[10px] uppercase tracking-[0.4em] hover:bg-sky-600 transition-all shadow-xl shadow-slate-900/10 active:scale-95 group">
                        Akses Log Audit Mendalam
                        <i class="ri-arrow-right-line ml-2 group-hover:translate-x-2 transition-transform inline-block"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 8s linear infinite;
    }

    /* Custom Scrollbar - Modern & Minimalist */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
        transition: background 0.3s ease;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Firefox */
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let threatChart;
    
    // Data dari backend
    const chartData = {
        '24h': {
            labels: {!! json_encode($labels24Hours) !!},
            data: {!! json_encode($data24Hours) !!}
        },
        '7d': {
            labels: {!! json_encode($labels7Days) !!},
            data: {!! json_encode($data7Days) !!}
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        const ctxBig = document.getElementById('threatChartBig').getContext('2d');
        
        // Minimalist gradient - subtle and clean
        const gradientBg = ctxBig.createLinearGradient(0, 0, 0, 400);
        gradientBg.addColorStop(0, 'rgba(14, 165, 233, 0.08)');
        gradientBg.addColorStop(1, 'rgba(14, 165, 233, 0)');

        threatChart = new Chart(ctxBig, {
            type: 'line',
            data: {
                labels: chartData['24h'].labels,
                datasets: [{
                    label: 'Anomali Terdeteksi',
                    data: chartData['24h'].data,
                    borderColor: '#0ea5e9',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#0ea5e9',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#0ea5e9',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 2,
                    fill: true,
                    backgroundColor: gradientBg,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                animation: {
                    duration: 800,
                    easing: 'easeInOutQuart'
                },
                plugins: {
                    legend: { 
                        display: false 
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: '#ffffff',
                        titleColor: '#0f172a',
                        titleFont: { 
                            size: 11, 
                            weight: '700', 
                            family: "'Plus Jakarta Sans'"
                        },
                        bodyColor: '#64748b',
                        bodyFont: { 
                            size: 13, 
                            weight: '600',
                            family: "'Plus Jakarta Sans'" 
                        },
                        padding: 14,
                        borderRadius: 12,
                        borderColor: '#e2e8f0',
                        borderWidth: 1,
                        displayColors: false,
                        caretSize: 6,
                        caretPadding: 10,
                        callbacks: {
                            title: function(context) {
                                return context[0].label;
                            },
                            label: function(context) {
                                return context.parsed.y + ' Anomali Terdeteksi';
                            },
                            afterLabel: function(context) {
                                const value = context.parsed.y;
                                if (value > 30) return 'Tingkat: Tinggi';
                                if (value > 15) return 'Tingkat: Sedang';
                                return 'Tingkat: Rendah';
                            }
                        },
                        // Minimalist shadow
                        shadowOffsetX: 0,
                        shadowOffsetY: 2,
                        shadowBlur: 8,
                        shadowColor: 'rgba(0, 0, 0, 0.08)'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grace: '5%',
                        grid: { 
                            color: '#f1f5f9',
                            drawBorder: false,
                            lineWidth: 1,
                            drawTicks: false
                        },
                        border: {
                            display: false
                        },
                        ticks: { 
                            color: '#94a3b8', 
                            font: { 
                                size: 10, 
                                weight: '600',
                                family: "'Inter', sans-serif"
                            }, 
                            padding: 12,
                            callback: function(value) {
                                return value;
                            }
                        }
                    },
                    x: {
                        grid: { 
                            display: false,
                            drawBorder: false
                        },
                        border: {
                            display: false
                        },
                        ticks: { 
                            color: '#94a3b8', 
                            font: { 
                                size: 10, 
                                weight: '600',
                                family: "'Inter', sans-serif"
                            }, 
                            padding: 10,
                            maxRotation: 0,
                            autoSkip: true,
                            autoSkipPadding: 15
                        }
                    }
                }
            }
        });
    });

    function switchChartPeriod(period) {
        // Update chart data
        threatChart.data.labels = chartData[period].labels;
        threatChart.data.datasets[0].data = chartData[period].data;
        threatChart.update();

        // Update button styles
        const btn24h = document.getElementById('btn24h');
        const btn7d = document.getElementById('btn7d');

        if (period === '24h') {
            btn24h.classList.add('bg-white', 'shadow-sm', 'text-slate-900');
            btn24h.classList.remove('text-slate-400');
            btn7d.classList.remove('bg-white', 'shadow-sm', 'text-slate-900');
            btn7d.classList.add('text-slate-400');
        } else {
            btn7d.classList.add('bg-white', 'shadow-sm', 'text-slate-900');
            btn7d.classList.remove('text-slate-400');
            btn24h.classList.remove('bg-white', 'shadow-sm', 'text-slate-900');
            btn24h.classList.add('text-slate-400');
        }
    }
</script>
@endsection
