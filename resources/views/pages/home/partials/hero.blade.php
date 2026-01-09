<!-- 1. Dark Blue Cyber-Glass Hero (Point-to-Point Network) -->
<section class="min-h-[100svh] lg:min-h-screen flex items-center relative overflow-hidden px-4 pt-28 lg:pt-32 pb-12 lg:py-0 bg-[#020617] perspective-1000" x-data="{ mouseX: 0, mouseY: 0 }"
    @mousemove="mouseX = $event.clientX; mouseY = $event.clientY">

    <!-- Cyber Background Layers -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- 1. Deep Blue Base with Vignette -->
        <div class="absolute inset-0 bg-[#020617]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_transparent_0%,_#020617_100%)]"></div>

        <!-- 2. Point-to-Point Network Canvas -->
        <canvas id="cyber-network" class="absolute inset-0 w-full h-full opacity-40"></canvas>

        <!-- 3. Glowing "Glass" Orbs -->
        <div class="absolute top-[-10%] right-[-5%] w-[400px] lg:w-[600px] h-[400px] lg:h-[600px] bg-blue-600/10 rounded-full blur-[80px] lg:blur-[100px] mix-blend-screen animate-pulse"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[300px] lg:w-[500px] h-[300px] lg:h-[500px] bg-cyan-600/10 rounded-full blur-[80px] lg:blur-[100px] mix-blend-screen"></div>
    </div>

    <div class="max-w-7xl mx-auto w-full relative z-10 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-8 items-center">
            
            <!-- Left: Typography & Actions -->
            <div class="lg:col-span-7 relative z-20 text-center lg:text-left pt-6 lg:pt-0" data-aos="fade-right">
                
                <!-- Badge: Dark Cyber Pill -->
                <div class="inline-flex items-center space-x-2 bg-slate-900/50 backdrop-blur-md border border-cyan-500/30 rounded-full pl-1 pr-4 py-1 mb-6 lg:mb-8 shadow-[0_0_15px_rgba(6,182,212,0.15)] group transition-all hover:bg-slate-900/80 hover:border-cyan-400/50 mx-auto lg:mx-0">
                    <div class="bg-cyan-500 text-[#020617] text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider relative overflow-hidden">
                        <span class="relative z-10">Connected</span>
                        <div class="absolute inset-0 bg-white/30 animate-[shimmer_2s_infinite]"></div>
                    </div>
                    <span class="text-xs font-bold text-cyan-100/80 tracking-wide group-hover:text-cyan-50 transition-colors" x-text="hero.badge_text || 'Neural Network Active'"></span>
                </div>

                <!-- Main Title -->
                <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-[5.5rem] font-black heading-font leading-[0.95] mb-6 lg:mb-8 text-white tracking-tight">
                    <span class="block text-slate-700 text-4xl sm:text-6xl lg:text-[6rem] mb-[-5px] lg:mb-[-10px] font-bold tracking-tighter mix-blend-overlay opacity-50" x-text="hero.subtitle"></span>
                    <span x-html="hero.title" class="relative z-10 inline-block bg-gradient-to-r from-white via-slate-200 to-cyan-400 bg-clip-text text-transparent drop-shadow-[0_0_15px_rgba(255,255,255,0.1)]"></span>
                </h1>

                <p class="text-base sm:text-lg text-slate-400 mb-8 lg:mb-10 max-w-lg leading-relaxed font-light border-l-2 border-cyan-500/50 pl-6 mx-auto lg:mx-0 text-left">
                    <span x-text="hero.description"></span>
                </p>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row items-center gap-4 lg:gap-5 justify-center lg:justify-start">
                    <template x-if="hero.primary_button_text">
                        <a :href="hero.primary_button_url" class="group relative px-6 py-2.5 lg:py-3 bg-cyan-500 text-[#020617] rounded-xl font-bold text-xs tracking-widest overflow-hidden shadow-[0_0_20px_rgba(6,182,212,0.3)] hover:shadow-[0_0_30px_rgba(6,182,212,0.5)] hover:-translate-y-1 transition-all w-full sm:w-auto text-center order-1">
                            <div class="absolute inset-0 w-full h-full bg-white/20 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></div>
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                <span x-text="hero.primary_button_text"></span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </span>
                        </a>
                    </template>

                    <!-- Leak Check Button -->
                    <a href="{{ route('leak-check.index') }}" class="group relative px-6 py-2.5 lg:py-3 bg-emerald-500 text-[#020617] rounded-xl font-bold text-xs tracking-widest overflow-hidden shadow-[0_0_20px_rgba(16,185,129,0.3)] hover:shadow-[0_0_30px_rgba(16,185,129,0.5)] hover:-translate-y-1 transition-all w-full sm:w-auto text-center order-2">
                        <div class="absolute inset-0 w-full h-full bg-white/20 scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></div>
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <span>Periksa Kebocoran</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        </span>
                    </a>
                    
                    <template x-if="hero.secondary_button_text">
                        <a :href="hero.secondary_button_url" class="group px-6 py-2.5 lg:py-3 bg-slate-900/50 border border-slate-700 text-slate-300 rounded-xl font-bold text-xs tracking-widest hover:border-cyan-500/50 hover:text-cyan-400 hover:bg-slate-900/80 transition-all w-full sm:w-auto text-center backdrop-blur-sm flex items-center justify-center gap-2 order-3">
                            <span class="w-2 h-2 rounded-full bg-slate-600 group-hover:bg-cyan-500 transition-colors shadow-[0_0_10px_rgba(6,182,212,0.5)]"></span>
                            <span x-text="hero.secondary_button_text"></span>
                        </a>
                    </template>
                </div>
            </div>

            <!-- Right: 3D Dark Glass Stack HUD -->
            <div class="lg:col-span-5 relative h-[320px] lg:h-[500px] perspective-[2000px] w-full" data-aos="fade-left" data-aos-delay="200">
                <div class="relative w-full h-full transform-style-3d rotate-y-[-5deg] lg:rotate-y-[-12deg] rotate-x-[5deg] transition-transform duration-700 ease-out scale-[0.7] sm:scale-90 lg:scale-100 origin-center lg:origin-center">
                    
                    <!-- Layer 1: Dark Base (Blurred) -->
                    <div class="absolute top-10 left-10 right-0 bottom-10 bg-[#0B1120]/80 backdrop-blur-xl border border-white/5 rounded-[2rem] shadow-2xl transform translate-z-[-50px]"></div>

                    <!-- Layer 2: Main Interface (Dark Glass) -->
                    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-md rounded-[2rem] p-6 lg:p-8 flex flex-col justify-between transform translate-z-[0px] shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-white/10 group">
                        <!-- Header -->
                        <div class="flex justify-between items-center border-b border-white/5 pb-4">
                            <div class="flex space-x-2">
                                <div class="w-3 h-3 rounded-full bg-red-500/80 shadow-lg shadow-red-500/20"></div>
                                <div class="w-3 h-3 rounded-full bg-amber-500/80 shadow-lg shadow-amber-500/20"></div>
                            </div>
                            <div class="font-mono text-[10px] text-cyan-400/70 tracking-widest">CYBER_LAB_V9</div>
                        </div>
                        
                        <!-- Content Mockup -->
                        <div class="space-y-4">
                            <div class="h-24 lg:h-32 rounded-xl bg-[#020617]/50 border border-cyan-900/30 relative overflow-hidden">
                                <!-- Grid Lines -->
                                <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle, #0e7490 1px, transparent 1px); background-size: 10px 10px;"></div>
                                <!-- Graph Line -->
                                <svg class="absolute bottom-0 left-0 w-full h-16 text-cyan-500/50" viewBox="0 0 100 20" preserveAspectRatio="none">
                                    <path d="M0,20 Q10,5 20,15 T40,10 T60,18 T80,5 T100,15 L100,20 L0,20 Z" fill="currentColor" />
                                    <path d="M0,20 Q10,5 20,15 T40,10 T60,18 T80,5 T100,15" fill="none" stroke="#22d3ee" stroke-width="0.5" />
                                </svg>
                            </div>
                            <div class="space-y-2">
                                <div class="h-1.5 w-full bg-slate-800 rounded-full overflow-hidden">
                                    <div class="h-full bg-cyan-500 w-[70%] shadow-[0_0_10px_rgba(34,211,238,0.5)] animate-pulse"></div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="h-1.5 w-12 bg-slate-800 rounded-full"></div>
                                    <div class="h-1.5 w-8 bg-slate-800 rounded-full"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="pt-4 border-t border-white/5 flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500">Encryption</span>
                            <span class="text-xs font-bold text-cyan-400">AES-256</span>
                        </div>
                    </div>

                    <!-- Layer 3: Floating Card (Front) -->
                    <div class="absolute -bottom-4 lg:-bottom-8 -left-4 lg:-left-8 w-56 lg:w-64 bg-slate-800/60 backdrop-blur-xl rounded-2xl p-4 lg:p-5 transform translate-z-[40px] animate-float shadow-[0_10px_30px_rgba(0,0,0,0.3)] border border-white/10">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="p-2 bg-cyan-500/20 rounded-lg text-cyan-400 border border-cyan-500/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <div>
                                <div class="text-xs text-slate-400 font-bold uppercase">System Lock</div>
                                <div class="text-xl font-bold text-white">Engaged</div>
                            </div>
                        </div>
                    </div>

                    <!-- Layer 4: Floating Badge (Front Top) -->
                    <div class="absolute top-6 lg:top-10 -right-2 lg:-right-4 bg-cyan-500 text-[#020617] px-3 lg:px-4 py-2 rounded-lg transform translate-z-[60px] shadow-[0_0_20px_rgba(6,182,212,0.4)] flex items-center gap-2 animate-float animation-delay-2000">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                        </span>
                        <span class="text-[10px] lg:text-xs font-bold tracking-widest">MONITORING</span>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Animation Styles -->
