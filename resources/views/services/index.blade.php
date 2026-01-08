@extends('layouts.app')

@section('meta_title', ($page_settings->meta_title ?? 'Cyber Security Services') . ' | RD-VIROLOGI')
@section('meta_description', $page_settings->meta_description ?? 'Professional cyber security services including SOC, PenTest, Audit, and Incident Response.')
@section('meta_keywords', $page_settings->meta_keywords ?? 'cybersecurity services, soc managed services, penetration testing, security audit, incident response')

@section('content')
<div class="bg-white min-h-screen" x-data="servicesData()">
    <!-- Global Loading State -->
    <div x-show="loading" class="fixed inset-0 z-[9999] bg-white flex items-center justify-center">
        <div class="space-y-4 text-center">
            <div class="w-12 h-12 border-4 border-slate-900 border-t-indigo-500 rounded-full animate-spin mx-auto"></div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Accessing Service Node...</p>
        </div>
    </div>

    <!-- 1. CINEMATIC HERO SECTION (Matching Products Style) -->
    <section class="relative pt-32 pb-16 lg:pt-48 lg:pb-32 overflow-hidden px-4 sm:px-6 lg:px-8 border-b border-slate-50" x-data="{ mouseX: 0, mouseY: 0 }"
        @mousemove="mouseX = $event.clientX; mouseY = $event.clientY">
        
        <!-- Advanced Cyber Grid Background (Indigo Version) -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <svg class="absolute inset-0 w-full h-full opacity-[0.15]">
                <defs>
                    <linearGradient id="grid-grad-svc" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="transparent" />
                        <stop offset="50%" stop-color="#6366f1" />
                        <stop offset="100%" stop-color="transparent" />
                    </linearGradient>
                </defs>

                <!-- Static Background Grid -->
                <g stroke="#cbd5e1" stroke-width="0.5" fill="none">
                    <path d="M 0,100 L 2000,100" />
                    <path d="M 0,300 L 2000,300" />
                    <path d="M 0,500 L 2000,500" />
                    <path d="M 100,0 L 100,1000" />
                    <path d="M 400,0 L 400,1000" />
                    <path d="M 800,0 L 800,1000" />
                    <path d="M 1200,0 L 1200,1000" />
                </g>

                <!-- Animated Data Lines -->
                <path d="M 0,300 L 2000,300" stroke="url(#grid-grad-svc)" stroke-width="1.5" fill="none" class="animate-data-flow" style="stroke-dasharray: 100, 1000;" />
                
                <!-- Animated Cyber Cog -->
                <g class="animate-slow-spin origin-[800px_300px] opacity-[0.2]">
                    <circle cx="800" cy="300" r="100" stroke="#6366f1" stroke-width="1" stroke-dasharray="10 20" fill="none" />
                    @foreach(range(0, 360, 30) as $angle)
                        <line x1="800" y1="200" x2="800" y2="220" stroke="#6366f1" stroke-width="2" transform="rotate({{ $angle }} 800 300)" />
                    @endforeach
                </g>
            </svg>

            <!-- Smooth Mesh Gradients -->
            <div class="absolute -top-[10%] -left-[5%] w-[500px] h-[500px] bg-indigo-100/40 rounded-full blur-[100px] animate-blob"></div>
            <div class="absolute top-[20%] -right-[5%] w-[600px] h-[600px] bg-sky-50/50 rounded-full blur-[120px] animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="max-w-3xl text-left">
                <div class="inline-flex items-center px-4 py-1 border border-indigo-100 bg-indigo-50/50 rounded-full mb-8" data-aos="fade-right">
                    <div class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-ping mr-3"></div>
                    <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-[0.3em]" x-text="page.hero_subtitle || 'Operational Support // Expertise Catalog'"></span>
                </div>

                <h1 class="text-4xl sm:text-6xl md:text-7xl lg:text-8xl font-black heading-font leading-[1] mb-8 text-slate-950 tracking-tighter"
                    data-aos="fade-right" data-aos-delay="100" x-html="page.hero_title || 'Cyber Security <br /> Expertise Base.'">
                </h1>

                <p class="text-sm sm:text-xl text-slate-500 mb-10 max-w-2xl leading-relaxed font-light"
                    data-aos="fade-right" data-aos-delay="200" x-text="page.hero_description || 'Mitigasi risiko dan perlindungan infrastruktur digital melalui pendekatan intelijen teknis tingkat tinggi.'">
                </p>

                <div class="flex flex-wrap gap-4" data-aos="fade-right" data-aos-delay="300">
                    <a :href="page.primary_button_url || '#explore'" class="px-8 py-4 bg-slate-900 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:translate-y-[-2px] transition-all shadow-xl shadow-slate-100 active:scale-95" x-text="page.primary_button_text || 'Lihat Katalog'"></a>
                    <a :href="page.secondary_button_url || '{{ route('contact') }}'" class="px-8 py-4 border border-slate-200 text-slate-600 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-50 transition-all" x-text="page.secondary_button_text || 'Konsultasi Ahli'"></a>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. FILTER & SERVICE GRID -->
    <section id="explore" class="py-16 lg:py-24 relative z-10 px-4 sm:px-6 lg:px-8 bg-[#fafafa]/50">
        <div class="max-w-7xl mx-auto">
            
            <!-- Toolbar -->
            <div class="flex flex-col lg:flex-row items-center justify-between mb-12 lg:mb-20 gap-8" data-aos="fade-up">
                <!-- Categories Tab -->
                <div class="flex items-center space-x-2 overflow-x-auto pb-4 lg:pb-0 w-full lg:w-auto no-scrollbar">
                    <template x-for="cat in categories" :key="cat">
                        <button @click="setCategory(cat)" :class="selectedCategory === cat ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-200' : 'bg-white text-slate-400 border border-slate-100 hover:border-indigo-300 hover:text-indigo-600'" 
                            class="flex-none px-6 py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all">
                            <span x-text="cat.replace('_', ' ')"></span>
                        </button>
                    </template>
                </div>

                <!-- Clean Search Bar -->
                <div class="relative w-full lg:w-80 group">
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400 group-focus-within:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" placeholder="Cari layanan teknis..." x-model.debounce.500ms="searchQuery"
                        class="w-full bg-white border border-slate-100 rounded-2xl py-4 pl-12 pr-4 text-sm text-slate-900 placeholder-slate-400 focus:ring-4 focus:ring-indigo-900/5 focus:border-indigo-600 transition-all outline-none">
                </div>
            </div>

            <!-- Service Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
                <template x-for="(service, index) in serviceList" :key="service.id">
                    <div class="group" data-aos="fade-up" :data-aos-delay="index * 50">
                        <!-- Premium Minimal Card -->
                        <div class="relative flex flex-col h-full bg-white border border-slate-100 rounded-[2.5rem] overflow-hidden transition-all duration-500 hover:shadow-[0_32px_80px_-20px_rgba(99,102,241,0.12)] hover:-translate-y-2">
                            
                            <!-- Thumbnail with Category Badge -->
                            <div class="relative aspect-video overflow-hidden bg-slate-100">
                                <img :src="service.thumbnail" :alt="service.name" 
                                    class="w-full h-full object-cover transition-all duration-700 group-hover:scale-105 opacity-90 group-hover:opacity-100">
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-white/20 via-transparent to-transparent"></div>
                                
                                <!-- Category Badge -->
                                <div class="absolute top-6 left-6 px-3 py-1.5 bg-white/90 backdrop-blur-md border border-slate-100 rounded-xl shadow-sm">
                                    <span class="text-[9px] font-bold text-indigo-600 uppercase tracking-widest" x-text="service.category.replace('_', ' ')"></span>
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-8 lg:p-10 flex flex-col flex-1">
                                <h3 class="text-2xl font-bold text-slate-900 heading-font mb-4 tracking-tight group-hover:text-indigo-600 transition-colors" x-text="service.name"></h3>
                                <p class="text-slate-500 text-sm leading-relaxed line-clamp-3 font-light mb-8" x-text="service.summary"></p>

                                <div class="mt-auto pt-6 border-t border-slate-50">
                                    <a :href="'/layanan/' + service.slug" 
                                        class="inline-flex items-center space-x-3 text-[10px] font-bold text-slate-900 uppercase tracking-widest group/btn border-b-2 border-slate-100 pb-1 group-hover:border-indigo-500 transition-all">
                                        <span>Konfigurasi Node</span>
                                        <svg class="w-4 h-4 transform transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            
            <!-- Empty State -->
            <div x-show="serviceList.length === 0 && !loading" class="py-20 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h4 class="text-xl font-bold text-slate-900 mb-2">Layanan Tidak Ditemukan</h4>
                <p class="text-slate-500 text-sm mb-8">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
                <button @click="resetFilters()" class="px-8 py-3 bg-slate-900 text-white rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-indigo-600">Reset Search</button>
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
                        Scale your <br/> <span class="bg-gradient-to-r from-indigo-400 to-cyan-400 bg-clip-text text-transparent">Strategic Edge.</span>
                    </h2>
                    <p class="text-slate-400 text-lg mb-12 font-light leading-relaxed">
                        Beyond basic support. We provide institutional-grade cybersecurity expertise for path-breaking research and global-scale operations.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        <a href="{{ route('contact') }}" class="w-full sm:w-auto px-12 py-5 bg-white text-slate-950 rounded-2xl font-black text-xs hover:translate-y-[-1px] transition-all active:scale-95 text-center uppercase tracking-widest">
                            TALK TO ANALYST
                        </a>
                        <a href="{{ url('/') }}" class="w-full sm:w-auto px-12 py-5 border border-white/20 text-white rounded-2xl font-black text-xs hover:bg-white/5 transition-all text-center uppercase tracking-widest">
                            BACK TO BASE
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('servicesData', () => ({
            loading: true,
            page: {},
            serviceList: [],
            categories: [],
            selectedCategory: 'all',
            searchQuery: '',

            async init() {
                await Promise.all([
                    this.fetchPageData(),
                    this.fetchCategories(),
                    this.fetchServices()
                ]);

                this.$watch('selectedCategory', () => this.fetchServices());
                this.$watch('searchQuery', () => this.fetchServices());
            },

            async fetchPageData() {
                try {
                    const response = await axios.get('/api/page/services');
                    this.page = response.data;
                } catch (e) {
                    console.error('Failed to load services page data', e);
                }
            },

            async fetchCategories() {
                try {
                    const response = await axios.get('/api/services/categories');
                    this.categories = response.data;
                } catch (e) {
                    console.error('Failed to fetch categories', e);
                }
            },

            async fetchServices() {
                this.loading = true;
                try {
                    const params = {
                        category: this.selectedCategory,
                        search: this.searchQuery
                    };
                    const response = await axios.get('/api/services', { params });
                    this.serviceList = response.data;
                } catch (e) {
                    console.error('Failed to fetch services', e);
                } finally {
                    this.loading = false;
                    setTimeout(() => {
                        if (window.AOS) window.AOS.refresh();
                    }, 100);
                }
            },

            setCategory(cat) {
                this.selectedCategory = cat;
            },

            resetFilters() {
                this.selectedCategory = 'all';
                this.searchQuery = '';
            }
        }));
    });
</script>

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
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
</style>
@endsection
