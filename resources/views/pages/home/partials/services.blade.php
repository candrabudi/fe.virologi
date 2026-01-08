<!-- 6. Cyber Security Services -->
<section class="py-16 lg:py-24 bg-slate-50 relative overflow-hidden" x-show="services.length > 0">
    <!-- Unique Animation: Cyber Pulse -->
    <canvas id="services-pulse-canvas" class="absolute inset-0 w-full h-full pointer-events-none opacity-[0.2]"></canvas>
    
    <!-- Decor -->
    <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-sky-100/30 to-transparent pointer-events-none"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8">
            <div class="max-w-2xl" data-aos="fade-right">
                <div class="text-[10px] font-bold text-indigo-600 uppercase tracking-[0.4em] mb-4">Operational Support</div>
                <h2 class="text-3xl lg:text-5xl font-black heading-font text-slate-900 mb-6 tracking-tight">Cyber Security <span class="text-indigo-600">Layanan & Keahlian.</span></h2>
                <p class="text-slate-500 leading-relaxed font-medium">Mitigasi risiko dan perlindungan infrastruktur digital melalui pendekatan intelijen teknis tingkat tinggi.</p>
            </div>
            <div data-aos="fade-left">
                <a href="{{ route('services.index') }}" class="inline-flex items-center space-x-3 px-8 py-4 bg-white border border-slate-200 rounded-2xl text-xs font-bold text-slate-900 uppercase tracking-widest hover:border-indigo-600 transition-all shadow-sm">
                    <span>Semua Layanan</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <template x-for="service in services" :key="service.id">
                <div class="group relative bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm transition-all duration-500 hover:shadow-2xl hover:shadow-indigo-900/10 hover:-translate-y-2 h-full flex flex-col" data-aos="fade-up">
                    <!-- Icon / Category Badge -->
                    <div class="mb-8 flex items-center justify-between">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500">
                            <!-- Dynamic Icon Mockup -->
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 px-3 py-1.5 rounded-lg" x-text="service.category.replace('_', ' ')"></span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-4 tracking-tight group-hover:text-indigo-600 transition-colors" x-text="service.name"></h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-8 flex-grow" x-text="service.summary"></p>

                    <div class="pt-6 border-t border-slate-50 mt-auto">
                        <a :href="'/layanan/' + service.slug" class="flex items-center justify-between w-full text-[10px] font-bold text-slate-900 uppercase tracking-[0.2em] group/btn">
                            <span>Detail Layanan</span>
                            <div class="w-8 h-8 rounded-full border border-slate-200 flex items-center justify-center group-hover/btn:bg-slate-900 group-hover/btn:text-white transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </a>
                    </div>
                </div>
            </template>
        </div>
    </div>
</section>

<script>
    (function() {
        const canvas = document.getElementById('services-pulse-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let particles = [];
        const count = 30;

        function resize() {
            canvas.width = canvas.parentElement.offsetWidth;
            canvas.height = canvas.parentElement.offsetHeight;
            particles = [];
            for(let i=0; i<count; i++) {
                particles.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    h: Math.random() * 40 + 20,
                    v: Math.random() * 0.5 + 0.2,
                    w: Math.random() * 2 + 1,
                    alpha: Math.random() * 0.5 + 0.1
                });
            }
        }

        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = '#6366f1'; // Indigo-500

            particles.forEach((p) => {
                p.y -= p.v;
                if(p.y < -p.h) p.y = canvas.height + p.h;

                ctx.globalAlpha = p.alpha;
                ctx.fillRect(p.x, p.y, p.w, p.h);
                
                // Pulse effect
                const pulse = Math.sin(Date.now() / 1000 + p.x) * 0.05;
                ctx.globalAlpha = p.alpha + pulse;
                ctx.fillRect(p.x - 2, p.y, p.w + 4, p.h);
            });

            ctx.globalAlpha = 1;
            requestAnimationFrame(draw);
        }

        window.addEventListener('resize', resize);
        resize();
        draw();
    })();
</script>
