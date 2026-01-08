<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta_title', $website_settings->meta_title ?? 'Virologi')</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', $website_settings->meta_description ?? 'Virologi is a leading pathogen research, bioinformatics, and cybersecurity platform.')">
    <meta name="keywords" content="@yield('meta_keywords', $website_settings->meta_keywords ?? 'virology, bioinformatics, cybersecurity, AI, pathogen research, digital defense')">
    <meta name="robots" content="index, follow">
    @if($website_settings?->google_console_verification)
    <meta name="google-site-verification" content="{{ $website_settings->google_console_verification }}" />
    @endif
    <link rel="canonical" href="@yield('canonical_url', url()->current())">
    @if($website_settings?->site_favicon)
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $website_settings->site_favicon) }}">
    @endif

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('meta_title', $website_settings->meta_title ?? 'Virologi')">
    <meta property="og:description" content="@yield('meta_description', $website_settings->meta_description ?? 'Virologi is a leading pathogen research, bioinformatics, and cybersecurity platform.')">
    <meta property="og:image" content="@yield('og_image', $website_settings->og_image ? asset('storage/' . $website_settings->og_image) : asset('images/og-main.jpg'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('meta_title', 'Virologi') | Pathogen Research & Cybersecurity">
    <meta property="twitter:description" content="@yield('meta_description', 'Virologi is a leading pathogen research, bioinformatics, and cybersecurity platform.')">
    <meta property="twitter:image" content="@yield('og_image', asset('images/og-main.jpg'))">

    <!-- JSON-LD Structured Data -->
    @yield('json_ld')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- jsVectorMap CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap/dist/css/jsvectormap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap/dist/maps/world.js"></script>

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    @if($website_settings?->google_analytics_id)
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $website_settings->google_analytics_id }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $website_settings->google_analytics_id }}');
    </script>
    @endif

    @if($website_settings?->custom_head_scripts)
    {!! $website_settings->custom_head_scripts !!}
    @endif

    <style>
        [x-cloak] { display: none !important; }
        
        body {
            font-family: 'JetBrains Mono', monospace;
            background-color: #020617; /* Deep Dark Background */
            color: #e2e8f0; /* Light Text */
            overflow-x: hidden !important;
            -webkit-font-smoothing: antialiased;
        }

        .heading-font {
            font-family: 'Orbitron', sans-serif;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* 1. Ultra-Premium Glass Effect */
        .glass-nav {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
        }

        .glossy-card {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(24px) saturate(120%);
            -webkit-backdrop-filter: blur(24px) saturate(120%);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        }

        .cyber-glow {
            text-shadow: 0 0 20px rgba(14, 165, 233, 0.2);
        }

        /* 2. Animated Flowing Grid Lines */
        .animated-grid {
            mask-image: linear-gradient(to bottom, transparent, black 10%, black 90%, transparent);
            background-size: 60px 60px;
            background-image: 
                linear-gradient(to right, rgba(203, 213, 225, 0.4) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(203, 213, 225, 0.4) 1px, transparent 1px);
            animation: gridFlow 20s linear infinite;
        }

        @keyframes gridFlow {
            0% { transform: translateY(0); }
            100% { transform: translateY(60px); }
        }

        /* 3D Utilities */
        .transform-style-3d { transform-style: preserve-3d; }
        .backface-hidden { backface-visibility: hidden; }
        .perspective-1000 { perspective: 1000px; }
        .perspective-2000 { perspective: 2000px; }
        
        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px) translateZ(40px); }
            50% { transform: translateY(-20px) translateZ(40px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* "Light Point-to-Point" Theme */
        .glass-blob {
            position: absolute;
            border-radius: 50%;
            mix-blend-mode: multiply;
            filter: blur(80px);
            animation: blobFloat 20s infinite alternate cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes blobFloat {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(20px, -20px) scale(1.1); }
        }

        [data-aos] { pointer-events: none; }
        .aos-animate { pointer-events: auto; }
    </style>
</head>
<body class="antialiased selection:bg-sky-200 selection:text-sky-900 overflow-x-hidden min-h-screen flex flex-col bg-slate-50 text-slate-900 relative">
    @if($website_settings?->custom_body_scripts)
    {!! $website_settings->custom_body_scripts !!}
    @endif
    
    <!-- 3. Global Animated Background ("Light Point-to-Point Network") -->
    <div class="fixed inset-0 -z-50 overflow-hidden pointer-events-none">
        
        <!-- Base - Clean Light -->
        <div class="absolute inset-0 bg-slate-50"></div>

        <!-- Glossy Gradients (Atmosphere) -->
        <div class="glass-blob top-[-10%] left-[-10%] w-[800px] h-[800px] bg-sky-300/30"></div>
        <div class="glass-blob bottom-[-10%] right-[-10%] w-[800px] h-[800px] bg-indigo-300/30" style="animation-delay: -5s;"></div>
        <div class="glass-blob top-[40%] left-[30%] w-[600px] h-[600px] bg-violet-300/20" style="animation-delay: -10s;"></div>
        
        <!-- Point-to-Point Canvas -->
        <canvas id="global-network" class="absolute inset-0 w-full h-full opacity-50"></canvas>
    </div>

    <!-- Navbar -->
    @include('partials.navbar')
    
    <div class="relative flex-grow z-10">
        <main>
            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                once: true,
                offset: 50,
                easing: 'ease-out-cubic',
            });
        });

        // Global Light Network (IIFE to avoid scope conflict)
        (function() {
            const canvas = document.getElementById('global-network');
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
                    this.directionX = (Math.random() * 0.4) - 0.2;
                    this.directionY = (Math.random() * 0.4) - 0.2;
                    this.size = (Math.random() * 2) + 0.5;
                    this.color = '#64748b'; // Slate-500 (Visible on light)
                }
                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2, false);
                    ctx.fillStyle = this.color;
                    ctx.fill();
                }
                update() {
                    if (this.x > canvas.width || this.x < 0) this.directionX = -this.directionX;
                    if (this.y > canvas.height || this.y < 0) this.directionY = -this.directionY;
                    this.x += this.directionX;
                    this.y += this.directionY;
                    this.draw();
                }
            }

            function init() {
                particlesArray = [];
                let numberOfParticles = (canvas.width * canvas.height) / 15000; // Slightly fewer particles
                for (let i = 0; i < numberOfParticles; i++) {
                    particlesArray.push(new Particle());
                }
            }

            function connect() {
                let opacityValue = 1;
                for (let a = 0; a < particlesArray.length; a++) {
                    for (let b = a; b < particlesArray.length; b++) {
                        let distance = ((particlesArray[a].x - particlesArray[b].x) * (particlesArray[a].x - particlesArray[b].x)) 
                                     + ((particlesArray[a].y - particlesArray[b].y) * (particlesArray[a].y - particlesArray[b].y));
                        
                        if (distance < (canvas.width / 7) * (canvas.height / 7)) {
                            opacityValue = 1 - (distance / 20000);
                            if(opacityValue < 0) opacityValue = 0;
                            
                            // Slate/Blueish lines
                            ctx.strokeStyle = 'rgba(100, 116, 139,' + opacityValue * 0.2 + ')'; 
                            ctx.lineWidth = 1;
                            ctx.beginPath();
                            ctx.moveTo(particlesArray[a].x, particlesArray[a].y);
                            ctx.lineTo(particlesArray[b].x, particlesArray[b].y);
                            ctx.stroke();
                        }
                    }
                }
            }

            function animate() {
                requestAnimationFrame(animate);
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                for (let i = 0; i < particlesArray.length; i++) {
                    particlesArray[i].update();
                }
                connect();
            }

            window.addEventListener('resize', function() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
                init();
            });

            init();
            animate();
        })();
    </script>
</body>
</html>
