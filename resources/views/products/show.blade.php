@extends('layouts.app')

@section('meta_title', ($product->seo_title ?? $product->name) . ' | Operational System')
@section('meta_description', $product->seo_description ?? Str::limit(strip_tags($product->summary), 160))
@section('meta_keywords', $product->seo_keywords ? implode(', ', $product->seo_keywords) : (strtolower($product->ai_domain) . ', cybersecurity tool, biosecurity solution'))

@section('content')
<div class="bg-white min-h-screen" x-data="productDetail('{{ $product->slug }}')">
    <!-- Global Loading State -->
    <div x-show="loading" class="fixed inset-0 z-[9999] bg-white flex items-center justify-center">
        <div class="space-y-4 text-center">
            <div class="w-12 h-12 border-4 border-slate-900 border-t-sky-500 rounded-full animate-spin mx-auto"></div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Accessing System Node...</p>
        </div>
    </div>

    <!-- 1. CINEMATIC DETAIL HERO -->
    <section class="relative pt-32 pb-16 lg:pt-48 lg:pb-32 overflow-hidden px-4 sm:px-6 lg:px-8 border-b border-slate-50" x-data="{ mouseX: 0, mouseY: 0 }"
        @mousemove="mouseX = $event.clientX; mouseY = $event.clientY">
        
        <!-- Advanced Cyber Grid Background -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <svg class="absolute inset-0 w-full h-full opacity-[0.1]">
                <defs>
                    <linearGradient id="grid-grad-prod-show" x1="0%" y1="0%" x2="100%" y2="0%">
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
                <path d="M 0,300 L 2000,300" stroke="url(#grid-grad-prod-show)" stroke-width="1.5" fill="none" class="animate-data-flow" style="stroke-dasharray: 100, 1000;" />
                
                <!-- Animated Cog -->
                <g class="animate-slow-spin origin-[800px_300px] opacity-[0.15]">
                    <circle cx="800" cy="300" r="110" stroke="#0ea5e9" stroke-width="1" stroke-dasharray="10 20" fill="none" />
                    @foreach([0, 30, 60, 90, 120, 150, 180, 210, 240, 270, 300, 330] as $angle)
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
                <a href="{{ route('products.index') }}" class="hover:text-sky-500 transition-colors">Ecosystem</a>
                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-900" x-text="product?.ai_domain?.replace('_', ' ') || '{{ $product->ai_domain }}'"></span>
            </nav>

            <div class="max-w-5xl" x-show="product">
                <div class="inline-flex items-center px-4 py-1.5 border border-sky-100 bg-sky-50/50 rounded-full mb-8" data-aos="fade-right">
                    <div class="w-1.5 h-1.5 rounded-full bg-sky-500 animate-ping mr-3"></div>
                    <span class="text-[9px] sm:text-[10px] font-bold text-sky-600 uppercase tracking-[0.3em]" x-text="'Operational Level: ' + product.ai_level"></span>
                </div>

                <h1 class="text-4xl sm:text-6xl md:text-7xl lg:text-8xl font-black heading-font leading-[1] mb-10 text-slate-950 tracking-tighter"
                    data-aos="fade-up" data-aos-delay="100" x-text="product.name">
                </h1>

                <p class="text-sm sm:text-xl text-slate-800 mb-0 max-w-3xl leading-relaxed font-medium"
                    data-aos="fade-up" data-aos-delay="200" x-text="product.subtitle || product.summary">
                </p>
            </div>
        </div>
    </section>

    <!-- 2. PRODUCT BODY & SIDEBAR -->
    <section class="py-16 lg:py-24 relative z-10 px-4 sm:px-6 lg:px-8 bg-[#fafafa]/50">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
                
                <!-- Main Product Content -->
                <div class="lg:col-span-8" x-show="product">
                    <!-- Featured Showcase Image -->
                    <div class="rounded-[3rem] overflow-hidden shadow-[0_40px_100px_rgba(0,0,0,0.1)] mb-16 aspect-video bg-slate-100 border border-slate-100" data-aos="zoom-in">
                        <img :src="product.thumbnail || product.primaryImage?.image_path" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" :alt="product.name">
                    </div>

                    <!-- Technical Content -->
                    <article class="max-w-none text-left space-y-10" data-aos="fade-up">
                        <h2 class="text-3xl font-black text-slate-950 mb-8 tracking-tight heading-font">System Architecture & Capabilities</h2>
                        <div class="product-content space-y-8 text-slate-900 text-lg leading-relaxed font-medium" x-html="product.content"></div>

                        <!-- CTA Deployment -->
                        <div class="pt-16 border-t border-slate-200/60" x-show="product.cta_label">
                            <a :href="product.cta_url" class="inline-flex items-center space-x-6 px-12 py-6 bg-slate-950 text-white rounded-[2rem] font-black text-sm hover:translate-y-[-2px] transition-all shadow-2xl shadow-slate-200 active:scale-95 group uppercase tracking-widest">
                                <span x-text="product.cta_label"></span>
                                <svg class="w-6 h-6 transform transition-transform group-hover:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </article>

                    <!-- Connected Clusters (Related Products) -->
                    <div class="mt-32 pt-16 border-t-2 border-slate-100" x-show="related.length > 0">
                        <h3 class="text-3xl font-black text-slate-950 mb-12 tracking-tight heading-font">Connected Clusters</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <template x-for="rel in related" :key="rel.id">
                                <a :href="'/products/' + rel.slug" class="group block space-y-6">
                                    <div class="relative aspect-[16/10] rounded-[2.5rem] overflow-hidden shadow-lg border border-slate-50 bg-slate-100">
                                        <img :src="rel.thumbnail || rel.primaryImage?.image_path" class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-105" :alt="rel.name">
                                        <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-[9px] font-bold uppercase tracking-widest text-slate-900" x-text="rel.ai_domain.replace('_', ' ')"></div>
                                    </div>
                                    <h4 class="text-xl font-bold text-slate-950 group-hover:text-sky-600 transition-colors leading-tight tracking-tight" x-text="rel.name"></h4>
                                </a>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Strategic Sidebar -->
                <aside class="lg:col-span-4" x-show="product">
                    <div class="sticky top-32 space-y-12">
                        
                        <!-- Technical Meta Box -->
                        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-10 shadow-sm" data-aos="fade-left">
                            <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-8 border-b border-slate-50 pb-4">Operational Meta</h4>
                            <div class="space-y-6">
                                <div class="flex justify-between items-center border-b border-slate-50 pb-4">
                                    <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">Classification</span>
                                    <span class="text-xs text-slate-950 font-black uppercase tracking-tight" x-text="product.ai_domain?.replace('_', ' ')"></span>
                                </div>
                                <div class="flex justify-between items-center border-b border-slate-50 pb-4">
                                    <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">Node Type</span>
                                    <span class="text-xs text-indigo-600 font-black uppercase tracking-tight" x-text="product.product_type"></span>
                                </div>
                                <div class="flex justify-between items-center border-b border-slate-50 pb-4">
                                    <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">Node Status</span>
                                    <span class="text-xs text-emerald-600 font-black uppercase tracking-tight">Active</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">Visibility</span>
                                    <span class="text-xs text-slate-950 font-black uppercase tracking-tight" x-text="product.is_ai_visible ? 'Public' : 'Restricted'"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Technical Support Card -->
                        <div class="relative rounded-[2.5rem] p-10 bg-slate-950 overflow-hidden text-white" data-aos="fade-left" data-aos-delay="200">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-sky-500/10 rounded-full blur-3xl"></div>
                            <div class="relative z-10">
                                <h4 class="text-2xl font-black mb-4 tracking-tight leading-tight">Need Support?</h4>
                                <p class="text-sm text-slate-400 font-medium leading-relaxed mb-8">Our system architects are available for node integration assistance.</p>
                                <a href="{{ route('contact') }}" class="inline-block w-full py-5 bg-sky-500 text-slate-950 text-center rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-white transition-all shadow-xl shadow-sky-500/20">
                                    TALK TO ARCHITECT
                                </a>
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
                        <span class="text-[9px] font-bold text-sky-400 uppercase tracking-[0.3em]">Infrastructure Advisory</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl md:text-7xl font-bold heading-font text-white mb-8 tracking-tighter leading-tight">
                        Scale your <br/> <span class="bg-gradient-to-r from-sky-400 to-cyan-400 bg-clip-text text-transparent">Digital Frontier.</span>
                    </h2>
                    <p class="text-slate-400 text-lg mb-12 font-light leading-relaxed">
                        Beyond off-the-shelf tools. We engineer the exact cybersecurity fabric required for global-scale research and high-stakes operations.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        <a href="{{ route('contact') }}" class="w-full sm:w-auto px-12 py-5 bg-white text-slate-950 rounded-2xl font-black text-xs hover:translate-y-[-1px] transition-all active:scale-95 text-center uppercase tracking-widest">
                            Start Consultation
                        </a>
                        <a href="{{ route('products.index') }}" class="w-full sm:w-auto px-12 py-5 border border-white/20 text-white rounded-2xl font-black text-xs hover:bg-white/5 transition-all text-center uppercase tracking-widest">
                            Back to Ecosystem
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('productDetail', (slug) => ({
            loading: true,
            product: null,
            related: [],
            
            async init() {
                await this.fetchProduct();
            },

            async fetchProduct() {
                this.loading = true;
                try {
                    const response = await axios.get('/api/products/' + slug);
                    this.product = response.data.product;
                    this.related = response.data.related;
                } catch (e) {
                    console.error('Failed to fetch product detail', e);
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

    /* Product Content Styling */
    .product-content h3 {
        font-size: 1.875rem;
        font-weight: 900;
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #020617;
    }
    .product-content p {
        margin-bottom: 1.5rem;
        color: #475569;
    }
    .product-content ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .product-content li {
        margin-bottom: 0.5rem;
    }
</style>
@endsection
