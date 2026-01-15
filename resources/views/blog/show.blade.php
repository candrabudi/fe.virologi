@extends('layouts.app')

@section('meta_title', ($post->seo_title ?? $post->title) . ' | VIROLOGI Intelligence')
@section('meta_description', $post->seo_description ?? Str::limit(strip_tags($post->content), 160))
@section('meta_keywords', $post->seo_keywords ?? ($post->categories->pluck('name')->join(', ') . ', virology research, pathogen analysis'))

@section('content')
<div class="bg-white min-h-screen overflow-x-hidden" x-data="blogDetail('{{ $post->slug }}')">
    <!-- Global Loading State -->
    <div x-show="loading" class="fixed inset-0 z-[9999] bg-white flex items-center justify-center">
        <div class="space-y-4 text-center">
            <div class="w-12 h-12 border-4 border-slate-900 border-t-sky-50 rounded-full animate-spin mx-auto"></div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Decoding Intelligence Detail...</p>
        </div>
    </div>
    <!-- 1. CINEMATIC ARTICLE HERO (Consistent with Detail Template) -->
    <section class="relative pt-32 pb-16 lg:pt-48 lg:pb-32 overflow-hidden px-4 sm:px-6 lg:px-8 border-b border-slate-50" x-data="{ mouseX: 0, mouseY: 0 }"
        @mousemove="mouseX = $event.clientX; mouseY = $event.clientY">
        
        <!-- Advanced Cyber Grid Background -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <svg class="absolute inset-0 w-full h-full opacity-[0.1]">
                <defs>
                    <linearGradient id="grid-grad-blog-show" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="transparent" />
                        <stop offset="50%" stop-color="#0ea5e9" />
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

                <!-- Animated Cog -->
                <g class="animate-slow-spin origin-[800px_300px] opacity-[0.14]">
                    <circle cx="800" cy="300" r="110" stroke="#0ea5e9" stroke-width="1" stroke-dasharray="10 20" fill="none" />
                    @foreach(range(0, 360, 30) as $angle)
                        <line x1="800" y1="190" x2="800" y2="210" stroke="#0ea5e9" stroke-width="2" transform="rotate({{ $angle }} 800 300)" />
                    @endforeach
                </g>
            </svg>
            <div class="absolute -top-[10%] -left-[5%] w-[500px] h-[500px] bg-sky-100/30 rounded-full blur-[100px] animate-blob"></div>
            <div class="absolute top-[20%] -right-[5%] w-[600px] h-[600px] bg-indigo-50/40 rounded-full blur-[120px] animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex items-center space-x-4 mb-10 text-[10px] uppercase tracking-[0.2em] font-bold text-slate-400" data-aos="fade-right">
                <a href="{{ route('blog.index') }}" class="hover:text-sky-600 transition-colors">Journal</a>
                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-900">{{ $post->categories->first()->name ?? 'Resource' }}</span>
            </nav>

            <div class="max-w-5xl" x-show="post">
                <div class="inline-flex items-center px-4 py-1.5 border border-sky-100 bg-sky-50/50 rounded-full mb-8" data-aos="fade-right">
                    <div class="w-1.5 h-1.5 rounded-full bg-sky-500 animate-ping mr-3"></div>
                    <span class="text-[9px] sm:text-[10px] font-bold text-sky-600 uppercase tracking-[0.3em]">Journal Entry // Verified Intelligence</span>
                </div>

                <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-black heading-font leading-tight mb-8 text-slate-950 tracking-tight"
                    data-aos="fade-up" data-aos-delay="100" data-aos-once="true" x-cloak x-text="post.title">
                </h1>

                <!-- Article Meta -->
                <div class="flex flex-wrap items-center gap-6 sm:gap-10 pt-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-2xl bg-slate-950 flex items-center justify-center text-white font-bold text-lg shadow-xl shadow-slate-200">
                            V
                        </div>
                        <div class="text-left">
                            <span class="block text-[10px] uppercase tracking-widest text-slate-400 font-bold">Organization</span>
                            <span class="text-slate-950 font-black">VIROLOGI</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-col">
                        <span class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Published</span>
                        <span class="text-slate-950 font-black" x-text="new Date(post.published_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })"></span>
                    </div>

                    <div class="hidden sm:flex flex-col">
                        <span class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Reading Time</span>
                        <span class="text-slate-950 font-black">5 min read</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. ARTICLE BODY & SIDEBAR -->
    <section class="py-16 lg:py-24 relative z-10 px-4 sm:px-6 lg:px-8 bg-[#fafafa]/50 overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
                
                <!-- Main Article Content -->
                <div class="lg:col-span-8" x-show="post">
                    <!-- Featured Image -->
                    <div class="rounded-2xl sm:rounded-[3rem] overflow-hidden shadow-[0_40px_100px_rgba(0,0,0,0.1)] mb-12 sm:mb-16 aspect-video bg-slate-100" data-aos="zoom-in" data-aos-once="true">
                        <img :src="post.thumbnail" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000" :alt="post.title">
                    </div>

                    <!-- Technical Content -->
                    <article class="max-w-none text-left space-y-10" data-aos="fade-up">
                        <div class="article-content space-y-8 text-black text-sm leading-relaxed font-normal" x-html="post.content"></div>

                        <!-- Tags / Shared -->
                        <div class="pt-16 border-t border-slate-100">
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Article Classification</h4>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="tag in post.tags" :key="tag.id">
                                    <span class="px-5 py-2.5 bg-slate-100 text-slate-950 text-[10px] font-black uppercase tracking-widest rounded-xl" x-text="'#' + tag.name"></span>
                                </template>
                            </div>
                        </div>
                    </article>

                    <!-- Related Intelligence (In-feed) -->
                    <div class="mt-32 pt-16 border-t-2 border-slate-100" x-show="related.length > 0">
                        <h3 class="text-3xl font-black text-slate-950 mb-12 tracking-tight heading-font">Connected Insights</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <template x-for="rel in related" :key="rel.id">
                                <a :href="'/blog/' + rel.slug" class="group block space-y-6">
                                    <div class="relative aspect-[16/10] rounded-[2.5rem] overflow-hidden shadow-lg border border-slate-50">
                                        <img :src="rel.thumbnail" class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-105" :alt="rel.title">
                                    </div>
                                    <h4 class="text-xl font-bold text-slate-950 group-hover:text-sky-600 transition-colors leading-tight tracking-tight" x-text="rel.title"></h4>
                                </a>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Strategic Sidebar -->
                <aside class="lg:col-span-4 space-y-12">
                    <div class="sticky top-32 space-y-10">
                        
                        <!-- Search Sidebar -->
                        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-10 shadow-sm" data-aos="fade-left">
                            <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-8 border-b border-slate-50 pb-4">Journal Search</h4>
                            <div class="relative group">
                                <input type="text" placeholder="Search archives..." 
                                    class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-4 pl-5 pr-12 text-sm text-slate-950 placeholder-slate-400 focus:ring-4 focus:ring-sky-900/5 focus:border-sky-500 transition-all outline-none">
                                <button class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-slate-950 rounded-xl flex items-center justify-center text-white hover:bg-sky-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Featured Topics (Synced Index) -->
                        <div class="bg-slate-950 rounded-[2.5rem] p-10 relative overflow-hidden" data-aos="fade-left" data-aos-delay="100">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-sky-500/10 rounded-full blur-3xl"></div>
                            <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-8 border-b border-white/5 pb-4 relative z-10">Topics Cloud</h4>
                            <div class="flex flex-wrap gap-2 relative z-10">
                                @foreach(['Biosecurity', 'Network Defense', 'Genomics', 'AI Analysis', 'Surveillance'] as $topic)
                                <a href="#" class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-[11px] font-bold text-slate-400 hover:text-white transition-all">
                                    {{ $topic }}
                                </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Support CTA -->
                        <div class="relative rounded-[2.5rem] p-10 bg-gradient-to-br from-sky-600 to-indigo-700 overflow-hidden text-white" data-aos="fade-left" data-aos-delay="200">
                            <div class="relative z-10">
                                <h4 class="text-2xl font-black mb-4 tracking-tight leading-tight">Expert Consultation Needed?</h4>
                                <p class="text-sm text-sky-100 font-medium leading-relaxed mb-8">Get direct access to our analysts for a detailed technical briefing on these findings.</p>
                                <a href="#" class="inline-block w-full py-5 bg-white text-slate-950 text-center rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-slate-50 transition-all shadow-2xl shadow-indigo-900/40">
                                    Contact Analyst
                                </a>
                            </div>
                            <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        </div>

                    </div>
                </aside>

            </div>
        </div>
    </section>

    <!-- 3. STRATEGIC CTA -->
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
                        Deepen your <br/> <span class="bg-gradient-to-r from-sky-400 to-indigo-400 bg-clip-text text-transparent">Strategic Edge.</span>
                    </h2>
                    <p class="text-slate-400 text-lg mb-12 font-light leading-relaxed">
                        Scale your understanding of modern threats with our premium library. Real data, real intelligence, real-time protection.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        <a href="{{ route('blog.index') }}" class="w-full sm:w-auto px-12 py-5 bg-white text-slate-950 rounded-2xl font-bold text-sm hover:translate-y-[-2px] transition-all active:scale-95 text-center">
                            Return to Journal
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
        Alpine.data('blogDetail', (slug) => ({
            loading: true,
            post: null,
            related: [],
            
            async init() {
                await this.fetchPost();
            },

            async fetchPost() {
                this.loading = true;
                try {
                    const response = await axios.get('/api/blog/' + slug);
                    this.post = response.data.post;
                    this.related = response.data.related;
                } catch (e) {
                    console.error('Failed to fetch article detail', e);
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
    @keyframes slow-spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-slow-spin { animation: slow-spin 30s linear infinite; }
    
    /* Article Content Specific Hooks */
    .article-content h3 {
        font-size: 1.875rem;
        font-weight: 900;
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: black;
    }
    .article-content p {
        margin-bottom: 1.5rem;
    }
</style>
@endsection
