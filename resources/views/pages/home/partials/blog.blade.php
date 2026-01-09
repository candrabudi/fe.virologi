<!-- 7. Intelligence Feed (Blog) -->
<section class="py-24 lg:py-32 bg-transparent relative overflow-hidden" data-aos="fade-up">
    <!-- Unique Animation: Digital Waves -->
    <canvas id="blog-waves-canvas" class="absolute inset-0 w-full h-full pointer-events-none opacity-[0.1]"></canvas>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-20 lg:mb-24 gap-8 border-b border-slate-200/50 pb-12">
            <div data-aos="fade-right">
                <div class="text-[10px] font-bold text-sky-600 uppercase tracking-[0.4em] mb-4" x-text="sections.blog?.badge_text || 'World Research Feed'"></div>
                <h2 class="text-4xl lg:text-7xl font-bold heading-font text-slate-900 tracking-tighter" x-text="sections.blog?.title || 'Intelligence Feed.'"></h2>
            </div>
            <div data-aos="fade-left" class="flex items-center space-x-6">
                <div class="hidden lg:flex flex-col text-right">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Global Updates</span>
                    <span class="text-sm font-bold text-slate-900">24 New Reports Today</span>
                </div>
                <template x-if="sections.blog?.primary_button_text">
                    <a :href="sections.blog?.primary_button_url" class="inline-flex items-center px-8 py-4 bg-slate-900 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-sky-600 transition-all shadow-xl shadow-slate-900/10" x-text="sections.blog.primary_button_text"></a>
                </template>
            </div>
        </div>

        <!-- Main Featured Article: Glass Effect -->
        <template x-if="articles.length > 0">
            <div class="mb-12 lg:mb-20" data-aos="fade-up">
                <a :href="'/blog/' + articles[0].slug" class="block glossy-card rounded-[2.5rem] p-8 lg:p-10 transition-all duration-700 hover:shadow-[0_20px_60px_rgba(14,165,233,0.15)] group cursor-pointer">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div class="relative aspect-[16/10] rounded-2xl overflow-hidden shadow-lg group-hover:shadow-2xl transition-all duration-700 border border-white/50">
                            <img :src="articles[0].thumbnail" :alt="articles[0].title" loading="lazy" class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-slate-900/0 to-transparent"></div>
                            <div class="absolute bottom-6 left-6 px-4 py-2 bg-white/10 backdrop-blur-md rounded-lg border border-white/20 text-white text-[10px] font-bold uppercase tracking-widest">Featured Analysis</div>
                        </div>
                             <div>
                            <div class="flex items-center space-x-4 mb-8">
                                <span class="text-[10px] font-bold text-sky-600 uppercase tracking-widest bg-sky-50/50 border border-sky-100 px-3 py-1 rounded-lg" x-text="articles[0].categories[0]?.name || 'Intelligence'"></span>
                                <span class="text-slate-300">/</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest" x-text="new Date(articles[0].published_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })"></span>
                            </div>
                            <h3 class="text-xl lg:text-3xl font-bold text-slate-900 mb-8 heading-font leading-[1.1] transition-colors group-hover:text-sky-600" x-text="articles[0].title.length > 30 ? articles[0].title.substring(0, 30) + '...' : articles[0].title"></h3>
                            <p class="text-lg text-slate-500 leading-relaxed mb-10 font-light" x-text="articles[0].excerpt"></p>
                            <div class="flex items-center justify-between pt-8 border-t border-slate-200/50">
                                    <div class="flex items-center space-x-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-1"></span> 5 Min Read Analysis
                                </div>
                                <span class="inline-flex items-center text-sm font-bold text-slate-900 group-hover:translate-x-3 transition-transform">Full Intelligence Report <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </template>

        <!-- Secondary Grid: Editorial Cards (Swiper on Mobile) -->
        <div class="flex overflow-x-auto snap-x snap-mandatory scrollbar-hide -mx-4 px-4 pb-8 gap-6 lg:grid lg:grid-cols-3 lg:gap-10 lg:mx-0 lg:px-0 lg:pb-0 lg:overflow-visible">
            <template x-for="(post, index) in articles.slice(1)" :key="post.id">
                <div class="snap-center flex-none w-[85vw] sm:w-[380px] lg:w-auto h-full group cursor-pointer" data-aos="fade-up" :data-aos-delay="index * 100">
                    <a :href="'/blog/' + post.slug" class="block glossy-card rounded-3xl p-6 h-full hover:shadow-lg transition-all duration-500 hover:-translate-y-2 flex flex-col">
                        <div class="relative aspect-[4/3] rounded-2xl overflow-hidden mb-8 border border-white/50 grayscale group-hover:grayscale-0 transition-all duration-700 bg-slate-100">
                            <img :src="post.thumbnail" :alt="post.title" loading="lazy" class="w-full h-full object-cover">
                        </div>
                        <div class="text-[9px] font-bold text-sky-600 uppercase tracking-[0.3em] mb-4 bg-sky-50/50 inline-block px-3 py-1 rounded-full border border-sky-100 self-start" x-text="post.categories[0]?.name || 'Insight'"></div>
                        <h4 class="text-xl font-bold text-slate-900 mb-6 heading-font leading-snug transition-colors group-hover:text-sky-600 flex-grow" x-text="post.title.length > 30 ? post.title.substring(0, 30) + '...' : post.title"></h4>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest group-hover:text-slate-900 transition-colors mt-auto">Open Analysis &rarr;</p>
                    </a>
                </div>
            </template>
        </div>
    </div>
</section>

<script>
    (function() {
        const canvas = document.getElementById('blog-waves-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let time = 0;

        function resize() {
            canvas.width = canvas.parentElement.offsetWidth;
            canvas.height = canvas.parentElement.offsetHeight;
        }

        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.strokeStyle = '#0ea5e9'; // Sky-500
            ctx.lineWidth = 1;

            for (let i = 0; i < 4; i++) {
                ctx.beginPath();
                ctx.globalAlpha = 0.2 - (i * 0.04);
                
                const yBase = canvas.height * (0.4 + i * 0.1);
                const amplitude = 30 + (i * 10);
                const frequency = 0.002 + (i * 0.0005);

                for (let x = 0; x <= canvas.width; x += 10) {
                    const y = yBase + Math.sin(x * frequency + time * (1 + i * 0.2)) * amplitude;
                    if (x === 0) ctx.moveTo(x, y);
                    else ctx.lineTo(x, y);
                }
                ctx.stroke();
            }

            time += 0.015;
            ctx.globalAlpha = 1;
            requestAnimationFrame(draw);
        }

        window.addEventListener('resize', resize);
        resize();
        draw();
    })();
</script>

<style>
    .truncate-2-lines {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
