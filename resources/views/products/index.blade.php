@extends('layouts.app')

@section('meta_title', 'Operational Ecosystem | Advanced Security Solutions')
@section('meta_description', 'Discover our cutting-edge cybersecurity tools, AI firewalls, and pathogen analysis platforms designed for high-consequence environments.')
@section('meta_keywords', 'cybersecurity products, ai firewall, biosecurity tools, pathogen analysis software, virology lab tools')

@section('content')
<div class="bg-white min-h-screen" x-data="productsData()">
    <!-- Global Loading State -->
    <div x-show="loading" class="fixed inset-0 z-[9999] bg-white flex items-center justify-center">
        <div class="space-y-4 text-center">
            <div class="w-12 h-12 border-4 border-slate-900 border-t-sky-500 rounded-full animate-spin mx-auto"></div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Loading Security Systems...</p>
        </div>
    </div>
    <!-- 1. MINIMALIST LIGHT HERO SECTION -->
    <section class="relative pt-32 pb-16 lg:pt-48 lg:pb-32 overflow-hidden px-4 sm:px-6 lg:px-8 border-b border-slate-50" x-data="{ mouseX: 0, mouseY: 0 }"
        @mousemove="mouseX = $event.clientX; mouseY = $event.clientY">
        
        <!-- Advanced Cyber Grid Background (Light Version) -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <!-- Animated SVG Grid -->
            <svg class="absolute inset-0 w-full h-full opacity-[0.15]">
                <defs>
                    <linearGradient id="grid-grad" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="transparent" />
                        <stop offset="50%" stop-color="#0ea5e9" />
                        <stop offset="100%" stop-color="transparent" />
                    </linearGradient>
                    <filter id="glow-light">
                        <feGaussianBlur stdDeviation="1.5" result="blur" />
                        <feMerge>
                            <feMergeNode in="blur" />
                            <feMergeNode in="SourceGraphic" />
                        </feMerge>
                    </filter>
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
                <path d="M 0,300 L 2000,300" stroke="url(#grid-grad)" stroke-width="1.5" fill="none" class="animate-data-flow" filter="url(#glow-light)" style="stroke-dasharray: 100, 1000;" />
                <path d="M 400,0 L 400,1000" stroke="url(#grid-grad)" stroke-width="1.5" fill="none" class="animate-data-flow-vertical" filter="url(#glow-light)" style="stroke-dasharray: 100, 1000;" />
                <path d="M 1200,0 L 1200,1000" stroke="url(#grid-grad)" stroke-width="1.5" fill="none" class="animate-data-flow-vertical" filter="url(#glow-light)" style="stroke-dasharray: 100, 1000; animation-delay: 2s;" />
                
                <!-- Animated Cyber Cog / Tactical Element -->
                <g class="animate-slow-spin origin-[800px_300px] opacity-[0.2]">
                    <!-- Outer Gear -->
                    <circle cx="800" cy="300" r="100" stroke="#0ea5e9" stroke-width="1" stroke-dasharray="10 20" fill="none" />
                    <!-- Inner Gear Teeth / Lines -->
                    @foreach(range(0, 360, 30) as $angle)
                        <line x1="800" y1="200" x2="800" y2="220" stroke="#0ea5e9" stroke-width="2" transform="rotate({{ $angle }} 800 300)" />
                    @endforeach
                    <!-- Middle Ring -->
                    <circle cx="800" cy="300" r="70" stroke="#6366f1" stroke-width="0.5" fill="none" class="animate-pulse" />
                </g>
                
                <!-- Secondary Counter-Rotating Cog -->
                <g class="animate-slow-spin-reverse origin-[400px_500px] opacity-[0.1]">
                    <circle cx="400" cy="500" r="60" stroke="#0ea5e9" stroke-width="1" stroke-dasharray="5 10" fill="none" />
                    @foreach(range(0, 360, 45) as $angle)
                        <line x1="400" y1="440" x2="400" y2="455" stroke="#0ea5e9" stroke-width="1.5" transform="rotate({{ $angle }} 400 500)" />
                    @endforeach
                </g>

                <!-- Pulsing Nodes -->
                <circle cx="400" cy="300" r="3" fill="#0ea5e9" class="animate-pulse" />
                <circle cx="1200" cy="300" r="3" fill="#6366f1" class="animate-pulse" style="animation-delay: 1s;" />
                <circle cx="800" cy="500" r="2" fill="#0ea5e9" opacity="0.5" />
            </svg>

            <!-- Smooth Mesh Gradients -->
            <div class="absolute -top-[10%] -left-[5%] w-[500px] h-[500px] bg-sky-100/40 rounded-full blur-[100px] animate-blob"></div>
            <div class="absolute top-[20%] -right-[5%] w-[600px] h-[600px] bg-indigo-50/50 rounded-full blur-[120px] animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="max-w-3xl text-left">
                <div class="inline-flex items-center px-4 py-1 border border-sky-100 bg-sky-50/50 rounded-full mb-6 sm:mb-8"
                    data-aos="fade-right">
                    <div class="w-1 h-1 rounded-full bg-sky-500 animate-ping mr-2"></div>
                    <span class="text-[8px] sm:text-[10px] font-bold text-sky-600 uppercase tracking-[0.2em] sm:tracking-[0.3em]" x-text="page.hero_subtitle || 'Operational Ecosystem // V2.0'"></span>
                </div>

                <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold heading-font leading-[1.2] sm:leading-[1.1] mb-4 sm:mb-8 text-slate-900 tracking-tight sm:tracking-tighter"
                    data-aos="fade-right" data-aos-delay="100" x-html="page.hero_title || 'Security <br /> <span class=\'bg-gradient-to-r from-sky-500 to-indigo-500 bg-clip-text text-transparent\'>Infrastructure.</span>'">
                </h1>

                <p class="text-[13px] sm:text-xl text-slate-500 mb-6 sm:mb-10 max-w-2xl leading-relaxed font-light"
                    data-aos="fade-right" data-aos-delay="200" x-text="page.hero_description || 'Next-generation architectural patterns and investigative research tools designed for the modern, high-consequence enterprise.'">
                </p>

                <div class="flex flex-wrap gap-3 sm:gap-4" data-aos="fade-right" data-aos-delay="300">
                    <a :href="page.primary_button_url || '#explore'" class="flex-1 sm:flex-none px-6 sm:px-8 py-3.5 sm:py-4 bg-slate-900 text-white rounded-xl font-bold text-xs sm:text-sm hover:translate-y-[-2px] transition-all shadow-xl shadow-slate-100 active:scale-95 text-center" x-text="page.primary_button_text || 'Browse Solutions'">
                        Browse Solutions
                    </a>
                    <a :href="page.secondary_button_url || '#contact'" class="flex-1 sm:flex-none px-6 sm:px-8 py-3.5 sm:py-4 border border-slate-200 text-slate-600 rounded-xl font-bold text-xs sm:text-sm hover:bg-slate-50 transition-all text-center" x-text="page.secondary_button_text || 'Talk to Architect'">
                        Talk to Architect
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. FILTER & PRODUCT GRID -->
    <section id="explore" class="py-16 lg:py-24 relative z-10 px-4 sm:px-6 lg:px-8 bg-[#fafafa]/50">
        <div class="max-w-7xl mx-auto">
            
            <!-- Minimalist Toolbar -->
            <div class="flex flex-col lg:flex-row items-center justify-between mb-12 lg:mb-20 gap-8" data-aos="fade-up">
                <!-- Domain Tabs -->
                <div class="flex items-center space-x-2 overflow-x-auto pb-4 lg:pb-0 w-full lg:w-auto no-scrollbar">
                    <template x-for="domain in domains" :key="domain">
                        <button @click="setDomain(domain)" :class="selectedDomain === domain ? 'bg-slate-900 text-white shadow-xl shadow-slate-200' : 'bg-white text-slate-400 border border-slate-100 hover:border-slate-300 hover:text-slate-600'" 
                            class="flex-none px-6 py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all">
                            <span x-text="domain.replace('_', ' ')"></span>
                        </button>
                    </template>
                </div>

                <!-- Clean Search Bar -->
                <div class="relative w-full lg:w-80 group">
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400 group-focus-within:text-slate-900 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" placeholder="Search operational systems..." x-model.debounce.500ms="searchQuery"
                        class="w-full bg-white border border-slate-100 rounded-2xl py-4 pl-12 pr-4 text-sm text-slate-900 placeholder-slate-400 focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 transition-all outline-none">
                </div>
            </div>

            <!-- Product Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
                <template x-for="(product, index) in productList" :key="product.id">
                    <div class="group" data-aos="fade-up" :data-aos-delay="index * 50">
                        <!-- Minimal Light Card -->
                        <div class="relative flex flex-col h-full bg-white border border-slate-100 rounded-[2.5rem] overflow-hidden transition-all duration-500 hover:shadow-[0_32px_80px_-20px_rgba(0,0,0,0.08)] hover:-translate-y-2">
                            
                            <!-- Image Container -->
                            <div class="relative aspect-square overflow-hidden bg-slate-50">
                                <img :src="product.thumbnail || product.primaryImage?.image_path" :alt="product.name" 
                                    class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-105 opacity-90">
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-white/20 via-transparent to-transparent"></div>
                                
                                <!-- Category Badge -->
                                <div class="absolute top-6 left-6 px-3 py-1.5 bg-white/90 backdrop-blur-md border border-slate-100 rounded-xl shadow-sm">
                                    <span class="text-[9px] font-bold text-slate-600 uppercase tracking-widest" x-text="product.ai_domain.replace('_', ' ')"></span>
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-6 sm:p-8 lg:p-10 flex flex-col flex-1">
                                <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-slate-900 heading-font mb-3 sm:mb-4 tracking-tight group-hover:text-sky-600 transition-colors" x-text="product.name"></h3>
                                <p class="text-slate-500 text-xs sm:text-sm leading-relaxed line-clamp-3 font-light mb-6 sm:mb-8" x-text="product.summary"></p>

                                <div class="mt-auto pt-6">
                                    <a :href="'/products/' + product.slug" 
                                        class="inline-flex items-center space-x-3 text-[10px] font-bold text-slate-900 uppercase tracking-widest group/btn border-b-2 border-slate-100 pb-1 group-hover:border-sky-500 transition-all">
                                        <span>Explore System</span>
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
            <template x-if="productList.length === 0 && !loading">
                <div class="py-20 text-center">
                    <h3 class="text-xl font-bold text-slate-950 heading-font mb-4">No Products Found</h3>
                    <button @click="resetFilters()" class="px-8 py-3 bg-slate-900 text-white rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-sky-600">Reset Search</button>
                </div>
            </template>

            <!-- Modern Pagination -->
            <template x-if="pagination.last_page > 1">
                <div class="mt-20 lg:mt-32 flex justify-center" data-aos="fade-up">
                    <nav class="flex items-center space-x-2">
                        <button @click="prevPage()" :disabled="pagination.current_page === 1" 
                            class="w-12 h-12 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-600 hover:border-sky-500 hover:text-sky-500 transition-all disabled:opacity-30 disabled:cursor-not-allowed shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        
                        <span class="w-12 h-12 flex items-center justify-center rounded-xl bg-slate-900 text-white font-bold text-sm shadow-xl shadow-slate-200 cursor-default" x-text="pagination.current_page"></span>
                        
                        <button @click="nextPage()" :disabled="pagination.current_page === pagination.last_page" 
                            class="w-12 h-12 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-600 hover:border-sky-500 hover:text-sky-500 transition-all disabled:opacity-30 disabled:cursor-not-allowed shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </nav>
                </div>
            </template>
                    </a>

                    {{-- Next Page --}}
                    <a href="#" class="w-12 h-12 flex items-center justify-center rounded-xl bg-white text-slate-600 border border-slate-100 hover:border-sky-500 hover:text-sky-500 transition-all active:scale-95 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </nav>
            </div>
        </div>
    </section>

    <!-- 3. STRATEGIC CTA (LIGHT) -->
    <section id="contact" class="py-24 lg:py-40 relative overflow-hidden px-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-slate-900 rounded-[3rem] p-8 md:p-16 lg:p-24 relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10 pointer-events-none"
                    style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 40px 40px;"></div>
                
                <div class="relative z-10 max-w-3xl" data-aos="fade-right">
                    <div class="inline-flex items-center px-4 py-2 border border-white/10 bg-white/5 rounded-full mb-6 sm:mb-8">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.3em]">Custom Integration</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl md:text-7xl font-bold heading-font text-white mb-6 sm:mb-8 tracking-tighter leading-tight">
                        Need a bespoke <br class="hidden sm:block"/> <span class="bg-gradient-to-r from-sky-400 to-indigo-400 bg-clip-text text-transparent">Configuration?</span>
                    </h2>
                    <p class="text-slate-400 text-sm sm:text-lg mb-8 sm:mb-12 font-light leading-relaxed">
                        Architect your own secure infrastructure with our custom laboratory integration services. Our world-class specialists are ready to build the infrastructure your research demands.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        <a href="#" class="w-full sm:w-auto px-12 py-5 bg-white text-slate-950 rounded-2xl font-bold text-sm hover:translate-y-[-2px] transition-all active:scale-95 text-center">
                            Start Consultation
                        </a>
                        <a href="#" class="w-full sm:w-auto px-12 py-5 border border-white/20 text-white rounded-2xl font-bold text-sm hover:bg-white/5 transition-all text-center">
                            View Case Studies
                        </a>
                    </div>
                </div>

                <!-- Abstract Decorative Element -->
                <div class="hidden lg:block absolute top-[10%] -right-20 w-96 h-96 border border-white/5 rounded-full"></div>
                <div class="hidden lg:block absolute bottom-[10%] -right-10 w-64 h-64 border border-white/5 rounded-full"></div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('productsData', () => ({
            loading: true,
            page: {},
            productList: [],
            domains: [],
            pagination: {},
            selectedDomain: 'all',
            selectedType: 'all',
            searchQuery: '',
            
            async init() {
                // Get type from URL if present
                const urlParams = new URLSearchParams(window.location.search);
                const typeParam = urlParams.get('type');
                if (typeParam) {
                    this.selectedType = typeParam;
                }

                await Promise.all([
                    this.fetchPageData(),
                    this.fetchDomains(),
                    this.fetchProducts()
                ]);

                this.$watch('selectedDomain', () => this.fetchProducts(1));
                this.$watch('selectedType', () => this.fetchProducts(1));
                this.$watch('searchQuery', () => this.fetchProducts(1));
            },

            async fetchPageData() {
                try {
                    const response = await axios.get('/api/page/products');
                    this.page = response.data;
                    if (this.page.meta_title) document.title = this.page.meta_title;
                } catch (e) {
                    console.error('Failed to load page data', e);
                }
            },

            async fetchDomains() {
                try {
                    const response = await axios.get('/api/products/domains');
                    this.domains = response.data;
                } catch (e) {
                    console.error('Failed to fetch domains', e);
                }
            },

            async fetchProducts(page = 1) {
                this.loading = true;
                try {
                    const params = {
                        page: page,
                        ai_domain: this.selectedDomain === 'all' ? '' : this.selectedDomain,
                        product_type: this.selectedType === 'all' ? '' : this.selectedType,
                        search: this.searchQuery
                    };
                    const response = await axios.get('/api/products', { params });
                    
                    this.productList = response.data.data;
                    this.pagination = {
                        current_page: response.data.current_page,
                        last_page: response.data.last_page,
                        total: response.data.total
                    };
                } catch (e) {
                    console.error('Failed to fetch products', e);
                } finally {
                    this.loading = false;
                    setTimeout(() => {
                        if (window.AOS) window.AOS.refresh();
                    }, 100);
                }
            },

            setDomain(domain) {
                this.selectedDomain = domain;
            },

            resetFilters() {
                this.selectedDomain = 'all';
                this.selectedType = 'all';
                this.searchQuery = '';
            },

            nextPage() {
                if (this.pagination.current_page < this.pagination.last_page) {
                    this.fetchProducts(this.pagination.current_page + 1);
                    window.scrollTo({ top: document.getElementById('explore').offsetTop - 100, behavior: 'smooth' });
                }
            },

            prevPage() {
                if (this.pagination.current_page > 1) {
                    this.fetchProducts(this.pagination.current_page - 1);
                    window.scrollTo({ top: document.getElementById('explore').offsetTop - 100, behavior: 'smooth' });
                }
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
    .animate-blob {
        animation: blob 10s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    @keyframes animate-data-flow {
        0% { stroke-dashoffset: 1000; }
        100% { stroke-dashoffset: -1000; }
    }
    @keyframes animate-data-flow-vertical {
        0% { stroke-dashoffset: 2000; }
        100% { stroke-dashoffset: 0; }
    }
    @keyframes slow-spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    @keyframes slow-spin-reverse {
        from { transform: rotate(360deg); }
        to { transform: rotate(0deg); }
    }
    .animate-data-flow {
        animation: animate-data-flow 15s linear infinite;
    }
    .animate-data-flow-vertical {
        animation: animate-data-flow-vertical 15s linear infinite;
    }
    .animate-slow-spin {
        animation: slow-spin 30s linear infinite;
    }
    .animate-slow-spin-reverse {
        animation: slow-spin-reverse 20s linear infinite;
    }
</style>
@endsection
