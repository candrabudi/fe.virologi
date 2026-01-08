@extends('layouts.app')

@section('meta_title', '404 - NODE_NOT_FOUND // VIROLOGI')

@section('content')
<div class="min-h-screen bg-[#020617] flex items-center justify-center relative overflow-hidden px-4">
    <!-- 1. Luxurious Cyber Background -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Deep Base -->
        <div class="absolute inset-0 bg-[#020617]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_#0ea5e908_0%,_transparent_70%)]"></div>
        
        <!-- Animated Canvas Point-to-Point -->
        <canvas id="error-canvas" class="absolute inset-0 w-full h-full opacity-40"></canvas>

        <!-- Large Background SVG 404 (Luxurious Trace) -->
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] select-none">
            <svg class="w-full h-full max-w-4xl" viewBox="0 0 400 200">
                <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" 
                    font-family="heading-font" font-weight="900" font-size="200"
                    fill="none" stroke="white" stroke-width="0.5" class="animate-stroke-trace">404</text>
            </svg>
        </div>
        
        <!-- Glowing Orbs -->
        <div class="absolute -top-[10%] -left-[10%] w-[500px] h-[500px] bg-sky-500/10 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[500px] h-[500px] bg-indigo-500/10 rounded-full blur-[120px]"></div>

        <!-- Scanning Line -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="w-full h-[1px] bg-gradient-to-r from-transparent via-cyan-500/30 to-transparent absolute animate-scan"></div>
        </div>
    </div>

    <div class="max-w-3xl w-full relative z-10 text-center">
        <!-- Main Error Display -->
        <div class="relative inline-block mb-16">
            <div class="absolute inset-0 blur-3xl bg-cyan-500/20 rounded-full animate-pulse"></div>
            <div class="relative z-10">
                <h1 class="text-[9rem] sm:text-[14rem] font-black heading-font leading-none tracking-tighter text-transparent bg-clip-text bg-gradient-to-b from-white via-white to-slate-800">
                    404
                </h1>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full flex items-center justify-center">
                    <div class="w-full h-[1px] bg-cyan-500/50 blur-[2px] animate-glitch-line"></div>
                </div>
            </div>
        </div>

        <div class="space-y-8" data-aos="fade-up">
            <div class="flex flex-col items-center">
                <div class="inline-flex items-center px-4 py-1.5 border border-cyan-500/30 bg-cyan-500/10 rounded-full mb-6">
                    <div class="w-1.5 h-1.5 rounded-full bg-cyan-500 animate-ping mr-3"></div>
                    <span class="text-[10px] font-bold text-cyan-400 uppercase tracking-[0.4em]">Node Connection Failure</span>
                </div>
                <h2 class="text-3xl sm:text-5xl font-black text-white heading-font tracking-tight mb-4">NODE_NOT_FOUND</h2>
                <p class="text-slate-400 text-sm sm:text-lg leading-relaxed max-w-lg mx-auto font-light">
                    Sinyal transmisi terputus atau koordinat yang Anda tuju tidak terdaftar dalam protokol Virologi.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-5 pt-8">
                <a href="/" class="group relative px-10 py-4 bg-white text-slate-900 rounded-xl font-bold text-xs uppercase tracking-widest overflow-hidden transition-all hover:shadow-[0_0_30px_rgba(255,255,255,0.3)] active:scale-95">
                    <span class="relative z-10">Return to Operations</span>
                </a>
                <a href="{{ route('contact') }}" class="px-10 py-4 border border-slate-700 text-slate-400 rounded-xl font-bold text-xs uppercase tracking-widest hover:border-cyan-500 hover:text-cyan-400 transition-all backdrop-blur-sm">
                    Strategic Support
                </a>
            </div>
        </div>

        <!-- Debug Meta Box -->
        <div class="mt-24 max-w-md mx-auto relative group" style="margin-top: 20px;">
            <div class="absolute inset-0 bg-cyan-500/5 blur-xl rounded-xl"></div>
            <div class="relative bg-slate-900/40 backdrop-blur-2xl border border-white/5 p-6 rounded-2xl text-left font-mono text-[10px] text-slate-500">
                <div class="flex items-center justify-between mb-4 border-b border-white/5 pb-3">
                    <span class="text-cyan-500 font-bold tracking-widest">SYSTEM_DIAGNOSTICS</span>
                    <span class="animate-pulse">ONLINE</span>
                </div>
                <div class="space-y-1.5 opacity-60 group-hover:opacity-100 transition-opacity">
                    <p><span class="text-slate-600">TIMESTAMP:</span> {{ date('Y.m.d H:i:s') }}</p>
                    <p><span class="text-slate-600">ERROR_TYPE:</span> SEGMENTATION_FAULT_404</p>
                    <p><span class="text-slate-600">PATH_ADDR:</span> {{ Request::path() }}</p>
                    <p><span class="text-slate-600">RESOLUTION:</span> FALLBACK(HOME_NODE)</p>
                </div>
                <div class="mt-4 flex gap-1">
                    <div class="w-1 h-1 bg-cyan-500/50 rounded-full animate-bounce"></div>
                    <div class="w-1 h-1 bg-cyan-500/50 rounded-full animate-bounce [animation-delay:0.2s]"></div>
                    <div class="w-1 h-1 bg-cyan-500/50 rounded-full animate-bounce [animation-delay:0.4s]"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes scan {
        0% { top: -10%; }
        100% { top: 110%; }
    }
    .animate-scan { animation: scan 6s linear infinite; }

    @keyframes glitch-line {
        0% { transform: scaleX(0); opacity: 0; }
        10% { transform: scaleX(1); opacity: 1; left: 0; }
        20% { opacity: 0; }
        100% { opacity: 0; }
    }
    .animate-glitch-line { animation: glitch-line 3s infinite; }

    @keyframes stroke-trace {
        0% { stroke-dasharray: 0 1000; opacity: 0; }
        50% { stroke-dasharray: 500 1000; opacity: 1; }
        100% { stroke-dasharray: 1000 1000; opacity: 0; }
    }
    .animate-stroke-trace { animation: stroke-trace 10s linear infinite; }

    canvas { pointer-events: none; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const canvas = document.getElementById('error-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let particles = [];
        const count = 40;

        function resize() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            particles = [];
            for(let i=0; i<count; i++) {
                particles.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    vx: (Math.random() - 0.5) * 0.4,
                    vy: (Math.random() - 0.5) * 0.4
                });
            }
        }

        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = 'rgba(14, 165, 233, 0.3)';
            ctx.strokeStyle = 'rgba(14, 165, 233, 0.1)';
            
            particles.forEach((p, i) => {
                p.x += p.vx;
                p.y += p.vy;
                if(p.x < 0) p.x = canvas.width;
                if(p.x > canvas.width) p.x = 0;
                if(p.y < 0) p.y = canvas.height;
                if(p.y > canvas.height) p.y = 0;

                ctx.beginPath();
                ctx.arc(p.x, p.y, 1, 0, Math.PI * 2);
                ctx.fill();

                for(let j=i+1; j<particles.length; j++) {
                    const p2 = particles[j];
                    const dist = Math.hypot(p.x - p2.x, p.y - p2.y);
                    if(dist < 150) {
                        ctx.beginPath();
                        ctx.moveTo(p.x, p.y);
                        ctx.lineTo(p2.x, p2.y);
                        ctx.stroke();
                    }
                }
            });
            requestAnimationFrame(draw);
        }

        window.addEventListener('resize', resize);
        resize();
        draw();
    });
</script>
@endsection
