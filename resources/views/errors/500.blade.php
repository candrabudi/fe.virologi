<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - SYSTEM_FAILURE // VIROLOGI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #020617; }
        @keyframes scan { 0% { top: -10%; } 100% { top: 110%; } }
        .animate-scan { animation: scan 4s linear infinite; }
        @keyframes stroke-trace {
            0% { stroke-dasharray: 0 1000; opacity: 0; }
            50% { stroke-dasharray: 500 1000; opacity: 1; }
            100% { stroke-dasharray: 1000 1000; opacity: 0; }
        }
        .animate-stroke-trace { animation: stroke-trace 10s linear infinite; }
    </style>
</head>
<body class="text-white overflow-hidden">
    <div class="min-h-screen flex items-center justify-center relative px-4">
        <!-- Luxurious Cyber Background -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 bg-[#020617]"></div>
            
            <!-- Red Point-to-Point Canvas -->
            <canvas id="error-canvas" class="absolute inset-0 w-full h-full opacity-30"></canvas>

            <!-- Large Background SVG 500 -->
            <div class="absolute inset-0 flex items-center justify-center opacity-[0.04] select-none">
                <svg class="w-full h-full max-w-4xl" viewBox="0 0 400 200">
                    <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" 
                        font-family="Plus Jakarta Sans" font-weight="900" font-size="180"
                        fill="none" stroke="#f43f5e" stroke-width="0.5" class="animate-stroke-trace uppercase">Error</text>
                </svg>
            </div>

            <!-- Glowing Red Orbs -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-red-600/10 rounded-full blur-[120px] animate-pulse"></div>
            
            <!-- Scanning Line -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="w-full h-[1px] bg-gradient-to-r from-transparent via-red-500/30 to-transparent absolute animate-scan"></div>
            </div>
        </div>

        <div class="max-w-2xl w-full relative z-10 text-center">
            <!-- Glitch Icon -->
            <div class="mb-12 relative inline-block group">
                <div class="w-24 h-24 bg-red-950/20 border border-red-500/30 rounded-3xl flex items-center justify-center mx-auto shadow-2xl relative transition-transform group-hover:scale-110 duration-500">
                    <svg class="w-12 h-12 text-red-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="absolute inset-x-0 bottom-2 flex justify-center">
                        <div class="w-8 h-[1px] bg-red-500/50 blur-[1px]"></div>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="inline-flex items-center px-4 py-1.5 border border-red-500/30 bg-red-500/10 rounded-full animate-pulse">
                    <span class="text-[10px] font-bold text-red-500 uppercase tracking-[0.4em]">Internal System Corruption</span>
                </div>
                
                <h1 class="text-5xl sm:text-7xl font-black tracking-tighter heading-font italic text-transparent bg-clip-text bg-gradient-to-b from-white to-red-900">SYSTEM_ERROR</h1>
                <p class="text-slate-400 text-sm sm:text-lg leading-relaxed max-w-lg mx-auto font-light">
                    Terjadi kegagalan komunikasi internal pada protokol server kami. Tim teknis sedang melakukan inisialisasi darurat.
                </p>

                <div class="pt-10 flex flex-col sm:flex-row items-center justify-center gap-5">
                    <button onclick="window.location.reload()" class="px-10 py-4 bg-red-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-red-500 transition-all shadow-xl shadow-red-900/40 active:scale-95 w-full sm:w-auto">
                        Inisialisasi Ulang
                    </button>
                    <a href="/" class="px-10 py-4 border border-slate-700 text-slate-400 rounded-xl font-bold text-xs uppercase tracking-widest hover:border-slate-500 hover:text-white transition-all w-full sm:w-auto">
                        Safe Protocol
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('error-canvas');
            const ctx = canvas.getContext('2d');
            let particles = [];
            const count = 35;

            function resize() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
                particles = [];
                for(let i=0; i<count; i++) {
                    particles.push({
                        x: Math.random() * canvas.width,
                        y: Math.random() * canvas.height,
                        vx: (Math.random() - 0.5) * 0.3,
                        vy: (Math.random() - 0.5) * 0.3
                    });
                }
            }

            function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = 'rgba(239, 68, 68, 0.4)';
                ctx.strokeStyle = 'rgba(239, 68, 68, 0.1)';
                
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
                        if(dist < 180) {
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
</body>
</html>
