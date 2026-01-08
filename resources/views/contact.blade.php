@extends('layouts.app')

@section('meta_title', $contact_settings->seo_title ?? 'Operational Contact // Communication Channels')
@section('meta_description', $contact_settings->seo_description ?? 'Connect with our technical architects and strategic analysts for high-consequence security inquiries.')

@section('content')
<div class="bg-white min-h-screen">
    <!-- 1. CINEMATIC CONTACT HERO -->
    <section class="relative pt-32 pb-16 lg:pt-48 lg:pb-32 overflow-hidden px-4 sm:px-6 lg:px-8 border-b border-slate-50" x-data="{ mouseX: 0, mouseY: 0 }"
        @mousemove="mouseX = $event.clientX; mouseY = $event.clientY">
        
        <!-- Advanced Cyber Grid Background (Consistent Theme) -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <svg class="absolute inset-0 w-full h-full opacity-[0.15]">
                <defs>
                    <linearGradient id="grid-grad-contact" x1="0%" y1="0%" x2="100%" y2="0%">
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
                <path d="M 0,300 L 2000,300" stroke="url(#grid-grad-contact)" stroke-width="1.5" fill="none" class="animate-data-flow" style="stroke-dasharray: 100, 1000;" />
                
                <!-- Animated Cog -->
                <g class="animate-slow-spin origin-[800px_300px] opacity-[0.2]">
                    <circle cx="800" cy="300" r="100" stroke="#0ea5e9" stroke-width="1" stroke-dasharray="10 20" fill="none" />
                    @foreach(range(0, 360, 30) as $angle)
                        <line x1="800" y1="200" x2="800" y2="220" stroke="#0ea5e9" stroke-width="2" transform="rotate({{ $angle }} 800 300)" />
                    @endforeach
                </g>
            </svg>
            <div class="absolute -top-[10%] -left-[5%] w-[500px] h-[500px] bg-sky-100/30 rounded-full blur-[100px] animate-blob"></div>
            <div class="absolute top-[20%] -right-[5%] w-[600px] h-[600px] bg-indigo-50/40 rounded-full blur-[120px] animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="max-w-4xl text-left">
                <div class="inline-flex items-center px-4 py-1.5 border border-sky-100 bg-sky-50/50 rounded-full mb-8" data-aos="fade-right">
                    <div class="w-1.5 h-1.5 rounded-full bg-sky-500 animate-ping mr-3"></div>
                    <span class="text-[10px] font-bold text-sky-600 uppercase tracking-[0.3em]">{{ $contact_settings->hero_badge ?? 'Operational Node // Comms Hub' }}</span>
                </div>

                <h1 class="text-5xl sm:text-7xl md:text-8xl lg:text-9xl font-black heading-font leading-[0.9] mb-8 text-slate-950 tracking-tighter"
                    data-aos="fade-right" data-aos-delay="100">
                    {!! $contact_settings->hero_title ?? 'Get in <br /> <span class="bg-gradient-to-r from-sky-500 to-indigo-600 bg-clip-text text-transparent">Touch.</span>' !!}
                </h1>

                <p class="text-sm sm:text-xl text-slate-800 mb-0 max-w-3xl leading-relaxed font-bold italic"
                    data-aos="fade-right" data-aos-delay="200">
                    {{ $contact_settings->hero_description ?? 'No forms. Just direct, verified communication channels for strategic partnerships and high-priority technical support.' }}
                </p>
            </div>
        </div>
    </section>

    <!-- 2. DIRECT COMMUNICATION CHANNELS -->
    <section class="py-16 lg:py-24 relative z-10 px-4 sm:px-6 lg:px-8 bg-[#fafafa]/50">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                @if(isset($contact_settings->channels))
                    @foreach($contact_settings->channels as $channel)
                        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-10 shadow-sm hover:shadow-2xl transition-all duration-500 group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-8 transition-all duration-500 
                                {{ $channel['color'] == 'sky' ? 'bg-sky-50 text-sky-600 group-hover:bg-sky-600 group-hover:text-white' : '' }}
                                {{ $channel['color'] == 'indigo' ? 'bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white' : '' }}
                                {{ $channel['color'] == 'slate' ? 'bg-slate-900 text-white group-hover:bg-sky-500' : '' }}">
                                
                                @if($channel['icon'] == 'email')
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                @elseif($channel['icon'] == 'phone')
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h2.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                @else
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                @endif
                            </div>
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">{{ $channel['title'] }}</h3>
                            <p class="text-2xl font-black text-slate-950 mb-6 tracking-tight whitespace-pre-line">{{ $channel['value'] }}</p>
                            <p class="text-sm text-slate-500 font-medium leading-relaxed mb-8">{{ $channel['description'] }}</p>
                            <a href="{{ $channel['link'] }}" class="inline-flex items-center space-x-3 text-[10px] font-bold uppercase tracking-widest border-b-2 pb-1 transition-all
                                {{ $channel['color'] == 'sky' ? 'text-sky-600 border-sky-100 hover:border-sky-600' : '' }}
                                {{ $channel['color'] == 'indigo' ? 'text-indigo-600 border-indigo-100 hover:border-indigo-600' : '' }}
                                {{ $channel['color'] == 'slate' ? 'text-slate-900 border-slate-200 hover:border-slate-900' : '' }}">
                                <span>{{ $channel['icon'] == 'location' ? 'View Operational Map' : ($channel['icon'] == 'phone' ? 'Establish Connection' : 'Send Transmission') }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>

    <!-- 3. STRATEGIC SOCIAL FEED -->
    <section class="py-24 relative overflow-hidden px-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-slate-950 rounded-[3rem] p-12 md:p-20 lg:p-32 relative overflow-hidden text-white text-center">
                <div class="absolute inset-0 opacity-10 pointer-events-none"
                    style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 40px 40px;"></div>
                
                <div class="relative z-10 max-w-4xl mx-auto" data-aos="fade-up">
                    <h2 class="text-4xl sm:text-5xl md:text-7xl font-black heading-font text-white mb-10 tracking-tighter leading-tight">
                        {!! $contact_settings->social_title ?? 'Follow the <br class="hidden sm:block" /> <span class="bg-gradient-to-r from-sky-400 to-indigo-400 bg-clip-text text-transparent">Intelligence Feed.</span>' !!}
                    </h2>
                    <p class="text-slate-400 text-lg mb-16 font-light leading-relaxed max-w-2xl mx-auto">
                        {{ $contact_settings->social_description ?? 'Stay connected with our real-time updates and tactical briefings across all major secure networks.' }}
                    </p>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                        @if(isset($footer_settings->social_links))
                            @foreach($footer_settings->social_links as $platform => $url)
                            @if($url)
                            <a href="{{ $url }}" target="_blank" class="flex flex-col items-center justify-center p-8 bg-white/5 border border-white/10 rounded-[2rem] hover:bg-white hover:text-slate-950 transition-all duration-500 group">
                                <span class="text-[10px] font-black uppercase tracking-[0.3em]">{{ $platform }}</span>
                            </a>
                            @endif
                            @endforeach
                        @else
                            @foreach(['Twitter', 'GitHub', 'LinkedIn', 'Telegram'] as $social)
                            <a href="#" class="flex flex-col items-center justify-center p-8 bg-white/5 border border-white/10 rounded-[2rem] hover:bg-white hover:text-slate-950 transition-all duration-500 group">
                                <span class="text-[10px] font-black uppercase tracking-[0.3em]">{{ $social }}</span>
                            </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
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
</style>
@endsection
