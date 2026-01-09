<!-- 5. Product Solutions -->
<section class="py-16 lg:py-24 bg-white overflow-hidden relative" x-data="{
    scroll(dir) { this.$refs.pSlider.scrollBy({ left: dir * 300, behavior: 'smooth' }); }
}">
    <!-- Unique Animation: Digital Grid -->
    <canvas id="products-grid-canvas" class="absolute inset-x-0 bottom-0 w-full h-[60%] pointer-events-none opacity-[0.05]"></canvas>
    <div class="absolute inset-0 bg-gradient-to-b from-white via-transparent to-white pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 lg:mb-16 gap-8">
            <div class="max-w-xl" data-aos="fade-right">
                <div class="text-[10px] font-bold text-sky-500 uppercase tracking-[0.4em] mb-4" x-text="sections.product?.badge_text"></div>
                <h2 class="text-3xl lg:text-5xl font-bold heading-font text-slate-900 mb-4 tracking-tight" x-text="sections.product?.title"></h2>
                <p class="text-slate-500 leading-relaxed italic text-sm lg:text-base" x-text="sections.product?.description"></p>
            </div>
            <div class="flex items-center space-x-2" data-aos="fade-left">
                <button @click="scroll(-1)" class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center hover:border-slate-900 transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg></button>
                <button @click="scroll(1)" class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center hover:border-slate-900 transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></button>
            </div>
        </div>

        <div x-ref="pSlider" class="flex space-x-6 lg:space-x-8 overflow-x-auto scrollbar-hide pb-10 snap-x">
            <template x-for="product in products" :key="product.id">
                <a :href="'/products/' + product.slug" class="flex-none w-[280px] lg:w-[320px] group snap-start" data-aos="fade-up">
                    <div class="relative aspect-square rounded-[2rem] lg:rounded-[2.5rem] overflow-hidden bg-slate-50 mb-6 border border-slate-100/50 shadow-sm transition-all duration-700 group-hover:shadow-xl">
                        <img :src="product.thumbnail || (product.primary_image ? product.primary_image.image_path : '')" :alt="product.name" loading="lazy" class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110">
                        <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur border border-slate-100 rounded-lg text-[9px] font-bold uppercase tracking-widest text-slate-900" x-text="product.ai_domain.replace('_', ' ')"></div>
                    </div>
                    <h3 class="text-lg lg:text-xl font-bold text-slate-900 mb-2 heading-font group-hover:text-sky-500 transition-colors" x-text="product.name"></h3>
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Architectural Solution &rarr;</p>
                </a>
            </template>
        </div>
    </div>
</section>

<script>
    (function() {
        const canvas = document.getElementById('products-grid-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let offset = 0;

        function resize() {
            canvas.width = canvas.parentElement.offsetWidth;
            canvas.height = canvas.parentElement.offsetHeight * 0.6;
        }

        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.strokeStyle = '#0284c7'; // Sky-700
            ctx.lineWidth = 1;

            const gridSpacing = 60;
            const perspective = 0.8;
            
            offset = (offset + 0.5) % gridSpacing;

            // Horizontal lines with perspective
            for (let i = 0; i < 15; i++) {
                const y = (i * gridSpacing + offset) % (canvas.height);
                const alpha = (y / canvas.height);
                ctx.globalAlpha = alpha * 0.5;
                ctx.beginPath();
                ctx.moveTo(0, y);
                ctx.lineTo(canvas.width, y);
                ctx.stroke();
            }

            // Vertical lines converging
            const centerX = canvas.width / 2;
            ctx.globalAlpha = 0.2;
            for (let i = -10; i <= 10; i++) {
                ctx.beginPath();
                ctx.moveTo(centerX + i * gridSpacing * 4, canvas.height);
                ctx.lineTo(centerX + i * gridSpacing * 0.5, 0);
                ctx.stroke();
            }

            ctx.globalAlpha = 1;
            requestAnimationFrame(draw);
        }

        window.addEventListener('resize', resize);
        resize();
        draw();
    })();
</script>
