@extends('layouts.app')

@section('meta_title', $about_settings->seo_title ?? 'About Us | RD-VIROLOGI')
@section('meta_description', $about_settings->seo_description ?? 'Beyond Digital Frontiers — Cybersecurity Intelligence Collector Since 2004')

@section('content')
<div class="bg-white min-h-screen overflow-x-hidden">
    <!-- 1. CINEMATIC ABOUT HERO -->
    <section class="relative pt-24 pb-12 sm:pt-32 sm:pb-16 lg:pt-48 lg:pb-32 overflow-hidden px-4 sm:px-6 lg:px-8 border-b border-slate-50" x-data="{ mouseX: 0, mouseY: 0 }"
        @mousemove="mouseX = $event.clientX; mouseY = $event.clientY">
        
        <!-- Consistent Cyber Grid Background -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <svg class="absolute inset-0 w-full h-full opacity-[0.15]">
                <defs>
                    <linearGradient id="grid-grad-about" x1="0%" y1="0%" x2="100%" y2="0%">
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
                </g>
                <path d="M 0,300 L 2000,300" stroke="url(#grid-grad-about)" stroke-width="1.5" fill="none" class="animate-data-flow" style="stroke-dasharray: 100, 1000;" />
            </svg>
            <div class="absolute -top-[10%] -left-[5%] w-[250px] h-[250px] sm:w-[500px] sm:h-[500px] bg-sky-100/30 rounded-full blur-[60px] sm:blur-[100px] animate-blob"></div>
            <div class="absolute top-[20%] -right-[5%] w-[300px] h-[300px] sm:w-[600px] sm:h-[600px] bg-indigo-50/40 rounded-full blur-[80px] sm:blur-[120px] animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto relative z-10 font-sans">
            <div class="max-w-4xl text-left">
                <div class="inline-flex items-center px-3 py-1 sm:px-4 sm:py-1.5 border border-sky-100 bg-sky-50/50 rounded-full mb-6 sm:mb-8" data-aos="fade-right">
                    <div class="w-1.5 h-1.5 rounded-full bg-sky-500 animate-ping mr-2 sm:mr-3"></div>
                    <span class="text-[8px] sm:text-[10px] font-bold text-sky-600 uppercase tracking-widest">{{ $about_settings->hero_badge ?? 'Since 2004' }}</span>
                </div>

                <h1 class="text-4xl sm:text-7xl md:text-8xl lg:text-9xl font-black heading-font leading-[1.1] sm:leading-[0.9] mb-6 sm:mb-8 text-slate-950 tracking-tighter"
                    data-aos="fade-right" data-aos-delay="100">
                    {!! $about_settings->hero_title ?? 'About <br /> <span class="bg-gradient-to-r from-sky-500 to-indigo-600 bg-clip-text text-transparent">Us.</span>' !!}
                </h1>

                <p class="text-sm sm:text-xl text-slate-800 mb-0 max-w-3xl leading-relaxed font-bold italic"
                    data-aos="fade-right" data-aos-delay="200">
                    {{ $about_settings->hero_description ?? 'Beyond Digital Frontiers — Cybersecurity Intelligence Collector Since 2004' }}
                </p>
            </div>
        </div>
    </section>

    <!-- 2. STORY & STATS SECTION -->
    <section class="py-12 sm:py-16 lg:py-24 relative z-10 bg-white overflow-hidden font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Story Header -->
            <div class="mb-12 sm:mb-20" data-aos="fade-up">
                 <h2 class="text-2xl sm:text-5xl font-black text-slate-950 heading-font tracking-tight mb-8">
                    {{ $about_settings->story_title ?? 'The History' }}
                </h2>
                <div class="space-y-6 text-base sm:text-lg text-slate-700 font-medium leading-relaxed story-container">
                    {!! $about_settings->story_content !!}
                </div>
            </div>

            <!-- Stats Grid - Fixed Overlapping for Mobile -->
            @if(isset($about_settings->stats))
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-12 py-12 sm:py-20 border-y border-slate-100 mb-16 sm:mb-32">
                @foreach($about_settings->stats as $stat)
                <div class="flex flex-col items-center sm:items-start text-center sm:text-left" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <p class="text-4xl sm:text-6xl font-black text-slate-950 heading-font mb-2 leading-none">
                        {{ $stat['value'] ?? '' }}<span class="text-sky-500">{{ $stat['suffix'] ?? '' }}</span>
                    </p>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">{{ $stat['title'] }}</p>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Vision & Mission -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-16">
                <div class="bg-slate-50 p-6 sm:p-12 rounded-2xl sm:rounded-[3rem]" data-aos="fade-up">
                    <h3 class="text-xl sm:text-3xl font-black text-slate-950 mb-4 sm:mb-6 uppercase tracking-tight heading-font">{{ $about_settings->vision_title ?? 'Manifesto' }}</h3>
                    <div class="text-base sm:text-lg text-slate-700 font-bold leading-relaxed italic border-l-4 border-sky-500 pl-4 sm:pl-6">
                        "{!! strip_tags($about_settings->vision_content) !!}"
                    </div>
                </div>
                <div data-aos="fade-up" data-aos-delay="200" class="p-2">
                    <h3 class="text-xl sm:text-3xl font-black text-slate-950 mb-6 sm:mb-10 uppercase tracking-tight heading-font">{{ $about_settings->mission_title ?? 'Apa yang Kami Bahas' }}</h3>
                    <ul class="space-y-5 sm:space-y-8">
                        @if(isset($about_settings->mission_items))
                            @foreach($about_settings->mission_items as $item)
                            <li class="flex items-start space-x-4 group">
                                <div class="w-2 h-2 bg-sky-500 rounded-full mt-2.5 shrink-0 group-hover:scale-150 transition-transform"></div>
                                <p class="text-base sm:text-lg text-slate-800 font-bold leading-tight">{{ $item }}</p>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. CORE VALUES SECTION -->
    <section class="py-16 sm:py-24 lg:py-40 bg-slate-950 relative overflow-hidden text-white font-sans">
        <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 40px 40px;"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-32">
                <p class="text-[8px] sm:text-[10px] font-black text-sky-400 uppercase tracking-[0.4em] mb-4">Tactical DNA</p>
                <h2 class="text-3xl sm:text-6xl font-black heading-font tracking-tighter">Prinsip Kami.</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @if(isset($about_settings->core_values))
                    @foreach($about_settings->core_values as $value)
                    <div class="group p-8 border border-white/10 rounded-2xl sm:rounded-[3rem] hover:bg-white/5 transition-all duration-500" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-white/5 rounded-xl flex items-center justify-center text-sky-400 mb-6 sm:mb-10 group-hover:bg-sky-400 group-hover:text-slate-950 transition-all">
                            <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <h4 class="text-xl sm:text-2xl font-black mb-4 tracking-tight uppercase">{{ $value['title'] }}</h4>
                        <p class="text-sm sm:text-base text-slate-400 font-medium leading-relaxed">{{ $value['description'] }}</p>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- 4. CTA SECTION -->
    <section class="py-12 sm:py-24 lg:py-40 relative overflow-hidden px-4 font-sans">
        <div class="max-w-7xl mx-auto">
            <div class="bg-indigo-950 rounded-2xl sm:rounded-[3rem] p-8 sm:p-24 relative overflow-hidden text-white text-center shadow-2xl">
                <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 40px 40px;"></div>
                
                <div class="relative z-10 max-w-4xl mx-auto" data-aos="fade-up">
                    <h2 class="text-3xl sm:text-7xl font-black heading-font text-white mb-8 sm:mb-12 tracking-tighter leading-tight">
                        Shape the <br/> <span class="bg-gradient-to-r from-sky-400 to-indigo-400 bg-clip-text text-transparent">Future Defense.</span>
                    </h2>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-8">
                        <a href="{{ route('blog.index') }}" class="w-full sm:w-auto px-10 py-4 sm:px-12 sm:py-5 bg-white text-slate-950 rounded-xl sm:rounded-2xl font-black text-[10px] sm:text-xs uppercase tracking-[0.3em] hover:translate-y-[-2px] transition-all active:scale-95 text-center shadow-xl">
                            EXPLORE INTEL
                        </a>
                        <a href="{{ route('contact') }}" class="w-full sm:w-auto px-10 py-4 sm:px-12 sm:py-5 border border-white/20 text-white rounded-xl sm:rounded-2xl font-black text-[10px] sm:text-xs uppercase tracking-[0.3em] hover:bg-white/5 transition-all text-center">
                            GET IN TOUCH
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(25px, -40px) scale(1.1); }
        66% { transform: translate(-15px, 15px) scale(0.9); }
    }
    .animate-blob { animation: blob 15s infinite; }
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

    .story-container {
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    .story-container p {
        margin-bottom: 1.5rem;
    }
    .story-container p:last-child {
        margin-bottom: 0;
    }
    .story-container strong {
        color: #0ea5e9;
    }
</style>
@endsection
