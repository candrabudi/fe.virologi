@extends('layouts.app')

@section('meta_title', 'Insights & Research Articles | RD-VIROLOGI Intelligence')
@section('meta_description', 'Explore the latest research papers, expert insights, and articles on virology, bioinformatics, and the intersection of AI and cybersecurity.')
@section('meta_keywords', 'virology articles, bioinformatics blog, ai security research, digital pathogen analysis')

@section('content')
<div class="bg-white min-h-screen overflow-x-hidden" x-data="blogData()">
    <!-- Global Loading State -->
    <div x-show="loading" class="fixed inset-0 z-[9999] bg-white flex items-center justify-center">
        <div class="space-y-4 text-center">
            <div class="w-12 h-12 border-4 border-slate-900 border-t-sky-500 rounded-full animate-spin mx-auto"></div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Accessing Intelligence Journal...</p>
        </div>
    </div>
    <!-- 1. MINIMALIST LIGHT HERO SECTION -->
    <section class="relative pt-32 pb-16 lg:pt-48 lg:pb-32 overflow-hidden px-4 sm:px-6 lg:px-8 border-b border-slate-50" x-data="{ mouseX: 0, mouseY: 0 }"
        @mousemove="mouseX = $event.clientX; mouseY = $event.clientY">
        
        <!-- Advanced Cyber Grid Background (Consistent Theme) -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <!-- Animated SVG Grid -->
            <svg class="absolute inset-0 w-full h-full opacity-[0.12]">
                <defs>
                    <linearGradient id="grid-grad-blog" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="transparent" />
                        <stop offset="50%" stop-color="#0ea5e9" />
                        <stop offset="100%" stop-color="transparent" />
                    </linearGradient>
                    <filter id="glow-light-blog">
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
                <path d="M 0,300 L 2000,300" stroke="url(#grid-grad-blog)" stroke-width="1.5" fill="none" class="animate-data-flow" filter="url(#glow-light-blog)" style="stroke-dasharray: 100, 1000;" />
                <path d="M 400,0 L 400,1000" stroke="url(#grid-grad-blog)" stroke-width="1.5" fill="none" class="animate-data-flow-vertical" filter="url(#glow-light-blog)" style="stroke-dasharray: 100, 1000;" />
                
                <!-- Animated Cyber Cog -->
                <g class="animate-slow-spin origin-[800px_300px] opacity-[0.16]">
                    <circle cx="800" cy="300" r="100" stroke="#0ea5e9" stroke-width="1" stroke-dasharray="10 20" fill="none" />
                    @foreach(range(0, 360, 30) as $angle)
                        <line x1="800" y1="200" x2="800" y2="220" stroke="#0ea5e9" stroke-width="2" transform="rotate({{ $angle }} 800 300)" />
                    @endforeach
                    <circle cx="800" cy="300" r="70" stroke="#6366f1" stroke-width="0.5" fill="none" class="animate-pulse" />
                </g>
            </svg>

            <!-- Smooth Mesh Gradients -->
            <div class="absolute -top-[10%] -left-[5%] w-[500px] h-[500px] bg-sky-100/30 rounded-full blur-[100px] animate-blob"></div>
            <div class="absolute top-[20%] -right-[5%] w-[600px] h-[600px] bg-indigo-50/40 rounded-full blur-[120px] animate-blob animation-delay-2000"></div>

            <!-- Point-to-Point Particle Canvas -->
            <canvas id="hero-canvas" class="absolute inset-0 w-full h-full opacity-[0.4]"></canvas>
        </div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="max-w-3xl text-left">
                <div class="inline-flex items-center px-4 py-1 border border-sky-100 bg-sky-50/50 rounded-full mb-6 sm:mb-8"
                    data-aos="fade-right">
                    <div class="w-1 h-1 rounded-full bg-sky-500 animate-ping mr-2"></div>
                    <span class="text-[8px] sm:text-[10px] font-bold text-sky-600 uppercase tracking-[0.2em] sm:tracking-[0.3em]" x-text="page.hero_subtitle || 'Intelligence Journal // Insights'"></span>
                </div>

                <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold heading-font leading-[1.1] mb-6 sm:mb-8 text-slate-950 tracking-tight sm:tracking-tighter"
                    data-aos="fade-right" data-aos-delay="100" data-aos-once="true" x-cloak x-html="page.hero_title || 'Insights <span class=\'bg-gradient-to-r from-sky-500 to-indigo-600 bg-clip-text text-transparent\'>& Cyber Discovery.</span>'">
                </h1>

                <p class="text-[13px] sm:text-xl text-slate-900 mb-6 sm:mb-10 max-w-2xl leading-relaxed font-bold"
                    data-aos="fade-right" data-aos-delay="200" x-text="page.hero_description || 'Deep exploration of digital virology trends, cyber threat analysis, and future technology security innovations.'">
                </p>

                <div class="flex flex-wrap gap-3 sm:gap-4" data-aos="fade-right" data-aos-delay="300">
                    <template x-if="page.primary_button_text">
                        <a :href="page.primary_button_url" class="flex-1 sm:flex-none px-6 sm:px-8 py-3.5 sm:py-4 bg-slate-900 text-white rounded-xl font-bold text-xs sm:text-sm hover:translate-y-[-2px] transition-all shadow-xl shadow-slate-100 active:scale-95 text-center" x-text="page.primary_button_text"></a>
                    </template>
                    <template x-if="page.secondary_button_text">
                        <a :href="page.secondary_button_url" class="flex-1 sm:flex-none px-6 sm:px-8 py-3.5 sm:py-4 border border-slate-200 text-slate-950 rounded-xl font-bold text-xs sm:text-sm hover:bg-slate-50 transition-all text-center" x-text="page.secondary_button_text"></a>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. ARTICLE GRID & SIDEBAR -->
    <section id="articles" class="py-16 lg:py-24 relative z-10 px-4 sm:px-6 lg:px-8 bg-[#fafafa]/50 overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">
                
                <!-- Main Article Feed -->
                <div class="lg:w-2/3 space-y-12">
                    <!-- Filter Tabs -->
                    <div class="flex items-center space-x-2 overflow-x-auto pb-4 no-scrollbar" data-aos="fade-up">
                        <button @click="setCategory(null)" :class="!selectedCategory ? 'bg-slate-900 text-white shadow-xl shadow-slate-200' : 'bg-white text-slate-400 border border-slate-100 hover:border-slate-300 hover:text-slate-600'" class="flex-none px-6 py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all">
                            All Insights
                        </button>
                        <template x-for="cat in categories" :key="cat.id">
                            <button @click="setCategory(cat.slug)" :class="selectedCategory === cat.slug ? 'bg-slate-900 text-white shadow-xl shadow-slate-200' : 'bg-white text-slate-400 border border-slate-100 hover:border-slate-300 hover:text-slate-600'" class="flex-none px-6 py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all">
                                <span x-text="cat.name"></span>
                            </button>
                        </template>
                    </div>

                    <!-- Articles Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-10">
                        <template x-for="(post, index) in posts" :key="post.id">
                            <article class="group relative flex flex-col h-full bg-white border border-slate-100 rounded-[2.5rem] overflow-hidden transition-all duration-500 hover:shadow-[0_32px_80px_-20px_rgba(0,0,0,0.08)] hover:-translate-y-2" data-aos="fade-up" :data-aos-delay="index * 30" data-aos-once="true">
                                <!-- Image -->
                                <div class="relative aspect-[16/10] overflow-hidden bg-slate-50">
                                    <img :src="post.thumbnail" :alt="post.title" 
                                        class="w-full h-full object-cover grayscale transition-all duration-1000 group-hover:grayscale-0 group-hover:scale-105 opacity-90">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                    
                                    <!-- Category Badge -->
                                    <div class="absolute top-6 left-6 px-3 py-1.5 bg-white/90 backdrop-blur-md border border-slate-100 rounded-xl shadow-sm">
                                        <span class="text-[9px] font-bold text-slate-600 uppercase tracking-widest whitespace-nowrap" x-text="post.categories[0]?.name || 'Intelligence'"></span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="p-8 flex flex-col flex-1">
                                    <div class="flex items-center gap-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">
                                        <span class="text-sky-500" x-text="new Date(post.published_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })"></span>
                                        <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                                        <span>RD-VIROLOGI</span>
                                    </div>
                                    
                                    <h3 class="text-xl sm:text-2xl font-bold text-slate-950 heading-font mb-4 tracking-tight group-hover:text-sky-600 transition-colors leading-tight">
                                        <a :href="'/blog/' + post.slug" x-text="post.title.length > 30 ? post.title.substring(0, 30) + '...' : post.title"></a>
                                    </h3>
                                    
                                    <p class="text-slate-900 text-sm leading-relaxed line-clamp-3 mb-8 font-normal" x-text="post.excerpt"></p>

                                    <div class="mt-auto pt-6 border-t border-slate-50 flex items-center justify-between">
                                        <a :href="'/blog/' + post.slug" class="text-[10px] font-bold text-slate-950 uppercase tracking-widest group-hover:text-sky-600 transition-colors">
                                            Read Analysis
                                        </a>
                                        <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-900 group-hover:bg-slate-950 group-hover:text-white transition-all duration-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </template>

                        <!-- Empty State -->
                        <template x-if="posts.length === 0 && !loading">
                            <div class="col-span-full py-20 text-center">
                                <div class="bg-white border border-slate-100 rounded-[3rem] p-16 max-w-xl mx-auto shadow-sm">
                                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 mx-auto mb-6">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-950 heading-font mb-4">No Data Found</h3>
                                    <p class="text-slate-500 text-sm leading-relaxed mb-10 font-normal">Your search query yielded no results from our intelligence journal. Please recalibrate your keywords.</p>
                                    <button @click="resetFilters()" class="px-8 py-3 bg-slate-900 text-white rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-sky-600 transition-all">Reset Analysis</button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Modern Pagination -->
                    <template x-if="pagination.last_page > 1">
                        <div class="mt-20 flex justify-center custom-pagination" data-aos="fade-up">
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
                </div>

                <!-- Sidebar Area -->
                <aside class="lg:w-1/3 space-y-10">
                    <!-- Search Widget -->
                    <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm" data-aos="fade-left">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-50 pb-4">Search Journal</h4>
                        <div class="relative group">
                            <input type="text" placeholder="Keywords..." x-model.debounce.500ms="searchQuery"
                                class="w-full bg-[#fafafa] border border-slate-100 rounded-2xl py-4 pl-5 pr-12 text-sm text-slate-950 placeholder-slate-400 focus:ring-4 focus:ring-sky-900/5 focus:border-sky-500 transition-all outline-none">
                            <button class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-slate-950 rounded-xl flex items-center justify-center text-white hover:bg-sky-600 transition-colors shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Trending Section -->
                    <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm" data-aos="fade-left" data-aos-delay="100">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-8 border-b border-slate-50 pb-4">Featured Insights</h4>
                        <div class="space-y-8">
                            <template x-for="(rp, index) in recentPosts" :key="rp.id">
                                <a :href="'/blog/' + rp.slug" class="group flex items-start gap-4">
                                    <div class="text-2xl font-black text-slate-100 group-hover:text-sky-500/20 transition-colors pointer-events-none tabular-nums" x-text="'0' + (index + 1)"></div>
                                    <div>
                                        <h5 class="text-sm font-bold text-slate-950 leading-snug group-hover:text-sky-600 transition-colors mb-2 line-clamp-2" x-text="rp.title"></h5>
                                        <div class="text-[9px] font-black text-sky-500 uppercase tracking-widest" x-text="rp.categories[0]?.name || 'Insight'"></div>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </div>

                    <!-- Topics Cloud -->
                    <div class="bg-slate-900 rounded-[2rem] p-8 relative overflow-hidden" data-aos="fade-left" data-aos-delay="200">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-sky-500/20 rounded-full blur-3xl"></div>
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6 relative z-10">Archive Topics</h4>
                        <div class="flex flex-wrap gap-2 relative z-10">
                            <template x-for="category in categories" :key="category.id">
                                <button @click="setCategory(category.slug)" class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-xs font-bold text-slate-300 hover:text-white transition-all whitespace-nowrap">
                                    <span x-text="category.name"></span> (<span x-text="category.articles_count"></span>)
                                </button>
                            </template>
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </section>

    <!-- 3. STRATEGIC CTA (Consistency) -->
    <section id="newsletter" class="py-24 lg:py-40 relative overflow-hidden px-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-slate-900 rounded-[3rem] p-8 md:p-16 lg:p-24 relative overflow-hidden text-white">
                <div class="absolute inset-0 opacity-10 pointer-events-none"
                    style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 40px 40px;"></div>
                
                <div class="relative z-10 max-w-3xl" data-aos="fade-right">
                    <div class="inline-flex items-center px-4 py-2 border border-white/10 bg-white/5 rounded-full mb-8">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.3em]">Knowledge Subscription</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl md:text-7xl font-bold heading-font text-white mb-8 tracking-tighter leading-tight">
                        Deep Research <br/> <span class="bg-gradient-to-r from-sky-400 to-indigo-400 bg-clip-text text-transparent">Directly Delivered.</span>
                    </h2>
                    <p class="text-slate-400 text-lg mb-12 font-light leading-relaxed">
                        Stay at the forefront of biological and digital defense research with our monthly technical journal summary.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        <div class="w-full sm:w-auto flex-1 max-w-md relative group">
                            <input type="email" placeholder="Security cleared email..." 
                                class="w-full bg-white/5 border border-white/10 rounded-2xl py-5 px-6 text-white text-sm outline-none focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10 transition-all">
                        </div>
                        <button class="w-full sm:w-auto px-12 py-5 bg-white text-slate-950 rounded-2xl font-bold text-sm hover:translate-y-[-2px] transition-all active:scale-95">
                            Subscribe
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('blogData', () => ({
            loading: true,
            page: {},
            posts: [],
            categories: [],
            recentPosts: [],
            pagination: {},
            selectedCategory: '{{ $categorySlug ?? request()->query("category") }}' || null,
            searchQuery: '',
            
            async init() {
                // Initial Data Load
                await Promise.all([
                    this.fetchPageData(),
                    this.fetchCategories(),
                    this.fetchRecentPosts(),
                    this.fetchArticles()
                ]);

                // Watchers for filters
                this.$watch('selectedCategory', () => this.fetchArticles(1));
                this.$watch('searchQuery', () => this.fetchArticles(1));
            },

            async fetchPageData() {
                try {
                    const response = await axios.get('/api/page/blog');
                    this.page = response.data;
                    
                    if (this.page.meta_title) document.title = this.page.meta_title;
                } catch (e) {
                    console.error('Failed to load page data', e);
                }
            },

            async fetchCategories() {
                try {
                    const response = await axios.get('/api/blog/categories');
                    this.categories = response.data;
                } catch (e) {
                    console.error('Failed to categories', e);
                }
            },

            async fetchRecentPosts() {
                try {
                    const response = await axios.get('/api/blog/recent');
                    this.recentPosts = response.data;
                } catch (e) {
                    console.error('Failed to recent posts', e);
                }
            },

            async fetchArticles(page = 1) {
                this.loading = true;
                try {
                    const params = {
                        page: page,
                        category: this.selectedCategory,
                        search: this.searchQuery
                    };
                    const response = await axios.get('/api/blog', { params });
                    
                    this.posts = response.data.data;
                    this.pagination = {
                        current_page: response.data.current_page,
                        last_page: response.data.last_page,
                        total: response.data.total
                    };

                    // Update URL for UX
                    const url = new URL(window.location);
                    if (this.selectedCategory) url.searchParams.set('category', this.selectedCategory);
                    else url.searchParams.delete('category');
                    window.history.pushState({}, '', url);

                } catch (e) {
                    console.error('Failed to fetch articles', e);
                } finally {
                    this.loading = false;
                    setTimeout(() => {
                        if (window.AOS) window.AOS.refresh();
                    }, 100);
                }
            },

            setCategory(slug) {
                this.selectedCategory = slug;
            },

            resetFilters() {
                this.selectedCategory = null;
                this.searchQuery = '';
            },

            nextPage() {
                if (this.pagination.current_page < this.pagination.last_page) {
                    this.fetchArticles(this.pagination.current_page + 1);
                    window.scrollTo({ top: document.getElementById('articles').offsetTop - 100, behavior: 'smooth' });
                }
            },

            prevPage() {
                if (this.pagination.current_page > 1) {
                    this.fetchArticles(this.pagination.current_page - 1);
                    window.scrollTo({ top: document.getElementById('articles').offsetTop - 100, behavior: 'smooth' });
                }
            }
        }));

        // Particle System for Hero
        const canvas = document.getElementById('hero-canvas');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            let particles = [];
            const particleCount = 40;
            const connectionDistance = 200;
            const mouseRange = 150;
            let mouse = { x: null, y: null };

            window.addEventListener('mousemove', (e) => {
                mouse.x = e.x;
                mouse.y = e.y;
            });

            class Particle {
                constructor() {
                    this.init();
                }

                init() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.size = Math.random() * 2 + 1;
                    this.speedX = (Math.random() - 0.5) * 0.5;
                    this.speedY = (Math.random() - 0.5) * 0.5;
                }

                update() {
                    this.x += this.speedX;
                    this.y += this.speedY;

                    if (this.x > canvas.width) this.x = 0;
                    else if (this.x < 0) this.x = canvas.width;
                    if (this.y > canvas.height) this.y = 0;
                    else if (this.y < 0) this.y = canvas.height;
                }

                draw() {
                    ctx.fillStyle = '#94a3b8'; // slate-400
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            function resize() {
                canvas.width = canvas.offsetWidth;
                canvas.height = canvas.offsetHeight;
                particles = [];
                for (let i = 0; i < particleCount; i++) {
                    particles.push(new Particle());
                }
            }

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                for (let i = 0; i < particles.length; i++) {
                    particles[i].update();
                    particles[i].draw();

                    for (let j = i; j < particles.length; j++) {
                        const dx = particles[i].x - particles[j].x;
                        const dy = particles[i].y - particles[j].y;
                        const distance = Math.sqrt(dx * dx + dy * dy);

                        if (distance < connectionDistance) {
                            const opacity = 1 - (distance / connectionDistance);
                            ctx.strokeStyle = `rgba(14, 165, 233, ${opacity * 0.3})`; // sky-500
                            ctx.lineWidth = 0.5;
                            ctx.beginPath();
                            ctx.moveTo(particles[i].x, particles[i].y);
                            ctx.lineTo(particles[j].x, particles[j].y);
                            ctx.stroke();
                        }
                    }
                }
                requestAnimationFrame(animate);
            }

            window.addEventListener('resize', resize);
            resize();
            animate();
        }
    });
</script>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
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
    @keyframes animate-data-flow-vertical {
        0% { stroke-dashoffset: 2000; }
        100% { stroke-dashoffset: 0; }
    }
    @keyframes slow-spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-data-flow { animation: animate-data-flow 15s linear infinite; }
    .animate-data-flow-vertical { animation: animate-data-flow-vertical 15s linear infinite; }
    .animate-slow-spin { animation: slow-spin 30s linear infinite; }
</style>
@endsection
