<header class="navbar-container">
    <nav class="navbar-main">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-20">
                
                <a href="/" class="flex items-center z-50">
                    @if($website_settings?->site_logo)
                    <img class="h-10 sm:h-12 w-auto object-contain hover:opacity-90 transition-opacity" src="{{ $website_settings->site_logo }}" alt="{{ $website_settings->site_name }}">
                    @else
                    <span class="text-xl sm:text-2xl font-black heading-font text-white tracking-widest">{{ $website_settings->site_name ?? 'RD-VIROLOGI' }}</span>
                    @endif
                </a>

                <div class="hidden lg:flex items-center space-x-10">
                    <a href="{{ url('/') }}" class="text-sm font-bold text-slate-200 hover:text-cyan-400 transition-colors uppercase tracking-wider">Beranda</a>
                    <a href="{{ route('about') }}" class="text-sm font-bold text-slate-200 hover:text-cyan-400 transition-colors uppercase tracking-wider">Tentang</a>
                    <a href="{{ route('services.index') }}" class="text-sm font-bold text-slate-200 hover:text-cyan-400 transition-colors uppercase tracking-wider">Layanan</a>
                    <a href="{{ route('ebooks.index') }}" class="text-sm font-bold text-slate-200 hover:text-cyan-400 transition-colors uppercase tracking-wider">E-Book</a>
                    <a href="{{ route('products.index') }}" class="text-sm font-bold text-slate-200 hover:text-cyan-400 transition-colors uppercase tracking-wider">Produk</a>
                    <a href="{{ route('blog.index') }}" class="text-sm font-bold text-slate-200 hover:text-cyan-400 transition-colors uppercase tracking-wider">Artikel</a>
                    <a href="{{ route('contact') }}" class="text-sm font-bold text-slate-200 hover:text-cyan-400 transition-colors uppercase tracking-wider">Kontak</a>
                    
                    @auth
                        <a href="{{ route('leak-check.index') }}" class="text-sm font-bold text-red-400 hover:text-red-500 transition-colors uppercase tracking-wider flex items-center">
                            <span class="relative flex h-2 w-2 mr-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                            </span>
                            Leak Check
                        </a>
                        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-slate-200 hover:text-cyan-400 transition-colors uppercase tracking-wider pl-4 ml-4 border-l border-white/10">Dashboard</a>
                        <div class="flex items-center space-x-2 pl-4 border-l border-white/10 group">
                            <a href="{{ route('profile.index') }}" class="flex items-center space-x-3 group">
                                <img src="{{ auth()->user()->detail->avatar_url }}" class="w-8 h-8 rounded-lg border border-white/20 group-hover:border-cyan-400 transition-colors">
                                <span class="text-sm font-bold text-white group-hover:text-cyan-400 transition-colors uppercase tracking-wider">{{ auth()->user()->username }}</span>
                            </a>
                            <a href="{{ route('logout') }}" class="p-2 text-slate-400 hover:text-red-400 transition-colors" title="Logout">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4-4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </a>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2.5 bg-cyan-500 text-slate-900 text-sm font-bold rounded-xl hover:bg-white hover:shadow-[0_0_20px_rgba(6,182,212,0.4)] transition-all transform hover:-translate-y-0.5 uppercase tracking-widest shadow-lg shadow-cyan-500/20">Login Portal</a>
                    @endauth
                </div>

                <button onclick="toggleMobileMenu()" class="lg:hidden group relative w-10 h-10 flex flex-col items-center justify-center space-y-1.5 transition-all outline-none">
                    <span class="w-6 h-0.5 bg-slate-200 rounded-full transition-all duration-300 group-hover:bg-cyan-400 group-hover:translate-x-1 origin-right"></span>
                    <span class="w-6 h-0.5 bg-slate-200 rounded-full transition-all duration-300 group-hover:bg-cyan-400 origin-right flex items-center justify-end">
                        <span class="absolute p-0.5 rounded-full bg-cyan-400 opacity-0 group-hover:opacity-100 transition-opacity animate-pulse"></span>
                    </span>
                    <span class="w-4 h-0.5 bg-slate-200 rounded-full transition-all duration-300 group-hover:bg-cyan-400 group-hover:w-6 origin-right self-end"></span>
                </button>
            </div>
        </div>
    </nav>

    <div id="mobileMenu" class="mobile-menu">
        <div class="mobile-menu-content flex flex-col bg-[#020617]/95 backdrop-blur-3xl shadow-[-10px_0_30px_rgba(0,0,0,0.5)]">
            <!-- Mobile Menu Header -->
            <div class="p-8 pb-4 flex justify-between items-center relative">
                <span class="text-[10px] font-black text-slate-200 uppercase tracking-[0.4em]">Index</span>
                <button onclick="toggleMobileMenu()" class="group relative w-12 h-12 flex items-center justify-center rounded-full bg-white/5 hover:bg-white/10 transition-all border border-white/10">
                    <svg class="w-6 h-6 text-white group-hover:scale-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Scrollable Content: Editorial Minimalist List -->
            <div class="flex-1 overflow-y-auto px-10 pt-10 pb-20 space-y-6">
                @php
                    $menuItems = [
                        ['label' => 'Beranda', 'url' => url('/')],
                        ['label' => 'Tentang Kami', 'url' => route('about')],
                        ['label' => 'Layanan', 'url' => route('services.index')],
                        ['label' => 'E-Book', 'url' => route('ebooks.index')],
                        ['label' => 'Produk', 'url' => route('products.index')],
                        ['label' => 'Artikel', 'url' => route('blog.index')],
                        ['label' => 'Kontak', 'url' => route('contact')],
                    ];

                    if (auth()->check()) {
                        $menuItems[] = ['label' => 'Data Leak Check', 'url' => route('leak-check.index')];
                        $menuItems[] = ['label' => 'My Profile', 'url' => route('profile.index')];
                        $menuItems[] = ['label' => 'Logout', 'url' => route('logout')];
                    } else {
                        $menuItems[] = ['label' => 'Login', 'url' => route('login')];
                    }
                @endphp

                <nav class="flex flex-col space-y-8">
                    @foreach($menuItems as $index => $item)
                    <a href="{{ $item['url'] }}" 
                       class="mobile-nav-item block group opacity-0 translate-y-6"
                       style="transition-delay: {{ 0.1 + ($index * 0.05) }}s">
                        <span class="text-3xl font-bold text-white group-hover:text-sky-400 transition-all duration-500 inline-block tracking-tighter heading-font uppercase">
                            {{ $item['label'] }}
                        </span>
                        <div class="w-0 h-[2px] bg-sky-500 group-hover:w-full transition-all duration-500 mt-1"></div>
                    </a>
                    @endforeach
                </nav>

                <!-- Action Section: Minimalist CTA -->
                <div class="pt-12 mt-12 border-t border-white/10 opacity-0 translate-y-6 mobile-nav-footer" style="transition-delay: 0.5s">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-slate-300 mb-6 font-black">Strategic Defense</p>
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-4 text-white font-bold tracking-tight hover:gap-6 transition-all group">
                        <span class="text-lg heading-font uppercase">Contact Our Experts</span>
                        <svg class="w-5 h-5 group-hover:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>

            <!-- Footer: Ultra-Minimalist -->
            <div class="p-10 bg-white/5 backdrop-blur-md border-t border-white/10">
                <div class="flex items-center justify-between text-[9px] font-black text-slate-200 uppercase tracking-[0.2em]">
                    <span>Secure Connect</span>
                    <span class="opacity-70">© {{ date('Y') }} {{ $website_settings->site_name ?? 'RD-VIROLOGI' }}</span>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
