<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $ebook->title }} - Virologi Intelligence</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Outfit', sans-serif; 
            background: #0f172a; 
            color: #fff; 
            overflow: hidden; 
            margin: 0;
            -webkit-tap-highlight-color: transparent;
        }

        /* --- BACKGROUND FX --- */
        .ambient-bg {
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at 50% 30%, #1e3a8a 0%, #0f172a 50%, #020617 100%);
            z-index: -2;
        }
        .ambient-glow {
            position: fixed;
            bottom: -20%; left: 50%;
            width: 100vw; height: 50vh;
            background: radial-gradient(ellipse at center, rgba(56, 189, 248, 0.15), transparent 70%);
            transform: translateX(-50%);
            z-index: -1;
            pointer-events: none;
        }

        /* --- LOADING SCREEN --- */
        #loader {
            position: fixed;
            inset: 0;
            background: #020617;
            z-index: 100;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s ease;
        }
        .loader-icon { animation: bounce-pulse 2s infinite; }
        @keyframes bounce-pulse { 0%, 100% { transform: scale(1); opacity: 1; } 50% { transform: scale(0.9); opacity: 0.7; } }

        /* --- TOAST NOTIFICATION --- */
        #toast-container {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 200;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
            width: 90%;
            max-width: 400px;
        }

        .toast {
            pointer-events: auto;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(239, 68, 68, 0.3); /* Red border for error default */
            border-left: 4px solid #ef4444;
            color: white;
            padding: 16px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: slide-down 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .toast-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .toast-action {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .toast-action:hover { background: rgba(255, 255, 255, 0.2); }

        @keyframes slide-down { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        /* --- GLASS UI --- */
        .glass-panel {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        }

        /* Sidebar */
        .sidebar {
            width: 300px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            position: relative;
            z-index: 50;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(2, 6, 23, 0.85);
        }
        .sidebar.closed { margin-left: -300px; }
        
        @media (max-width: 1024px) {
            .sidebar { position: fixed; inset: 0 auto 0 0; margin-left: -300px; transform: translateX(0); }
            .sidebar.active { transform: translateX(300px); }
        }

        .thumb {
            padding: 12px 16px;
            margin: 4px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            color: #94a3b8;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid transparent;
        }
        .thumb:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .thumb.active {
            background: rgba(14, 165, 233, 0.1);
            border-color: rgba(14, 165, 233, 0.3);
            color: #38bdf8;
        }

        /* Toolbars */
        .toolbar-top-container {
            position: absolute;
            top: 20px; left: 20px; right: 20px;
            display: flex; justify-content: space-between; align-items: flex-start;
            pointer-events: none; z-index: 40;
        }

        .toolbar-bottom-container {
            position: absolute;
            bottom: 30px; left: 0; right: 0;
            display: flex; justify-content: center;
            pointer-events: none; z-index: 40;
        }
        
        .glass-pill {
            pointer-events: auto;
            border-radius: 99px;
            padding: 6px 8px;
            display: flex; align-items: center; gap: 8px;
        }

        .tool-btn {
            width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%;
            color: #cbd5e1;
            transition: all 0.2s;
        }
        .tool-btn:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .tool-btn:active { transform: scale(0.95); }

        .virologi-brand {
            pointer-events: auto;
            display: flex; align-items: center; gap: 10px;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            padding: 8px 16px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        /* Main View */
        .viewport {
            flex: 1;
            overflow-y: scroll;
            padding: 100px 16px 120px 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            scroll-behavior: auto;
        }

        .page-wrapper {
            position: relative;
            margin-bottom: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            background: #1e293b;
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }

    </style>
</head>
<body class="flex">

    <div class="ambient-bg"></div>
    <div class="ambient-glow"></div>
    <div id="toast-container"></div>

    <!-- LOADER -->
    <div id="loader">
        <i data-lucide="shield-check" class="w-16 h-16 text-cyan-500 loader-icon mb-4"></i>
        <div class="text-sm tracking-[0.3em] font-bold text-slate-400">VIROLOGI INTELLIGENCE</div>
        <div class="mt-4 w-48 h-1 bg-slate-800 rounded-full overflow-hidden relative">
             <div id="loader-bar" class="absolute inset-y-0 left-0 bg-cyan-500 w-0 transition-all duration-100"></div>
        </div>
        <div id="loader-percent" class="text-xs font-mono text-cyan-500 mt-2">INITIALIZING...</div>
    </div>

    <!-- SIDEBAR -->
    <aside id="sidebar" class="sidebar flex-shrink-0">
        <div class="h-16 flex items-center justify-between px-5 border-b border-white/5 flex-shrink-0">
            <span class="font-bold tracking-widest text-xs text-slate-400">DOCUMENT MAP</span>
            <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-white"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <div id="thumb-container" class="flex-1 overflow-y-auto py-2"></div>
        <div class="p-5 border-t border-white/5">
            <div class="flex items-center gap-3 opacity-70">
                <img src="{{ $ebook->cover_image }}" class="w-8 h-10 rounded object-cover">
                <div class="text-[10px] text-slate-300 font-mono">{{ $ebook->title }}</div>
            </div>
        </div>
    </aside>

    <!-- MAIN AREA -->
    <main class="flex-1 flex flex-col h-screen relative w-full">
        
        <!-- TOP LAYOUT -->
        <div class="toolbar-top-container">
            <div class="glass-pill glass-panel">
                <button onclick="toggleSidebar()" class="tool-btn" title="Content Menu"><i data-lucide="align-left" class="w-5 h-5"></i></button>
                <div class="w-px h-4 bg-white/10 mx-1"></div>
                <a href="{{ route('ebooks.show', $ebook->slug) }}" class="tool-btn" title="Back"><i data-lucide="arrow-left" class="w-5 h-5"></i></a>
            </div>

            <div class="flex items-center gap-3">
                <div class="virologi-brand hidden md:flex">
                    <i data-lucide="shield" class="w-4 h-4 text-cyan-400"></i>
                    <span class="text-xs font-bold tracking-wider text-slate-200">VIROLOGI <span class="text-cyan-400">SECURE READER</span></span>
                </div>
                <a href="#" id="dl-link" download="{{ $ebook->slug }}.pdf" class="glass-pill glass-panel tool-btn text-cyan-400 hover:text-cyan-200" title="Export PDF">
                    <i data-lucide="download" class="w-5 h-5"></i>
                </a>
            </div>
        </div>

        <!-- BOTTOM CONTROLS (ZOOM & PAGE) -->
        <div class="toolbar-bottom-container">
            <div class="glass-pill glass-panel px-4 gap-4 shadow-lg shadow-cyan-900/20">
                <button onclick="changeZoom(-0.1)" class="tool-btn hover:bg-cyan-500/20 hover:text-cyan-300"><i data-lucide="minus" class="w-5 h-5"></i></button>
                <span id="zoom-val" class="font-mono text-sm font-bold w-12 text-center text-cyan-400">100%</span>
                <button onclick="changeZoom(0.1)" class="tool-btn hover:bg-cyan-500/20 hover:text-cyan-300"><i data-lucide="plus" class="w-5 h-5"></i></button>

                <div class="w-px h-6 bg-white/10 mx-2"></div>

                <div class="flex items-center gap-2 text-sm font-medium text-slate-300">
                    <span class="text-xs text-slate-500">PAGE</span>
                    <span id="curr-page" class="text-white font-bold">1</span>
                    <span class="text-slate-500">/</span>
                    <span id="total-page">--</span>
                </div>
            </div>
        </div>

        <!-- VIEWPORT -->
        <div id="viewport" class="viewport"></div>

    </main>

    <div id="overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-30 hidden"></div>

    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        const config = {
            url: '/pdf-proxy?url=' + encodeURIComponent('{{ $ebook->file_path }}'),
            scale: 1.0, 
        };

        const state = {
            pdf: null,
            rendered: new Set(),
            pageNodes: [],
        };

        const els = {
            view: document.getElementById('viewport'),
            thumbs: document.getElementById('thumb-container'),
            curr: document.getElementById('curr-page'),
            total: document.getElementById('total-page'),
            loader: document.getElementById('loader'),
            zoom: document.getElementById('zoom-val')
        };

        (async () => {
            try {
                if(window.innerWidth < 640) config.scale = 0.6;
                else if (window.innerWidth < 1024) config.scale = 0.8;

                const timeoutPromise = new Promise((_, reject) => 
                    setTimeout(() => reject(new Error("Connection Timeout")), 30000)
                );

                const loadingTask = pdfjsLib.getDocument({
                    url: config.url,
                    disableRange: false, // Enable Range Requests for fast partial loading!
                    disableStream: false,
                    disableAutoFetch: true, // Only fetch what is needed
                    rangeChunkSize: 65536*2 // 128KB chunks
                });

                loadingTask.onProgress = (p) => {
                    const pct = Math.round((p.loaded / p.total) * 100);
                    const elText = document.getElementById('loader-percent');
                    const elBar = document.getElementById('loader-bar');
                    if(elText) elText.innerText = `DECRYPTING DATA: ${pct}%`;
                    if(elBar) elBar.style.width = `${pct}%`;
                };

                state.pdf = await Promise.race([
                    loadingTask.promise,
                    timeoutPromise
                ]);

                els.total.innerText = state.pdf.numPages;
                document.getElementById('dl-link').href = config.url;

                initPages();
                initThumbs();
                updateZoomUI();

                els.loader.style.opacity = '0';
                setTimeout(() => els.loader.remove(), 550);

                els.view.scrollTop = 0;
                observePages();
                updateActivePage(1);

            } catch(e) {
                console.error(e);
                els.loader.style.display = 'none'; // Hide main loader to show toast clearly
                showToast("Failed to establish secure connection.", "RETRY");
            }
        })();

        // --- TOAST SYSTEM ---
        function showToast(message, actionText = null) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.innerHTML = `
                <div class="toast-content">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-500"></i>
                    <span class="text-sm font-medium">${message}</span>
                </div>
            `;
            
            if (actionText) {
                const btn = document.createElement('button');
                btn.className = 'toast-action';
                btn.innerText = actionText;
                btn.onclick = () => window.location.reload();
                toast.appendChild(btn);
            }

            container.appendChild(toast);
            lucide.createIcons();
            
            // Auto dismiss if no action needed
            if (!actionText) {
                setTimeout(() => {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }, 5000);
            }
        }

        // --- PAGE LOGIC ---
        function initPages() {
            els.view.innerHTML = '';
            state.rendered.clear();
            state.pageNodes = [];

            for(let i=1; i <= state.pdf.numPages; i++) {
                const div = document.createElement('div');
                div.className = 'page-wrapper'; 
                div.id = `page-${i}`;
                div.dataset.page = i;
                
                const w = 595 * config.scale; 
                const h = 842 * config.scale;
                
                if(window.innerWidth < 640) {
                     div.style.width = '100%'; 
                     div.style.maxWidth = `${w}px`;
                     div.style.minHeight = `${w * 1.414}px`;
                } else {
                     div.style.width = `${w}px`;
                     div.style.minHeight = `${h}px`;
                }
                
                div.innerHTML = `<div class="absolute inset-0 flex items-center justify-center"><div class="w-8 h-8 rounded-full border-2 border-slate-700 border-t-cyan-500 animate-spin"></div></div>`;
                els.view.appendChild(div);
                state.pageNodes[i] = div;
            }
        }

        function observePages() {
            const obs = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if(entry.isIntersecting) renderPage(parseInt(entry.target.dataset.page));
                });
            }, { root: els.view, rootMargin: '600px' });
            state.pageNodes.forEach(n => { if(n) obs.observe(n); });
            els.view.addEventListener('scroll', onScrollThrottle);
        }

        let scrollTimeout;
        function onScrollThrottle() {
            if(scrollTimeout) return;
            scrollTimeout = setTimeout(() => { detectActivePage(); scrollTimeout = null; }, 150);
        }

        function detectActivePage() {
            const center = els.view.scrollTop + (els.view.clientHeight / 2);
            let best = 1;
            for(let i=1; i<= state.pdf.numPages; i++) {
                const n = state.pageNodes[i];
                if(n && (n.offsetTop + n.offsetHeight) > center) { best = i; break; }
            }
            updateActivePage(best);
        }

        async function renderPage(num) {
            if(state.rendered.has(num)) return;
            state.rendered.add(num);
            const div = state.pageNodes[num];
            
            try {
                const page = await state.pdf.getPage(num);
                const viewport = page.getViewport({ scale: config.scale });
                
                div.style.width = (window.innerWidth < 640) ? '100%' : `${viewport.width}px`;
                div.style.maxWidth = `${viewport.width}px`;
                div.style.height = 'auto'; div.style.minHeight = 'auto';

                const cvs = document.createElement('canvas');
                cvs.width = viewport.width; cvs.height = viewport.height;
                cvs.style.width = '100%'; cvs.style.height = 'auto'; cvs.style.display = 'block';

                div.innerHTML = '';
                div.appendChild(cvs);
                await page.render({ canvasContext: cvs.getContext('2d'), viewport }).promise;
            } catch(e) { 
                console.error(e);
                state.rendered.delete(num); 
                // Silent fail for single page render err is better than annoying toast unless persistent
            }
        }

        function initThumbs() {
            const c = document.getElementById('thumb-container');
            c.innerHTML = '';
            for(let i=1; i<=state.pdf.numPages; i++) {
                const d = document.createElement('div');
                d.className = 'thumb'; d.id = `thumb-${i}`;
                d.innerText = `Page ${i}`;
                d.onclick = () => { scrollToPage(i); if(window.innerWidth<1024) toggleSidebar(); };
                c.appendChild(d);
            }
        }

        function updateActivePage(n) {
            els.curr.innerText = n;
            document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
            const a = document.getElementById(`thumb-${n}`);
            if(a) a.classList.add('active');
        }

        function scrollToPage(num) {
            const n = state.pageNodes[num];
            if(n) els.view.scrollTo({ top: n.offsetTop - 120, behavior: 'smooth' });
        }

        function changeZoom(d) {
            const nx = parseFloat((config.scale+d).toFixed(1));
            if(nx < 0.2 || nx > 2.5) return;
            config.scale = nx;
            initPages(); observePages(); updateZoomUI();
        }

        function updateZoomUI() {
            const z = document.getElementById('zoom-val');
            if(z) z.innerText = Math.round(config.scale * 100) + '%';
        }

        function toggleSidebar() {
            const sb = document.getElementById('sidebar');
            const ov = document.getElementById('overlay');
            if(window.innerWidth < 1024) {
                 if(sb.classList.contains('active')) { sb.classList.remove('active'); ov.style.display='none'; }
                 else { sb.classList.add('active'); ov.style.display='block'; }
            } else sb.classList.toggle('closed');
        }

        lucide.createIcons();
    </script>
</body>
</html>
