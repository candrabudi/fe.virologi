@extends('layouts.app')

@section('meta_title', '503 - SERVICE_UNAVAILABLE // VIROLOGI')

@section('content')
<div class="min-h-screen bg-[#020617] flex items-center justify-center relative overflow-hidden px-4">
    <!-- Cyber Background -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_#0ea5e905_0%,_transparent_70%)]"></div>
        
        <!-- Animated Grid -->
        <svg class="absolute inset-0 w-full h-full opacity-[0.1]">
            <pattern id="grid-503" width="80" height="80" patternUnits="userSpaceOnUse">
                <path d="M 80 0 L 0 0 0 80" fill="none" stroke="#94a3b8" stroke-width="0.5"/>
            </pattern>
            <rect width="100%" height="100%" fill="url(#grid-503)" />
        </svg>
    </div>

    <div class="max-w-2xl w-full relative z-10 text-center">
        <!-- Maintenance Icon -->
        <div class="relative inline-block mb-12">
            <div class="w-24 h-24 bg-slate-900 border border-cyan-500/20 rounded-[2rem] flex items-center justify-center mx-auto shadow-2xl relative transition-transform hover:rotate-12 duration-500">
                <svg class="w-10 h-10 text-cyan-500 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
            </div>
            <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-cyan-600 rounded-lg flex items-center justify-center text-white shadow-lg animate-bounce">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
            </div>
        </div>

        <div class="space-y-6" data-aos="fade-up">
            <div class="inline-flex items-center px-4 py-1.5 border border-cyan-500/30 bg-cyan-500/10 rounded-full mb-4">
                <div class="w-2 h-2 rounded-full bg-cyan-500 animate-pulse mr-3"></div>
                <span class="text-[10px] font-bold text-cyan-500 uppercase tracking-[0.3em]">System Recalibration // Maintenance Mode</span>
            </div>
            
            <h1 class="text-4xl lg:text-6xl font-black heading-font text-white tracking-tighter mb-4">Under Maintenance.</h1>
            <p class="text-slate-400 text-sm sm:text-base leading-relaxed max-w-md mx-auto font-light">
                Kami sedang melakukan pemeliharaan rutin untuk meningkatkan keamanan dan performa protokol Virologi. Harap tunggu sebentar, kami akan segera kembali online.
            </p>

            <div class="pt-10">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-6">Estimated Uptime: <span class="text-cyan-400">Soon</span></div>
                <div class="w-48 h-1 bg-slate-900 rounded-full mx-auto overflow-hidden">
                    <div class="h-full bg-cyan-500 w-[65%] animate-pulse"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 10s linear infinite;
    }
</style>
@endsection