.navbar-container {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    width: 100% !important;
    z-index: 999999 !important;
    pointer-events: auto !important;
}

.navbar-main {
    background: rgba(2, 6, 23, 0.8);
    backdrop-filter: blur(16px) saturate(180%);
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-bottom: 1px solid rgba(56, 189, 248, 0.1);
}

.navbar-main.scrolled {
    background: rgba(2, 6, 23, 0.95);
    border-bottom: 1px solid rgba(56, 189, 248, 0.3);
    box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
}

/* Cyber-Minimalist Burger Toggle */
button[onclick="toggleMobileMenu()"] span {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.hamburger-active span:nth-child(1) {
    transform: translateY(8px) rotate(45deg) !important;
    width: 24px !important;
}

.hamburger-active span:nth-child(2) {
    opacity: 0 !important;
    transform: translateX(10px) !important;
}

.hamburger-active span:nth-child(3) {
    transform: translateY(-8px) rotate(-45deg) !important;
    width: 24px !important;
}

.hamburger-icon.active .hamburger-line:nth-child(2) {
    opacity: 0;
    transform: scaleX(0);
}

.hamburger-icon.active .hamburger-line:nth-child(3) {
    transform: translateY(-8px) rotate(-45deg);
}

/* Editorial Minimalist Mobile Menu */
.mobile-menu {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    z-index: 999998 !important;
    background: rgba(2, 6, 23, 0.6) !important;
    backdrop-filter: blur(30px) !important;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

.mobile-menu.show {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
}

.mobile-menu-content {
    position: absolute !important;
    top: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    width: 100% !important;
    max-width: 26rem !important;
    height: 100dvh !important;
    transform: translateX(100%);
    transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1) !important;
}

.mobile-menu.show .mobile-menu-content {
    transform: translateX(0);
}

/* Editorial Reveal Animations */
.mobile-nav-item, .mobile-nav-footer {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1);
}

