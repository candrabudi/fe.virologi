@extends('layouts.app')

@section('meta_title', $ebook->meta_title ?? ($ebook->title . ' | Intelligence Report'))
@section('meta_description', $ebook->meta_description ?? Str::limit(strip_tags($ebook->summary), 160))
@section('meta_keywords', $ebook->meta_keywords ? implode(', ', $ebook->meta_keywords) : (strtolower($ebook->topic) . ', cybersecurity guide, virology report, technical whitepaper'))

@section('content')
<div class="bg-white min-h-screen" x-data="ebookDetail('{{ $ebook->slug }}')">
    <!-- Global Loading State -->
    <div x-show="loading" class="fixed inset-0 z-[9999] bg-white flex items-center justify-center">
        <div class="space-y-4 text-center">
            <div class="w-12 h-12 border-4 border-slate-900 border-t-indigo-500 rounded-full animate-spin mx-auto"></div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Decoding Intelligence Briefing...</p>
        </div>
    </div>
    <!-- 1. CINEMATIC DETAIL HERO (Consistent with Products/E-books Index) -->
    <section class="relative pt-32 pb-16 lg:pt-48 lg:pb-32 overflow-hidden px-4 sm:px-6 lg:px-8 border-b border-slate-50" x-data="{ mouseX: 0, mouseY: 0 }"
        @mousemove="mouseX = $event.clientX; mouseY = $event.clientY">
        
        <!-- Advanced Cyber Grid Background -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <svg class="absolute inset-0 w-full h-full opacity-[0.1]">
                <defs>
                    <linearGradient id="grid-grad-ebook-show" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="transparent" />
                        <stop offset="50%" stop-color="#6366f1" />
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
                <path d="M 0,300 L 2000,300" stroke="url(#grid-grad-ebook-show)" stroke-width="1.5" fill="none" class="animate-data-flow" style="stroke-dasharray: 100, 1000;" />
                
                <!-- Animated Cog -->
                <g class="animate-slow-spin origin-[800px_300px] opacity-[0.14]">
                    <circle cx="800" cy="300" r="110" stroke="#6366f1" stroke-width="1" stroke-dasharray="10 20" fill="none" />
                    @foreach(range(0, 360, 30) as $angle)
                        <line x1="800" y1="190" x2="800" y2="210" stroke="#6366f1" stroke-width="2" transform="rotate({{ $angle }} 800 300)" />
                    @endforeach
                </g>
            </svg>
            <div class="absolute -top-[10%] -left-[5%] w-[500px] h-[500px] bg-indigo-100/30 rounded-full blur-[100px] animate-blob"></div>
            <div class="absolute top-[20%] -right-[5%] w-[600px] h-[600px] bg-sky-50/40 rounded-full blur-[120px] animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex items-center space-x-4 mb-10 text-[10px] uppercase tracking-[0.2em] font-bold text-slate-400" data-aos="fade-right">
                <a href="{{ route('ebooks.index') }}" class="hover:text-indigo-600 transition-colors">Library</a>
                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-900" x-show="ebook" x-text="ebook.topic.replace('_', ' ')"></span>
            </nav>

            <div class="max-w-4xl" x-show="ebook">
                <div class="inline-flex items-center px-4 py-1.5 border border-indigo-100 bg-indigo-50/50 rounded-full mb-8" data-aos="fade-right">
                    <div class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-ping mr-3"></div>
                    <span class="text-[9px] sm:text-[10px] font-bold text-indigo-600 uppercase tracking-[0.3em]" x-text="'Intelligence Node // ' + ebook.level"></span>
                </div>

                <h1 class="text-4xl sm:text-6xl md:text-7xl lg:text-8xl font-extrabold heading-font leading-[1] mb-8 text-slate-950 tracking-tighter"
                    data-aos="fade-right" data-aos-delay="100" x-text="ebook.title">
                </h1>

                <p class="text-sm sm:text-xl text-slate-900 mb-0 max-w-2xl leading-relaxed font-medium"
                    data-aos="fade-right" data-aos-delay="200" x-text="ebook.subtitle || ebook.summary">
                </p>
            </div>
        </div>
    </section>

    <!-- 2. REPORT CONTENT & SIDEBAR -->
    <section class="py-16 lg:py-24 relative z-10 px-4 sm:px-6 lg:px-8 bg-[#fafafa]/50">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
                
                <!-- Main Body (Detailed Content) -->
                <div class="lg:col-span-8 space-y-16" x-show="ebook">
                    <!-- Featured Book Visual Section -->
                    <div class="flex flex-col md:flex-row gap-12 items-center md:items-start">
                        <div class="w-full max-w-[300px] shrink-0 group perspective-1000" data-aos="zoom-in">
                            <div class="relative aspect-[3/4.2] rounded-[2rem] overflow-hidden shadow-[0_40px_100px_rgba(0,0,0,0.1)] border-4 border-white transition-all duration-700 hover:rotate-y-12">
                                <img :src="ebook.cover_image" class="w-full h-full object-cover" :alt="ebook.title">
                                <div class="absolute inset-0 bg-gradient-to-tr from-slate-950/30 to-transparent"></div>
                            </div>
                        </div>
                        
                        <div class="flex-1 space-y-8" data-aos="fade-left">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-6 rounded-3xl bg-white border border-slate-100 shadow-sm">
                                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Author</div>
                                    <div class="text-sm font-bold text-slate-950" x-text="ebook.author"></div>
                                </div>
                                <div class="p-6 rounded-3xl bg-white border border-slate-100 shadow-sm">
                                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Length</div>
                                    <div class="text-sm font-bold text-slate-950" x-text="ebook.page_count + ' Pages'"></div>
                                </div>
                            </div>

                            <p class="text-slate-900 leading-relaxed font-normal italic border-l-4 border-indigo-500 pl-6 py-2" x-text="ebook.summary"></p>

                            <div class="pt-4 flex flex-wrap gap-4">
                                <a href="#" class="flex-1 sm:flex-none px-10 py-5 bg-slate-950 text-white rounded-2xl font-bold text-sm hover:translate-y-[-2px] transition-all shadow-2xl shadow-slate-200 active:scale-95 text-center flex items-center justify-center space-x-3">
                                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span x-text="'Download ' + ebook.file_type.toUpperCase()"></span>
                                </a>
                                <a href="{{ route('ebooks.read', $ebook->slug) }}" class="flex-1 sm:flex-none px-10 py-5 border border-slate-200 text-slate-950 rounded-2xl font-bold text-sm hover:bg-white transition-all text-center">
                                    Read Online
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Technical Content -->
                    <article class="max-w-none text-left space-y-8" data-aos="fade-up">
                        <h2 class="text-4xl font-black text-black tracking-tight mb-8">Briefing Overview</h2>
                        <div class="text-lg text-black leading-relaxed font-bold" x-html="ebook.content"></div>
                        
                        <div class="space-y-6" x-show="ebook.learning_objectives?.length > 0">
                            <h3 class="text-2xl font-black text-black uppercase tracking-tight">Intelligence Objectives</h3>
                            <ul class="space-y-4">
                                <template x-for="obj in ebook.learning_objectives" :key="obj">
                                    <li class="flex items-start">
                                        <span class="w-2 h-2 rounded-full bg-indigo-600 mt-2.5 mr-4 shrink-0"></span>
                                        <span class="text-lg text-black font-bold" x-text="obj"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>

                        <div class="space-y-6" x-show="ebook.chapters?.length > 0">
                            <h3 class="text-2xl font-black text-black uppercase tracking-tight">Briefing Structure</h3>
                            <div class="grid grid-cols-1 gap-4">
                                <template x-for="chapter in ebook.chapters" :key="chapter.title">
                                    <div class="flex items-center justify-between p-6 bg-white border border-slate-100 rounded-2xl">
                                        <span class="text-lg text-black font-bold" x-text="chapter.title"></span>
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest" x-text="'Pages ' + chapter.pages"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Sidebar (Related Intel) -->
                <aside class="lg:col-span-4 space-y-10">
                    <!-- Related Intelligence Widget -->
                    <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm" data-aos="fade-left">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-8 border-b border-slate-100 pb-4">Connected Intel</h4>
                        <div class="space-y-8">
                            <template x-for="rel in related" :key="rel.id">
                                <a :href="'/ebooks/' + rel.slug" class="flex gap-4 group">
                                    <div class="w-16 h-20 rounded-xl overflow-hidden bg-slate-50 border border-slate-100 shrink-0">
                                        <img :src="rel.cover_image" class="w-full h-full object-cover grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-500">
                                    </div>
                                    <div class="pt-1 overflow-hidden">
                                        <h5 class="text-sm font-bold text-slate-950 group-hover:text-indigo-600 transition-colors leading-tight line-clamp-2 tracking-tight" x-text="rel.title"></h5>
                                        <p class="text-[9px] text-slate-500 uppercase font-black tracking-widest mt-1" x-text="rel.topic.replace('_', ' ')"></p>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </div>

                    <!-- Search Library Widget -->
                    <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm" data-aos="fade-left" data-aos-delay="100">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">Archive Search</h4>
                        <div class="relative group">
                            <input type="text" placeholder="Search briefing archives..." 
                                class="w-full bg-[#fafafa] border border-slate-100 rounded-2xl py-4 pl-5 pr-12 text-sm text-slate-900 placeholder-slate-400 focus:ring-4 focus:ring-indigo-900/5 focus:border-indigo-500 transition-all outline-none">
                            <button class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-slate-950 rounded-xl flex items-center justify-center text-white hover:bg-indigo-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Support/Request CTA -->
                    <div class="relative rounded-[2rem] p-8 bg-indigo-600 overflow-hidden text-white" data-aos="fade-left" data-aos-delay="200">
                        <div class="relative z-10">
                            <h4 class="text-xl font-bold mb-4 tracking-tight">Need Custom Intel?</h4>
                            <p class="text-sm text-indigo-100 font-light leading-relaxed mb-6">Request a bespoke briefing tailored to your specific infrastructure and threat landscape.</p>
                            <a href="#" class="inline-block w-full py-4 bg-white text-indigo-600 text-center rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-slate-50 transition-all shadow-xl shadow-indigo-950/20">
                                Request Access
                            </a>
                        </div>
                        <!-- Decor -->
                        <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    </div>
                </aside>

            </div>
        </div>
    </section>

    <!-- 3. STRATEGIC CTA (Consistency) -->
    <section class="py-24 lg:py-40 relative overflow-hidden px-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-slate-900 rounded-[3rem] p-8 md:p-16 lg:p-24 relative overflow-hidden text-white">
                <div class="absolute inset-0 opacity-10 pointer-events-none"
                    style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 40px 40px;"></div>
                
                <div class="relative z-10 max-w-3xl" data-aos="fade-right">
                    <div class="inline-flex items-center px-4 py-2 border border-white/10 bg-white/5 rounded-full mb-8">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.3em]">Scalable Knowledge Transfer</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl md:text-7xl font-bold heading-font text-white mb-8 tracking-tighter leading-tight">
                        Deepen your <br/> <span class="bg-gradient-to-r from-indigo-400 to-sky-400 bg-clip-text text-transparent">Strategic Edge.</span>
                    </h2>
                    <p class="text-slate-400 text-lg mb-12 font-light leading-relaxed">
                        Scale your understanding of modern threats with our premium library. Real data, real intelligence, real-time protection.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        <a href="{{ route('ebooks.index') }}" class="w-full sm:w-auto px-12 py-5 bg-white text-slate-950 rounded-2xl font-bold text-sm hover:translate-y-[-2px] transition-all active:scale-95 text-center">
                            Return to Library
                        </a>
                        <a href="#" class="w-full sm:w-auto px-12 py-5 border border-white/20 text-white rounded-2xl font-bold text-sm hover:bg-white/5 transition-all text-center">
                            Register for Updates
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('ebookDetail', (slug) => ({
            loading: true,
            ebook: null,
            related: [],
            
            async init() {
                await this.fetchEbook();
            },

            async fetchEbook() {
                this.loading = true;
                try {
                    const response = await axios.get('/api/ebooks/' + slug);
                    this.ebook = response.data.ebook;
                    this.related = response.data.related;
                } catch (e) {
                    console.error('Failed to fetch ebook detail', e);
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
    @keyframes slow-spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-data-flow {
        animation: animate-data-flow 15s linear infinite;
    }
    .animate-slow-spin {
        animation: slow-spin 30s linear infinite;
    }
    .perspective-1000 {
        perspective: 1000px;
    }
    .rotate-y-12 {
        transform: rotateY(12deg);
    }
</style>
@endsection
