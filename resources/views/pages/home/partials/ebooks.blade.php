
<!-- 3. Strategic Intelligence (E-Books) -->
<section class="py-16 lg:py-24 bg-white relative overflow-hidden"
    x-data="{
        isDown: false,
        startX: 0,
        scrollLeft: 0,
        ebScroll(dir) { this.$refs.ebSlider.scrollBy({ left: dir * 300, behavior: 'smooth' }); },
        startDrag(e) {
            this.isDown = true;
            this.startX = e.pageX - this.$refs.ebSlider.offsetLeft;
            this.scrollLeft = this.$refs.ebSlider.scrollLeft;
        },
        stopDrag() { this.isDown = false; },
        moveDrag(e) {
            if (!this.isDown) return;
            e.preventDefault();
            const x = e.pageX - this.$refs.ebSlider.offsetLeft;
            const walk = (x - this.startX) * 1.5;
            this.$refs.ebSlider.scrollLeft = this.scrollLeft - walk;
        }
    }">

    <!-- Unique Animation: Knowledge Nodes -->
    <canvas id="ebooks-nodes-canvas" class="absolute inset-0 w-full h-full pointer-events-none opacity-[0.15]"></canvas>
    <div class="absolute inset-0 bg-gradient-to-t from-slate-50 to-transparent pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-12 lg:mb-16 gap-8">
            <div class="max-w-xl" data-aos="fade-right">
                <div class="text-[10px] font-bold text-sky-600 uppercase tracking-[0.4em] mb-4" x-text="sections.ebook?.badge_text || 'Strategic Intelligence'"></div>
                <h2 class="text-3xl lg:text-5xl font-bold heading-font text-slate-900 mb-6 tracking-tight" x-text="sections.ebook?.title || 'E-Book Publications.'"></h2>
                <p class="text-slate-600 text-sm lg:text-base leading-relaxed" x-text="sections.ebook?.description"></p>
            </div>
            <div class="flex items-center space-x-3" data-aos="fade-left">
                <button @click="ebScroll(-1)" class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-white/50 border border-white/60 text-slate-500 flex items-center justify-center hover:bg-white/80 hover:text-sky-600 transition-all active:scale-95 shadow-sm backdrop-blur-md"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg></button>
                <button @click="ebScroll(1)" class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-white/50 border border-white/60 text-slate-500 flex items-center justify-center hover:bg-white/80 hover:text-sky-600 transition-all active:scale-95 shadow-sm backdrop-blur-md"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start" x-show="ebooks.length > 0">
            <!-- Featured E-Book -->
            <div class="lg:col-span-4 group" data-aos="fade-up" x-show="sections.ebook?.settings?.show_featured !== false">
                <template x-if="ebooks[0]">
                    <div class="flex flex-col h-full cursor-pointer">
                        <a :href="'/ebooks/' + ebooks[0].slug" class="block">
                            <!-- Image Container -->
                            <div class="glossy-card relative aspect-[3/4] rounded-[2.5rem] overflow-hidden mb-8 transition-all duration-700 hover:shadow-2xl hover:scale-[1.02] border border-slate-100 group-hover:border-sky-200">
                                <img :src="ebooks[0].cover_image" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                                <!-- Badge inside image -->
                                <div class="absolute top-6 left-6 px-3 py-1 bg-white/90 backdrop-blur-md text-sky-600 border border-sky-100 rounded-lg text-[9px] font-bold uppercase tracking-widest shadow-sm">Latest Release</div>
                            </div>
                            <!-- Text Content Outside Image (No Overlap) -->
                            <div class="px-2">
                                <h3 class="text-lg lg:text-xl font-bold text-slate-950 mb-4 heading-font leading-tight group-hover:text-sky-600 transition-colors" x-text="ebooks[0].title.length > 30 ? ebooks[0].title.substring(0, 30) + '...' : ebooks[0].title"></h3>
                                <p class="text-slate-500 text-xs lg:text-sm leading-relaxed mb-6 font-light line-clamp-2" x-text="ebooks[0].summary"></p>
                                <div class="inline-flex items-center text-[10px] font-black text-sky-600 uppercase tracking-[0.2em] group-hover:translate-x-2 transition-transform">
                                    Download Analysis &rarr;
                                </div>
                            </div>
                        </a>
                    </div>
                </template>
            </div>

            <!-- Scroller -->
            <div class="lg:col-span-8">
                <div x-ref="ebSlider" @mousedown="startDrag($event)" @mouseleave="stopDrag()" @mouseup="stopDrag()" @mousemove="moveDrag($event)" class="flex overflow-x-auto snap-x snap-mandatory lg:snap-none scrollbar-hide pb-10 cursor-grab active:cursor-grabbing select-none -mx-4 px-4 sm:-mx-6 sm:px-6 lg:-mx-0 lg:px-0 transition-all">
                    <div class="flex gap-6 lg:gap-8 pr-12">
                        <template x-for="(ebook, index) in ebooks.slice(1)" :key="ebook.id">
                            <div class="flex-none w-[280px] lg:w-[300px] group snap-start" data-aos="fade-up" :data-aos-delay="index * 100">
                                <a :href="'/ebooks/' + ebook.slug" class="block">
                                    <div class="glossy-card relative aspect-[3/4] rounded-[2rem] overflow-hidden mb-6 transition-all duration-500 hover:-translate-y-2 hover:shadow-lg">
                                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-purple-500/5 mix-blend-overlay"></div>
                                        <img :src="ebook.cover_image" class="w-full h-full object-cover grayscale opacity-90 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700">
                                    </div>
                                    <div class="px-2">
                                        <div class="text-[9px] font-bold text-sky-600 uppercase tracking-widest mb-2" x-text="ebook.topic.replace('_', ' ')"></div>
                                        <h4 class="text-sm lg:text-base font-bold text-slate-800 mb-2 heading-font group-hover:text-sky-600 transition-colors" x-text="ebook.title.length > 30 ? ebook.title.substring(0, 30) + '...' : ebook.title"></h4>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest group-hover:text-slate-600 transition-colors">Read Journal &rarr;</p>
                                    </div>
                                </a>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    (function() {
        const canvas = document.getElementById('ebooks-nodes-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let nodes = [];
        const count = 15;

        function resize() {
            canvas.width = canvas.parentElement.offsetWidth;
            canvas.height = canvas.parentElement.offsetHeight;
            nodes = [];
            for(let i=0; i<count; i++) {
                nodes.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    s: Math.random() * 30 + 10,
                    vx: (Math.random() - 0.5) * 0.4,
                    vy: (Math.random() - 0.5) * 0.4,
                    rot: Math.random() * Math.PI,
                    vrot: (Math.random() - 0.5) * 0.01
                });
            }
        }

        function drawHexagon(x, y, size, rot) {
            ctx.beginPath();
            for (let i = 0; i < 6; i++) {
                ctx.lineTo(x + size * Math.cos(rot + i * Math.PI / 3), y + size * Math.sin(rot + i * Math.PI / 3));
            }
            ctx.closePath();
            ctx.stroke();
        }

        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.strokeStyle = '#0ea5e9';
            ctx.lineWidth = 1;

            nodes.forEach((n, i) => {
                n.x += n.vx; n.y += n.vy; n.rot += n.vrot;
                if(n.x < -n.s) n.x = canvas.width + n.s;
                if(n.x > canvas.width + n.s) n.x = -n.s;
                if(n.y < -n.s) n.y = canvas.height + n.s;
                if(n.y > canvas.height + n.s) n.y = -n.s;

                drawHexagon(n.x, n.y, n.s, n.rot);

                for(let j=i+1; j<nodes.length; j++) {
                    const n2 = nodes[j];
                    const dist = Math.hypot(n.x - n2.x, n.y - n2.y);
                    if(dist < 300) {
                        ctx.beginPath();
                        ctx.globalAlpha = 1 - (dist / 300);
                        ctx.moveTo(n.x, n.y);
                        ctx.lineTo(n2.x, n2.y);
                        ctx.stroke();
                        ctx.globalAlpha = 1;
                    }
                }
            });
            requestAnimationFrame(draw);
        }

        window.addEventListener('resize', resize);
        resize();
        draw();
    })();
</script>
