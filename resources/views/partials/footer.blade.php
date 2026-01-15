@php
    $fs = $footer_settings ?? null;
@endphp
<footer class="py-20 lg:py-24 bg-[#020617] relative overflow-hidden">
    <!-- Modern Animated Gradient Mesh & Line Background -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <!-- Smooth Fade Transition from previous section -->
        <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-b from-white/5 to-transparent z-10 opacity-10"></div>
        
        <!-- Gradient Blob 1 -->
        <div class="absolute w-[500px] h-[500px] -top-[15%] -left-[10%] bg-gradient-to-br from-sky-500/10 via-indigo-500/5 to-transparent rounded-full blur-[120px] animate-blob"></div>
        
        <!-- Gradient Blob 2 -->
        <div class="absolute w-[550px] h-[550px] top-[30%] -right-[8%] bg-gradient-to-bl from-blue-500/10 via-cyan-500/5 to-transparent rounded-full blur-[130px] animate-blob animation-delay-2000"></div>
        
        <!-- Animated Lines Background -->
        <svg class="absolute inset-0 w-full h-full opacity-20">
            <defs>
                <filter id="footer-glow">
                    <feGaussianBlur stdDeviation="2" result="blur" />
                    <feComposite in="SourceGraphic" in2="blur" operator="over" />
                </filter>
                <linearGradient id="line-grad" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="transparent" />
                    <stop offset="50%" stop-color="#0ea5e9" />
                    <stop offset="100%" stop-color="transparent" />
                </linearGradient>
            </defs>
            <g stroke="#1e293b" stroke-width="0.5" fill="none">
                <path d="M-100,100 L200,100 L300,200 L1200,200" />
                <path d="M1500,50 L1100,150 L1100,400 L800,500" />
                <path d="M200,600 L600,600 L700,500 L1000,500" />
                <path d="M-50,400 L400,400 L500,300 L900,300" />
            </g>
            <g stroke="url(#line-grad)" stroke-width="1" fill="none" class="animate-line-flow" style="filter: url(#footer-glow);">
                <path d="M-100,100 L200,100 L300,200 L1200,200" class="line-path" style="animation-duration: 8s;" />
                <path d="M1500,50 L1100,150 L1100,400 L800,500" class="line-path" style="animation-duration: 10s; animation-delay: 2s;" />
                <path d="M200,600 L600,600 L700,500 L1000,500" class="line-path" style="animation-duration: 12s; animation-delay: 1s;" />
                <path d="M-50,400 L400,400 L500,300 L900,300" class="line-path" style="animation-duration: 9s; animation-delay: 3s;" />
            </g>
        </svg>

        <style>
            .animate-line-flow .line-path {
                stroke-dasharray: 400;
                stroke-dashoffset: 400;
                animation: line-move linear infinite;
            }
            @keyframes line-move {
                0% { stroke-dashoffset: 400; opacity: 0; }
                10% { opacity: 0.8; }
                90% { opacity: 0.8; }
                100% { stroke-dashoffset: -400; opacity: 0; }
            }
        </style>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-8 mb-16">
            <!-- Brand & Info -->
            <div class="col-span-2 lg:col-span-3">
                <a href="/" class="flex items-center mb-6">
                    @if($website_settings?->site_logo_footer)
                    <img class="h-10 w-auto object-contain" src="{{ $website_settings->site_logo_footer }}" alt="{{ $website_settings->site_name }}">
                    @elseif($website_settings?->site_logo)
                    <img class="h-10 w-auto object-contain" src="{{ $website_settings->site_logo }}" alt="{{ $website_settings->site_name }}">
                    @else
                    <span class="text-xl font-black heading-font text-white tracking-widest">{{ $website_settings->site_name ?? 'RD-VIROLOGI' }}</span>
                    @endif
                </a>
                <p class="text-slate-400 leading-relaxed mb-6 text-sm lg:text-base max-w-sm" data-aos="fade-up" data-aos-delay="100">
                    {{ $fs?->description ?? 'Menghadirkan masa depan keamanan siber melalui inovasi AI dan riset teknologi mutakhir.' }}
                </p>

                <!-- Contact Info -->
                <div class="space-y-3 mb-8 text-xs text-slate-500 font-medium" data-aos="fade-up" data-aos-delay="150">
                    @if($fs?->address)
                    <div class="flex items-start space-x-3">
                        <svg class="w-4 h-4 text-sky-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ $fs->address }}</span>
                    </div>
                    @endif
                    @if($fs?->email)
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <a href="mailto:{{ $fs->email }}" class="hover:text-white transition-colors">{{ $fs->email }}</a>
                    </div>
                    @endif
                    @if($fs?->phone)
                    <div class="flex items-center space-x-3">
                        <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>{{ $fs->phone }}</span>
                    </div>
                    @endif
                </div>
                
                @if($fs && $fs->social_links)
                <div class="flex space-x-3" data-aos="fade-up" data-aos-delay="200">
                    @foreach($fs->social_links as $key => $url)
                    @if($url)
                    <a href="{{ $url }}" target="_blank" class="group w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center text-slate-400 hover:text-white hover:bg-sky-500 transition-all duration-300 border border-white/10 hover:border-sky-500" title="{{ ucfirst($key) }}">
                       @if(str_contains(strtolower($key), 'twitter') || str_contains(strtolower($key), 'x'))
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.045 4.126H5.078z"/></svg>
                       @elseif(str_contains(strtolower($key), 'linkedin'))
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452z"/></svg>
                       @elseif(str_contains(strtolower($key), 'github'))
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
                       @elseif(str_contains(strtolower($key), 'facebook'))
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                       @elseif(str_contains(strtolower($key), 'instagram'))
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.981 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                       @else
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"/></svg> 
                       @endif
                    </a>
                    @endif
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Column 1 (Categories - Dynamic) -->
            <div class="col-span-1 lg:col-span-2" data-aos="fade-up" data-aos-delay="100">
                <h4 class="font-bold mb-6 text-white heading-font uppercase tracking-widest text-[10px]">Intelligence Feed</h4>
                <ul class="space-y-3 text-slate-400 text-sm font-medium">
                    @forelse($footer_categories as $category)
                    <li>
                        <a href="/blog?category={{ $category->slug }}" class="hover:text-sky-400 transition-colors inline-flex items-center group">
                            <span class="group-hover:translate-x-1 transition-transform">{{ $category->name }}</span>
                        </a>
                    </li>
                    @empty
                    <li><a href="#" class="hover:text-sky-400">Research</a></li>
                    <li><a href="#" class="hover:text-sky-400">Analysis</a></li>
                    @endforelse
                </ul>
            </div>

            <!-- Column 2 (Dynamic Col 2 from DB) -->
            <div class="col-span-1 lg:col-span-2" data-aos="fade-up" data-aos-delay="200">
                <h4 class="font-bold mb-6 text-white heading-font uppercase tracking-widest text-[10px]">{{ $fs?->column_2_title ?? 'Quick Links' }}</h4>
                <ul class="space-y-3 text-slate-400 text-sm font-medium">
                    @if($fs && $fs->column_2_links)
                        @foreach($fs->column_2_links as $link)
                        <li><a href="{{ $link['url'] }}" class="hover:text-sky-400 transition-colors inline-flex items-center group">
                            <span class="group-hover:translate-x-1 transition-transform">{{ $link['text'] }}</span>
                        </a></li>
                        @endforeach
                    @else
                        <li><a href="/" class="hover:text-sky-400 transition-colors inline-flex items-center group"><span class="group-hover:translate-x-1 transition-transform">Home</span></a></li>
                        <li><a href="/about" class="hover:text-sky-400 transition-colors inline-flex items-center group"><span class="group-hover:translate-x-1 transition-transform">About Us</span></a></li>
                    @endif
                </ul>
            </div>
            
            <!-- Column 3 (Dynamic Col 3 from DB) -->
            <div class="col-span-1 lg:col-span-2" data-aos="fade-up" data-aos-delay="250">
                <h4 class="font-bold mb-6 text-white heading-font uppercase tracking-widest text-[10px]">{{ $fs?->column_3_title ?? 'Legal' }}</h4>
                <ul class="space-y-3 text-slate-400 text-sm font-medium">
                    @if($fs && $fs->column_3_links)
                        @foreach($fs->column_3_links as $link)
                        <li><a href="{{ $link['url'] }}" class="hover:text-sky-400 transition-colors inline-flex items-center group">
                            <span class="group-hover:translate-x-1 transition-transform">{{ $link['text'] }}</span>
                        </a></li>
                        @endforeach
                    @else
                        <li><a href="#" class="hover:text-sky-400 transition-colors inline-flex items-center group"><span class="group-hover:translate-x-1 transition-transform">Privacy Policy</span></a></li>
                        <li><a href="#" class="hover:text-sky-400 transition-colors inline-flex items-center group"><span class="group-hover:translate-x-1 transition-transform">Terms of Service</span></a></li>
                    @endif
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-span-2 lg:col-span-3" data-aos="fade-up" data-aos-delay="300">
                <h4 class="font-bold mb-6 text-white heading-font uppercase tracking-widest text-[10px]">Newsletter</h4>
                <p class="text-slate-400 text-sm mb-6 leading-relaxed">
                    Dapatkan update terbaru tentang keamanan siber.
                </p>
                <form class="flex flex-col sm:flex-row gap-3">
                    <input type="email" placeholder="Email address" class="flex-1 px-4 py-3 rounded-xl border border-white/10 bg-white/5 text-slate-300 text-sm focus:outline-none focus:border-sky-500 transition-all">
                    <button type="submit" class="px-8 py-3 bg-sky-600 text-white font-bold rounded-xl hover:bg-sky-500 transition-all shadow-sm">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-slate-500 text-xs font-medium">
                {{ $fs?->copyright_text ?? '© ' . date('Y') . ' Virologi Inc. Dibuat dengan dedikasi untuk keamanan global.' }}
            </div>
            <div class="flex items-center space-x-6 text-xs font-bold text-slate-500 uppercase tracking-widest">
                <a href="#" class="hover:text-sky-400 transition">Terms</a>
                <span class="text-slate-700">•</span>
                <a href="#" class="text-sky-400 hover:text-sky-500 transition">English / ID</a>
            </div>
        </div>
    </div>
</footer>