.mobile-menu.show .mobile-nav-item,
.mobile-menu.show .mobile-nav-footer {
    opacity: 1;
    transform: translateY(0);
}

.mobile-nav-item:hover span {
    letter-spacing: -0.02em;
}

.navbar-main a {
    position: relative;
}

.navbar-main a:not(.px-6)::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 50%;
    transform: translateX(-50%) scaleX(0);
    width: 60%;
    height: 2px;
    background: #0ea5e9;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    transform-origin: center;
}

.navbar-main a:not(.px-6):hover::after {
    transform: translateX(-50%) scaleX(1);
}

@media (min-width: 1024px) {
    .mobile-menu {
        display: none !important;
    }
}

html {
    scroll-padding-top: 5rem;
}
</style>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const button = document.querySelector('button[onclick="toggleMobileMenu()"]');
    
    if (menu.classList.contains('show')) {
        menu.classList.remove('show');
        button.classList.remove('hamburger-active');
        document.body.style.overflow = '';
    } else {
        menu.classList.add('show');
        button.classList.add('hamburger-active');
        document.body.style.overflow = 'hidden';
    }
}

document.addEventListener('click', function(event) {
    const menu = document.getElementById('mobileMenu');
    const button = document.querySelector('button[onclick="toggleMobileMenu()"]');
    
    if (event.target.closest('.mobile-menu') && !event.target.closest('.mobile-menu-content') && menu.classList.contains('show')) {
        menu.classList.remove('show');
        button.classList.remove('hamburger-active');
        document.body.style.overflow = '';
    }
});

document.querySelectorAll('.mobile-menu-content a').forEach(link => {
    link.addEventListener('click', function() {
        const menu = document.getElementById('mobileMenu');
        const button = document.querySelector('button[onclick="toggleMobileMenu()"]');
        menu.classList.remove('show');
        button.classList.remove('hamburger-active');
        document.body.style.overflow = '';
    });
});

let lastScroll = 0;
let ticking = false;

window.addEventListener('scroll', function() {
    if (!ticking) {
        window.requestAnimationFrame(function() {
            const nav = document.querySelector('.navbar-main');
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 10) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
            
            lastScroll = currentScroll;
            ticking = false;
        });
        ticking = true;
    }
});

window.addEventListener('resize', function() {
    const menu = document.getElementById('mobileMenu');
    const button = document.querySelector('button[onclick="toggleMobileMenu()"]');
    
    if (window.innerWidth >= 1024 && menu && menu.classList.contains('show')) {
        menu.classList.remove('show');
        if (button) {
            button.classList.remove('hamburger-active');
        }
        document.body.style.overflow = '';
    }
});
</script>
