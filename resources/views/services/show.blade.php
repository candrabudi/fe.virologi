@extends('layouts.app')

@section('meta_title', ($service->seo_title ?? $service->name) . ' | Expert Service')
@section('meta_description', $service->seo_description ?? Str::limit(strip_tags($service->summary), 160))

@section('content')
<div class="bg-white min-h-screen" x-data="serviceDetail('{{ $service->slug }}')">
    <!-- Global Loading State -->
    <div x-show="loading" class="fixed inset-0 z-[9999] bg-white flex items-center justify-center">
        <div class="space-y-4 text-center">
            <div class="w-12 h-12 border-4 border-slate-900 border-t-indigo-500 rounded-full animate-spin mx-auto"></div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Hydrating Service Node...</p>
        </div>
    </div>

    <!-- 1. CINEMATIC DETAIL HERO -->
    <section class="relative pt-32 pb-16 lg:pt-48 lg:pb-32 overflow-hidden px-4 sm:px-6 lg:px-8 border-b border-slate-50" x-data="{ mouseX: 0, mouseY: 0 }"
        @mousemove="mouseX = $event.clientX; mouseY = $event.clientY">
        
        <!-- Advanced Cyber Grid Background (Indigo Theme) -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <svg class="absolute inset-0 w-full h-full opacity-[0.1]">
                <defs>
                    <linearGradient id="grid-grad-svc-show" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="transparent" />
                        <stop offset="50%" stop-color="#4f46e5" />
                        <stop offset="100%" stop-color="transparent" />
                    </linearGradient>
                </defs>
                <g stroke="#cbd5e1" stroke-width="0.5" fill="none">
                    <path d="M 0,100 L 2000,100" />
                    <path d="M 0,300 L 2000,300" />
                    <path d="M 0,500 L 2000,500" />
                    <path d="M 100,0 L 100,1000" />
                    <path d="M 400,0 L 400,1000" />
                    <path d="M 800,0 L 800,1000" />
                    <path d="M 1200,0 L 1200,1000" />
                </g>
                <path d="M 0,300 L 2000,300" stroke="url(#grid-grad-svc-show)" stroke-width="1.5" fill="none" class="animate-data-flow" style="stroke-dasharray: 100, 1000;" />
                
                <!-- Animated Cog -->
                <g class="animate-slow-spin origin-[800px_300px] opacity-[0.15]">
                    <circle cx="800" cy="300" r="110" stroke="#4f46e5" stroke-width="1" stroke-dasharray="10 20" fill="none" />
                    @foreach([0, 30, 60, 90, 120, 150, 180, 210, 240, 270, 300, 330] as $angle)
                        <line x1="800" y1="190" x2="800" y2="210" stroke="#4f46e5" stroke-width="2" transform="rotate({{ $angle }} 800 300)" />
                    @endforeach
                </g>
            </svg>
            <div class="absolute -top-[10%] -left-[5%] w-[500px] h-[500px] bg-indigo-100/30 rounded-full blur-[100px] animate-blob"></div>
            <div class="absolute top-[20%] -right-[5%] w-[600px] h-[600px] bg-sky-50/40 rounded-full blur-[120px] animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex items-center space-x-4 mb-10 text-[10px] uppercase tracking-[0.2em] font-bold text-slate-400" data-aos="fade-right">
                <a href="{{ route('services.index') }}" class="hover:text-indigo-600 transition-colors">Expertise</a>
                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-900" x-text="service?.category?.replace('_', ' ') || '{{ $service->category }}'"></span>
            </nav>

            <div class="max-w-5xl" x-show="service">
                <div class="inline-flex items-center px-4 py-1.5 border border-indigo-100 bg-indigo-50/50 rounded-full mb-8" data-aos="fade-right">
                    <div class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-ping mr-3"></div>
                    <span class="text-[9px] sm:text-[10px] font-bold text-indigo-600 uppercase tracking-[0.3em]">Operational Service // High Priority</span>
                </div>

                <h1 class="text-4xl sm:text-6xl md:text-7xl lg:text-8xl font-black heading-font leading-[1] mb-10 text-slate-950 tracking-tighter"
                    data-aos="fade-up" data-aos-delay="100" x-text="service.name">
                </h1>

                <p class="text-sm sm:text-xl text-slate-800 mb-0 max-w-3xl leading-relaxed font-medium"
                    data-aos="fade-up" data-aos-delay="200" x-text="service.summary">
                </p>
            </div>
        </div>
    </section>

    <!-- 2. SERVICE BODY & SIDEBAR -->
    <section class="py-16 lg:py-24 relative z-10 px-4 sm:px-6 lg:px-8 bg-[#fafafa]/50">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
                
                <!-- Main Service Content -->
                <div class="lg:col-span-8" x-show="service">
                    <!-- Featured Image -->
                    <div class="rounded-[3rem] overflow-hidden shadow-[0_40px_100px_rgba(0,0,0,0.1)] mb-16 aspect-video bg-slate-100 border border-slate-100" data-aos="zoom-in">
                        <img :src="service.thumbnail" class="w-full h-full object-cover" :alt="service.name">
                    </div>

                    <!-- Technical Content -->
                    <article class="max-w-none text-left space-y-10" data-aos="fade-up">
                        <h2 class="text-3xl font-black text-slate-950 mb-8 tracking-tight heading-font">Layanan Deskripsi & Cakupan Efektif</h2>
                        <div class="service-content space-y-8 text-slate-900 text-lg leading-relaxed font-medium" x-html="service.description"></div>

                        <!-- Scope Tags -->
                        <div class="pt-16 border-t border-slate-200/60" x-show="service.service_scope && service.service_scope.length > 0">
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Service Scope // Technical Boundaries</h4>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="scope in service.service_scope">
                                    <span class="px-5 py-2.5 bg-white border border-slate-100 text-slate-900 text-[10px] font-black uppercase tracking-widest rounded-xl shadow-sm" x-text="scope"></span>
                                </template>
                            </div>
                        </div>

                        <!-- Deliverables -->
                        <div class="pt-10" x-show="service.deliverables && service.deliverables.length > 0">
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Deliverables // Intelligence Output</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <template x-for="del in service.deliverables">
                                    <div class="flex items-center space-x-3 p-4 bg-slate-900 rounded-2xl text-white">
                                        <div class="w-2 h-2 rounded-full bg-indigo-400"></div>
                                        <span class="text-xs font-bold uppercase tracking-widest" x-text="del"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- CTA -->
                        <div class="pt-16 border-t border-slate-200/60" x-show="service.cta_label">
                            <a :href="service.cta_url || '/contact'" class="inline-flex items-center space-x-6 px-12 py-6 bg-indigo-600 text-white rounded-[2rem] font-black text-sm hover:translate-y-[-2px] transition-all shadow-2xl shadow-indigo-900/20 active:scale-95 group uppercase tracking-widest">
                                <span x-text="service.cta_label"></span>
                                <svg class="w-6 h-6 transform transition-transform group-hover:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                </div>

                <!-- Strategic Sidebar -->
                <aside class="lg:col-span-4" x-show="service">
                    <div class="sticky top-32 space-y-12">
                        
                        <!-- Operational Meta Box -->
                        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-10 shadow-sm" data-aos="fade-left">
                            <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-8 border-b border-slate-50 pb-4">Operational Meta</h4>
                            <div class="space-y-6">
                                <div class="flex justify-between items-center border-b border-slate-50 pb-4">
                                    <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">Category</span>
                                    <span class="text-xs text-slate-950 font-black uppercase tracking-tight" x-text="service.category?.replace('_', ' ')"></span>
                                </div>
                                <div class="flex justify-between items-center border-b border-slate-50 pb-4">
                                    <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">SLA Node</span>
                                    <span class="text-xs text-indigo-600 font-black uppercase tracking-tight">Active Response</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">Visibility</span>
                                    <span class="text-xs text-slate-950 font-black uppercase tracking-tight" x-text="service.is_ai_visible ? 'Public' : 'Classified'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Related Services -->
                        <div class="bg-slate-950 rounded-[2.5rem] p-10 relative overflow-hidden text-white" data-aos="fade-left" data-aos-delay="100">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl"></div>
                            <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-8 border-b border-white/5 pb-4 relative z-10">Connected Expertise</h4>
                            <div class="space-y-6 relative z-10">
                                <template x-for="rel in related" :key="rel.id">
                                    <a :href="'/layanan/' + rel.slug" class="group block">
                                        <h5 class="text-sm font-bold text-white group-hover:text-indigo-400 transition-colors mb-1" x-text="rel.name"></h5>
                                        <p class="text-[10px] text-slate-500 uppercase font-black tracking-widest" x-text="rel.category.replace('_', ' ')"></p>
                                    </a>
                                </template>
                            </div>
                        </div>

                    </div>
                </aside>

            </div>
        </div>
    </section>

    <!-- 3. STRATEGIC CTA -->
    <section class="py-24 lg:py-40 relative overflow-hidden px-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-indigo-950 rounded-[3rem] p-8 md:p-16 lg:p-24 relative overflow-hidden text-white shadow-2xl">
                <div class="absolute inset-0 opacity-10 pointer-events-none"
                    style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 40px 40px;"></div>
                
                <div class="relative z-10 max-w-3xl" data-aos="fade-right">
                    <div class="inline-flex items-center px-4 py-2 border border-white/10 bg-white/5 rounded-full mb-8">
                        <span class="text-[9px] font-bold text-indigo-400 uppercase tracking-[0.3em]">Institutional Grade Security</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl md:text-7xl font-bold heading-font text-white mb-8 tracking-tighter leading-tight">
                        Protect your <br/> <span class="bg-gradient-to-r from-indigo-400 to-cyan-400 bg-clip-text text-transparent">Strategic Assets.</span>
                    </h2>
                    <p class="text-slate-400 text-lg mb-12 font-light leading-relaxed">
                        Kami menyediakan lapisan perlindungan yang tak tertandingi untuk institusi riset dan infrastruktur kritis global.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        <a href="{{ route('contact') }}" class="w-full sm:w-auto px-12 py-5 bg-white text-slate-950 rounded-2xl font-black text-xs hover:translate-y-[-1px] transition-all active:scale-95 text-center uppercase tracking-widest">
                            TALK TO ANALYST
                        </a>
                        <a href="{{ route('services.index') }}" class="w-full sm:w-auto px-12 py-5 border border-white/20 text-white rounded-2xl font-black text-xs hover:bg-white/5 transition-all text-center uppercase tracking-widest">
                            BACK TO CATALOG
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('serviceDetail', (slug) => ({
            loading: true,
            service: null,
            related: [],
            
            async init() {
                await this.fetchService();
            },

            async fetchService() {
                this.loading = true;
                try {
                    const response = await axios.get('/api/services/' + slug);
                    this.service = response.data.service;
                    this.related = response.data.related;
                } catch (e) {
                    console.error('Failed to fetch service detail', e);
                } finally {
                    this.loading = false;
                    setTimeout(() => {
                        if (window.AOS) window.AOS.refresh();
                    }, 100);
                }
            }
        }));
    });
</script>

<style>
    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }
    .animate-blob { animation: blob 10s infinite; }
    .animation-delay-2000 { animation-delay: 2s; }
    @keyframes animate-data-flow {
        0% { stroke-dashoffset: 1000; }
        100% { stroke-dashoffset: -1000; }
    }
    @keyframes slow-spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-data-flow { animation: animate-data-flow 15s linear infinite; }
    .animate-slow-spin { animation: slow-spin 30s linear infinite; }

    /* Service Content Styling */
    .service-content h3 {
        font-size: 1.875rem;
        font-weight: 900;
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #020617;
    }
    .service-content p {
        margin-bottom: 1.5rem;
        color: #475569;
    }
    .service-content ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .service-content li {
        margin-bottom: 0.5rem;
    }
</style>
@endsection