</section>

<!-- Point-to-Point Network Script -->
<script>
    (function() {
        const canvas = document.getElementById('cyber-network');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        let particlesArray;

        // Set canvas size
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.directionX = (Math.random() * 0.4) - 0.2; // Slow speed
                this.directionY = (Math.random() * 0.4) - 0.2;
                this.size = (Math.random() * 2) + 0.5;
                this.color = '#06b6d4'; // Cyan-500
            }
            // Draw method
            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2, false);
                ctx.fillStyle = this.color;
                ctx.fill();
            }
            // Update method
            update() {
                // Bounds check
                if (this.x > canvas.width || this.x < 0) this.directionX = -this.directionX;
                if (this.y > canvas.height || this.y < 0) this.directionY = -this.directionY;

                this.x += this.directionX;
                this.y += this.directionY;
                this.draw();
            }
        }

        // Init
        function init() {
            particlesArray = [];
            // Calculate number of particles based on screen size
            let numberOfParticles = (canvas.width * canvas.height) / 12000; 
            for (let i = 0; i < numberOfParticles; i++) {
                particlesArray.push(new Particle());
            }
        }

        // Connect lines
        function connect() {
            let opacityValue = 1;
            for (let a = 0; a < particlesArray.length; a++) {
                for (let b = a; b < particlesArray.length; b++) {
                    let distance = ((particlesArray[a].x - particlesArray[b].x) * (particlesArray[a].x - particlesArray[b].x)) 
                                 + ((particlesArray[a].y - particlesArray[b].y) * (particlesArray[a].y - particlesArray[b].y));
                    
                    if (distance < (canvas.width / 7) * (canvas.height / 7)) { // Dynamic reach
                        opacityValue = 1 - (distance / 20000); // 120*120 approx
                        if(opacityValue < 0) opacityValue = 0;
                        
                        ctx.strokeStyle = 'rgba(6, 182, 212,' + opacityValue * 0.4 + ')'; // Cyan lines
                        ctx.lineWidth = 1;
                        ctx.beginPath();
                        ctx.moveTo(particlesArray[a].x, particlesArray[a].y);
                        ctx.lineTo(particlesArray[b].x, particlesArray[b].y);
                        ctx.stroke();
                    }
                }
            }
        }

        // Animation Loop
        function animate() {
            requestAnimationFrame(animate);
            ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear canvas

            for (let i = 0; i < particlesArray.length; i++) {
                particlesArray[i].update();
            }
            connect();
        }

        // Resize
        window.addEventListener('resize', function() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            init();
        });

        init();
        animate();
    })();
</script>

