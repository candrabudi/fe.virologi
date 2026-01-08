@extends('layouts.app')

@section('meta_title', 'Strategic Intelligence | E-Books & Technical Guides')
@section('meta_description', 'Download our exclusive collection of technical guides on pathogen research, bioinformatics, and advanced cybersecurity strategies.')
@section('meta_keywords', 'cybersecurity ebooks, bioinformatics guides, virology pdf, digital defense manuals')

@section('content')
<div class="bg-white min-h-screen" x-data="ebooksData()">
    <!-- Global Loading State -->
    <div x-show="loading" class="fixed inset-0 z-[9999] bg-white flex items-center justify-center">
        <div class="space-y-4 text-center">
            <div class="w-12 h-12 border-4 border-slate-900 border-t-indigo-500 rounded-full animate-spin mx-auto"></div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Accessing Intelligence Library...</p>
        </div>
    </div>
    <!-- 1. MINIMALIST LIGHT HERO SECTION -->
    <section class="relative pt-32 pb-16 lg:pt-48 lg:pb-32 overflow-hidden px-4 sm:px-6 lg:px-8 border-b border-slate-50" x-data="{ mouseX: 0, mouseY: 0 }"
        @mousemove="mouseX = $event.clientX; mouseY = $event.clientY">
        
        <!-- Advanced Cyber Grid Background (Consistent with Products) -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <!-- Animated SVG Grid -->
            <svg class="absolute inset-0 w-full h-full opacity-[0.15]">
                <defs>
                    <linearGradient id="grid-grad-ebook" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="transparent" />
                        <stop offset="50%" stop-color="#6366f1" />
                        <stop offset="100%" stop-color="transparent" />
                    </linearGradient>
                    <filter id="glow-light-ebook">
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
                <path d="M 0,300 L 2000,300" stroke="url(#grid-grad-ebook)" stroke-width="1.5" fill="none" class="animate-data-flow" filter="url(#glow-light-ebook)" style="stroke-dasharray: 100, 1000;" />
                <path d="M 800,0 L 800,1000" stroke="url(#grid-grad-ebook)" stroke-width="1.5" fill="none" class="animate-data-flow-vertical" filter="url(#glow-light-ebook)" style="stroke-dasharray: 100, 1000;" />
                
                <!-- Animated Cyber Cog -->
                <g class="animate-slow-spin origin-[800px_300px] opacity-[0.15]">
                    <circle cx="800" cy="300" r="120" stroke="#6366f1" stroke-width="1" stroke-dasharray="10 20" fill="none" />
                    @foreach(range(0, 360, 30) as $angle)
                        <line x1="800" y1="180" x2="800" y2="200" stroke="#6366f1" stroke-width="2" transform="rotate({{ $angle }} 800 300)" />
                    @endforeach
                    <circle cx="800" cy="300" r="80" stroke="#0ea5e9" stroke-width="0.5" fill="none" class="animate-pulse" />
                </g>
            </svg>

            <!-- Smooth Mesh Gradients -->
            <div class="absolute -top-[10%] -left-[5%] w-[500px] h-[500px] bg-indigo-100/30 rounded-full blur-[100px] animate-blob"></div>
            <div class="absolute top-[20%] -right-[5%] w-[600px] h-[600px] bg-sky-50/40 rounded-full blur-[120px] animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="max-w-3xl text-left">
                <div class="inline-flex items-center px-4 py-1 border border-indigo-100 bg-indigo-50/50 rounded-full mb-6 sm:mb-8"
                    data-aos="fade-right">
                    <div class="w-1 h-1 rounded-full bg-indigo-500 animate-ping mr-2"></div>
                    <span class="text-[8px] sm:text-[10px] font-bold text-indigo-600 uppercase tracking-[0.2em] sm:tracking-[0.3em]" x-text="page.hero_subtitle || 'Strategic Intelligence Base // V2.0'"></span>
                </div>

                <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold heading-font leading-[1.2] sm:leading-[1.1] mb-4 sm:mb-8 text-slate-900 tracking-tight sm:tracking-tighter"
                    data-aos="fade-right" data-aos-delay="100" x-html="page.hero_title || 'Knowledge <br /> <span class=\'bg-gradient-to-r from-indigo-500 to-sky-500 bg-clip-text text-transparent\'>Infrastructure.</span>'">
                </h1>

                <p class="text-[13px] sm:text-xl text-slate-800 mb-6 sm:mb-10 max-w-2xl leading-relaxed font-medium"
                    data-aos="fade-right" data-aos-delay="200" x-text="page.hero_description || 'Collection of premium whitepapers, research journals, and tactical guides for cybersecurity professionals and digital virologists.'">
                </p>

                <div class="flex flex-wrap gap-3 sm:gap-4" data-aos="fade-right" data-aos-delay="300">
                    <template x-if="page.primary_button_text">
                        <a :href="page.primary_button_url" class="flex-1 sm:flex-none px-6 sm:px-8 py-3.5 sm:py-4 bg-slate-900 text-white rounded-xl font-bold text-xs sm:text-sm hover:translate-y-[-2px] transition-all shadow-xl shadow-slate-100 active:scale-95 text-center" x-text="page.primary_button_text"></a>
                    </template>
                    <template x-if="page.secondary_button_text">
                        <a :href="page.secondary_button_url" class="flex-1 sm:flex-none px-6 sm:px-8 py-3.5 sm:py-4 border border-slate-200 text-slate-600 rounded-xl font-bold text-xs sm:text-sm hover:bg-slate-50 transition-all text-center" x-text="page.secondary_button_text"></a>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. FILTER & E-BOOK GRID -->
    <section id="library" class="py-16 lg:py-24 relative z-10 px-4 sm:px-6 lg:px-8 bg-[#fafafa]/50">
        <div class="max-w-7xl mx-auto">
            
            <!-- Minimalist Toolbar -->
            <div class="flex flex-col lg:flex-row items-center justify-between mb-12 lg:mb-20 gap-8" data-aos="fade-up">
                <div class="flex items-center space-x-2 overflow-x-auto pb-4 lg:pb-0 w-full lg:w-auto no-scrollbar">
                    <template x-for="t in topics" :key="t">
                        <button @click="setTopic(t)" :class="selectedTopic === t ? 'bg-slate-900 text-white shadow-xl shadow-slate-200' : 'bg-white text-slate-400 border border-slate-100 hover:border-slate-300 hover:text-slate-600'" 
                            class="flex-none px-6 py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all">
                            <span x-text="t.replace('_', ' ')"></span>
                        </button>
                    </template>
                </div>

                <div class="relative w-full lg:w-80 group">
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400 group-focus-within:text-slate-900 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" placeholder="Search library database..." x-model.debounce.500ms="searchQuery"
                        class="w-full bg-white border border-slate-100 rounded-2xl py-4 pl-12 pr-4 text-sm text-slate-900 placeholder-slate-400 focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 transition-all outline-none">
                </div>
            </div>

            <!-- E-book Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
                <template x-for="(book, index) in ebookList" :key="book.id">
                    <div class="group" data-aos="fade-up" :data-aos-delay="index * 50">
                        <div class="relative flex flex-col h-full bg-white border border-slate-100 rounded-[2.5rem] overflow-hidden transition-all duration-500 hover:shadow-[0_32px_80px_-20px_rgba(0,0,0,0.08)] hover:-translate-y-2">
                            
                            <!-- Book Cover Container -->
                            <div class="relative aspect-[3/4] overflow-hidden bg-slate-50">
                                <img :src="book.cover_image" :alt="book.title" 
                                    class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-105 opacity-90">
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                
                                <!-- Category Badge -->
                                <div class="absolute top-6 left-6 px-3 py-1.5 bg-white/90 backdrop-blur-md border border-slate-100 rounded-xl shadow-sm">
                                    <span class="text-[9px] font-bold text-slate-600 uppercase tracking-widest" x-text="book.topic.replace('_', ' ')"></span>
                                </div>

                                <!-- Pages Badge -->
                                <div class="absolute bottom-6 left-6 px-3 py-1.5 bg-slate-900/80 backdrop-blur-md text-white rounded-xl shadow-sm">
                                    <span class="text-[8px] font-bold uppercase tracking-widest" x-text="book.page_count + ' Pages'"></span>
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-6 sm:p-8 flex flex-col flex-1">
                                <div class="mb-4">
                                    <span class="text-[9px] font-bold text-indigo-500 uppercase tracking-[0.2em] mb-2 block" x-text="'By ' + book.author"></span>
                                    <h3 class="text-xl sm:text-2xl font-bold text-slate-950 heading-font mb-3 tracking-tight group-hover:text-indigo-600 transition-colors" x-text="book.title"></h3>
                                    <p class="text-slate-900 text-xs sm:text-sm leading-relaxed line-clamp-2 font-normal" x-text="book.summary"></p>
                                </div>

                                <div class="mt-auto pt-6 flex items-center gap-3">
                                    <a :href="'/ebooks/' + book.slug" 
                                        class="flex-1 inline-flex items-center justify-center px-4 py-3.5 bg-slate-900 text-white rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-indigo-600 transition-all active:scale-95 shadow-lg shadow-slate-100">
                                        Read Analysis
                                    </a>
                                    <a href="#" class="w-12 h-12 inline-flex items-center justify-center bg-slate-50 border border-slate-100 text-slate-900 rounded-xl hover:bg-slate-100 transition-all active:scale-95">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            
            <!-- Empty State -->
            <template x-if="ebookList.length === 0 && !loading">
                <div class="py-20 text-center">
                    <h3 class="text-xl font-bold text-slate-950 heading-font mb-4">No E-books found</h3>
                    <button @click="resetFilters()" class="px-8 py-3 bg-slate-900 text-white rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-indigo-600">Reset Search</button>
                </div>
            </template>

            <!-- Modern Pagination -->
            <template x-if="pagination.last_page > 1">
                <div class="mt-20 lg:mt-32 flex justify-center" data-aos="fade-up">
                    <nav class="flex items-center space-x-2">
                        <button @click="prevPage()" :disabled="pagination.current_page === 1" 
                            class="w-12 h-12 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-600 hover:border-indigo-500 hover:text-indigo-500 transition-all disabled:opacity-30 disabled:cursor-not-allowed shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        
                        <span class="w-12 h-12 flex items-center justify-center rounded-xl bg-slate-900 text-white font-bold text-sm shadow-xl shadow-slate-200 cursor-default" x-text="pagination.current_page"></span>
                        
                        <button @click="nextPage()" :disabled="pagination.current_page === pagination.last_page" 
                            class="w-12 h-12 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-600 hover:border-indigo-500 hover:text-indigo-500 transition-all disabled:opacity-30 disabled:cursor-not-allowed shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </nav>
                </div>
            </template>
        </div>
    </section>

    <!-- 3. NEWSLETTER / ACCESS CTA -->
    <section id="newsletter" class="py-24 lg:py-40 relative overflow-hidden px-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-slate-900 rounded-[3rem] p-8 md:p-16 lg:p-24 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10 pointer-events-none"
                    style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 40px 40px;"></div>
                
                <div class="relative z-10 max-w-3xl" data-aos="fade-right">
                    <div class="inline-flex items-center px-4 py-2 border border-white/10 bg-white/5 rounded-full mb-8">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.3em]">Premium Intelligence Access</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl md:text-7xl font-bold heading-font text-white mb-8 tracking-tighter leading-tight">
                        Receive Classified <br/> <span class="bg-gradient-to-r from-indigo-400 to-sky-400 bg-clip-text text-transparent">Weekly Intel.</span>
                    </h2>
                    <p class="text-slate-400 text-lg mb-12 font-light leading-relaxed">
                        Join our technical laboratory insights and receive exclusive reports on global biotechnology and digital defense infrastructure.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        <div class="w-full sm:w-auto flex-1 max-w-md relative group">
                            <input type="email" placeholder="Enter security-cleared email..." 
                                class="w-full bg-white/5 border border-white/10 rounded-2xl py-5 px-6 text-white text-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                        </div>
                        <button class="w-full sm:w-auto px-12 py-5 bg-white text-slate-950 rounded-2xl font-bold text-sm hover:translate-y-[-2px] transition-all active:scale-95">
                            Subscribe
                        </button>
                    </div>
                </div>

                <div class="hidden lg:block absolute top-[10%] -right-20 w-96 h-96 border border-white/5 rounded-full"></div>
                <div class="hidden lg:block absolute bottom-[10%] -right-10 w-64 h-64 border border-white/5 rounded-full"></div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('ebooksData', () => ({
            loading: true,
            page: {},
            ebookList: [],
            topics: [],
            pagination: {},
            selectedTopic: 'All Resources',
            searchQuery: '',
            
            async init() {
                await Promise.all([
                    this.fetchPageData(),
                    this.fetchTopics(),
                    this.fetchEbooks()
                ]);

                this.$watch('selectedTopic', () => this.fetchEbooks(1));
                this.$watch('searchQuery', () => this.fetchEbooks(1));
            },

            async fetchPageData() {
                try {
                    const response = await axios.get('/api/page/ebooks');
                    this.page = response.data;
                    if (this.page.meta_title) document.title = this.page.meta_title;
                } catch (e) {
                    console.error('Failed to load page data', e);
                }
            },

            async fetchTopics() {
                try {
                    const response = await axios.get('/api/ebooks/topics');
                    this.topics = response.data;
                } catch (e) {
                    console.error('Failed to topics', e);
                }
            },

            async fetchEbooks(page = 1) {
                this.loading = true;
                try {
                    const params = {
                        page: page,
                        topic: this.selectedTopic,
                        search: this.searchQuery
                    };
                    const response = await axios.get('/api/ebooks', { params });
                    
                    this.ebookList = response.data.data;
                    this.pagination = {
                        current_page: response.data.current_page,
                        last_page: response.data.last_page,
                        total: response.data.total
                    };
                } catch (e) {
                    console.error('Failed to fetch ebooks', e);
                } finally {
                    this.loading = false;
                    setTimeout(() => {
                        if (window.AOS) window.AOS.refresh();
                    }, 100);
                }
            },

            setTopic(t) {
                this.selectedTopic = t;
            },

            resetFilters() {
                this.selectedTopic = 'All Resources';
                this.searchQuery = '';
            },

            nextPage() {
                if (this.pagination.current_page < this.pagination.last_page) {
                    this.fetchEbooks(this.pagination.current_page + 1);
                    window.scrollTo({ top: document.getElementById('library').offsetTop - 100, behavior: 'smooth' });
                }
            },

            prevPage() {
                if (this.pagination.current_page > 1) {
                    this.fetchEbooks(this.pagination.current_page - 1);
                    window.scrollTo({ top: document.getElementById('library').offsetTop - 100, behavior: 'smooth' });
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
    .animate-data-flow {
        animation: animate-data-flow 15s linear infinite;
    }
    .animate-data-flow-vertical {
        animation: animate-data-flow-vertical 15s linear infinite;
    }
    .animate-slow-spin {
        animation: slow-spin 30s linear infinite;
    }
</style>
@endsection
