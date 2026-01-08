<!-- Enterprise Solutions (Light Modern Glossy) -->
<section class="py-24 lg:py-32 bg-transparent relative overflow-hidden" x-show="sections.product">
    <!-- Unique Animation: Structural Mesh -->
    <canvas id="enterprise-mesh-canvas" class="absolute inset-0 w-full h-full pointer-events-none opacity-[0.1]"></canvas>
    <div class="absolute inset-0 bg-gradient-to-b from-slate-50/50 to-transparent pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-20" data-aos="fade-up">
            <div class="inline-flex items-center px-4 py-1.5 rounded-full border border-sky-200 bg-white/50 shadow-sm mb-6 font-bold text-[10px] text-sky-600 uppercase tracking-[0.4em] backdrop-blur-sm" x-text="sections.product?.badge_text || 'Strategic Partnership'"></div>
            <h2 class="text-4xl lg:text-5xl font-bold heading-font text-slate-900 mb-6 tracking-tight">
                <span class="bg-gradient-to-r from-sky-600 to-indigo-600 bg-clip-text text-transparent" x-text="sections.product?.title || 'Security Ecosystem.'"></span>
            </h2>
            <p class="text-xl text-slate-500 max-w-2xl mx-auto font-light leading-relaxed italic" x-text="sections.product?.description"></p>
        </div>

        <!-- Product Cards Grid (Swiper on Mobile) -->
        <div class="flex overflow-x-auto snap-x snap-mandatory scrollbar-hide -mx-4 px-4 pb-8 gap-6 lg:grid lg:gap-8 lg:mx-0 lg:px-0 lg:pb-0 lg:overflow-visible"
             :class="{
                 'lg:grid-cols-4': sections.product?.settings?.items_per_row == 4,
                 'lg:grid-cols-3': !sections.product?.settings?.items_per_row || sections.product?.settings?.items_per_row == 3
             }">
            @foreach([
                [
                    'title' => 'Neural Firewall v.9', 
                    'desc' => 'Next-gen AI firewall with deep-packet inspection and real-time threat adaptation.', 
                    'color' => 'sky',
                    'image' => 'firewall.png'
                ],
                [
                    'title' => 'Endpoint Sentinel', 
                    'desc' => 'Autonomous edge protection ensuring zero-trust security for every device.', 
                    'color' => 'indigo',
                    'image' => 'endpoint.png'
                ],
                [
                    'title' => 'Data Vault X', 
                    'desc' => 'Quantum-resistant encryption architecture for mission-critical archives.', 
                    'color' => 'emerald',
                    'image' => 'datavault.png'
                ]
            ] as $product)
                <div class="snap-center flex-none w-[85vw] sm:w-[380px] lg:w-auto h-full" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="glossy-card group relative rounded-[2rem] overflow-hidden transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(0,0,0,0.1)] hover:border-{{ $product['color'] }}-200 h-full flex flex-col">
                        
                        <!-- Product Thumbnail -->
                        <div class="h-48 bg-slate-50/50 relative overflow-hidden flex items-center justify-center group-hover:bg-white/50 transition-colors flex-shrink-0">
                            <img src="{{ asset('images/' . $product['image']) }}" alt="{{ $product['title'] }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 mix-blend-multiply opacity-90 group-hover:opacity-100">
                            <!-- Clean Scan Line -->
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-{{ $product['color'] }}-400/30 to-transparent -translate-y-full group-hover:translate-y-full transition-transform duration-1000 ease-in-out pointer-events-none"></div>
                        </div>

                        <!-- Content -->
                        <div class="p-8 relative z-10 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-{{ $product['color'] }}-600 transition-colors">{{ $product['title'] }}</h3>
                            <p class="text-slate-500 text-sm leading-relaxed mb-8 flex-grow">{{ $product['desc'] }}</p>
                            
                            <a href="#" class="inline-flex items-center text-xs font-bold text-slate-700 uppercase tracking-widest group-hover:text-{{ $product['color'] }}-600 transition-colors border-b border-slate-200 pb-1 hover:border-{{ $product['color'] }}-500 mt-auto self-start">
                                Explore Specs
                                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<script>
    (function() {
        const canvas = document.getElementById('enterprise-mesh-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let points = [];
        const count = 20;

        function resize() {
            canvas.width = canvas.parentElement.offsetWidth;
            canvas.height = canvas.parentElement.offsetHeight;
            points = [];
            for(let i=0; i<count; i++) {
                points.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    vx: (Math.random() - 0.5) * 0.2,
                    vy: (Math.random() - 0.5) * 0.2
                });
            }
        }

        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.strokeStyle = '#4f46e5'; // Indigo-600
            ctx.lineWidth = 0.5;

            points.forEach((p, i) => {
                p.x += p.vx; p.y += p.vy;
                if(p.x < 0 || p.x > canvas.width) p.vx *= -1;
                if(p.y < 0 || p.y > canvas.height) p.vy *= -1;

                for(let j=i+1; j<points.length; j++) {
                    const p2 = points[j];
                    const dist = Math.hypot(p.x - p2.x, p.y - p2.y);
                    if(dist < 400) {
                        ctx.beginPath();
                        ctx.globalAlpha = (1 - (dist / 400)) * 0.5;
                        ctx.moveTo(p.x, p.y);
                        ctx.lineTo(p2.x, p2.y);
                        ctx.stroke();
                    }
                }
            });

            ctx.globalAlpha = 1;
            requestAnimationFrame(draw);
        }

        window.addEventListener('resize', resize);
        resize();
        draw();
    })();
</script>

<style>
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
</style>
