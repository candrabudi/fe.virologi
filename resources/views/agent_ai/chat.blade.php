<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virologi | Intelligent Interface</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter+Tight:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

        :root {
            --bg-color: #050505;
            --card-bg: rgba(20, 20, 20, 0.6);
            --accent-primary: #ffffff;
            --border-glow: rgba(255, 255, 255, 0.08);
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
        }

        body {
            font-family: 'Inter Tight', sans-serif;
            background-color: var(--bg-color);
            color: #fafafa;
            margin: 0;
            height: 100vh;
            overflow: hidden;
            display: flex;
        }

        .ambient-light {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 50% -20%, rgba(59, 130, 246, 0.1), transparent 60%),
                radial-gradient(circle at 0% 100%, rgba(139, 92, 246, 0.05), transparent 40%);
            z-index: -1;
            pointer-events: none;
        }

        /* Sidebar State */
        #sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            background: var(--card-bg);
            backdrop-filter: blur(40px);
            border-right: 1px solid var(--border-glow);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            z-index: 100;
        }

        #sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
            min-width: var(--sidebar-collapsed-width);
        }

        #sidebar.collapsed .sidebar-content-full {
            opacity: 0;
            display: none;
        }

        #sidebar.collapsed .sidebar-content-mini {
            display: flex;
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            #sidebar {
                position: fixed;
                height: 100%;
                left: -100%;
                width: 85% !important;
                min-width: 85% !important;
            }

            #sidebar.mobile-open {
                left: 0;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(4px);
                z-index: 90;
            }

            .sidebar-overlay.active {
                display: block;
            }
        }

        /* Bento Grid */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1rem;
        }

        .bento-item {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-glow);
            border-radius: 20px;
            padding: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .bento-item:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        /* Chat Messages */
        .user-message {
            background: #2f2f2f;
            color: #ececec;
            padding: 12px 20px;
            border-radius: 24px;
            margin-left: auto;
            max-width: 80%;
            font-size: 15px;
            line-height: 1.6;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .ai-message {
            margin-bottom: 2rem;
            animation: messageAppear 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .ai-message-bubble {
            background: transparent;
            padding: 8px 0;
            max-width: 100%;
        }

        .typing-cursor {
            display: inline-block;
            width: 8px;
            height: 18px;
            background: #fff;
            margin-left: 4px;
            vertical-align: middle;
            animation: cursorBlink 0.8s infinite;
        }

        @keyframes cursorBlink {
            0%, 100% { opacity: 0; }
            50% { opacity: 1; }
        }

        /* Dynamic Input Styling - Fixed Alignment */
        .input-container {
            padding: 1.5rem;
            background: linear-gradient(to top, var(--bg-color) 80%, transparent);
        }

        .input-wrapper {
            background: rgba(18, 18, 18, 0.8);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 22px;
            max-width: 52rem;
            margin: 0 auto;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            align-items: center;
            /* Menjaga semua item tetap sejajar di tengah secara vertikal */
            padding: 0.5rem 0.75rem;
        }

        .input-wrapper:focus-within {
            border-color: rgba(255, 255, 255, 0.25);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.05);
        }

        #chat-input {
            max-height: 200px;
            background: transparent;
            border: none;
            outline: none;
            resize: none;
            width: 100%;
            font-size: 15px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            line-height: 1.5;
            color: #fafafa;
        }

        @keyframes messageAppear {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .custom-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .ai-text {
            color: #e5e7eb;
            line-height: 1.75;
            font-size: 15px;
            margin: 6px 0;
        }

        .ai-code-canvas {
            background: #0b0f14;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 14px;
            overflow: hidden;
            margin: 14px 0;
        }

        .ai-code-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 14px;
            font-size: 11px;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #9ca3af;
            background: rgba(0, 0, 0, .45);
        }

        .ai-code-header button {
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
        }

        .ai-code-header button:hover {
            color: white;
        }

        .ai-code-canvas pre {
            margin: 0;
            padding: 16px;
            overflow-x: auto;
            font-size: 13px;
            line-height: 1.65;
            color: #e5e7eb;
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
        }

        .ai-roadmap-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 20px;
            margin: 1.5rem 0;
            transition: all 0.3s ease;
        }

        .ai-roadmap-card:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.15);
        }

        .ai-roadmap-header {
            font-weight: 700;
            font-size: 16px;
            color: #fff;
            margin-bottom: 14px;
        }

        .ai-roadmap-section-title {
            margin-top: 14px;
            font-size: 13px;
            font-weight: 600;
            color: #34d399;
        }

        .ai-roadmap-item {
            font-size: 14px;
            color: #e5e7eb;
            margin-left: 8px;
            line-height: 1.6;
        }

        .ai-roadmap-text {
            font-size: 14px;
            color: #d1d5db;
            line-height: 1.7;
            margin-top: 6px;
        }

        .ai-heading {
            font-weight: 700;
            margin: 24px 0 12px;
            color: #fff;
        }
        .ai-heading.h1 { font-size: 24px; }
        .ai-heading.h2 { font-size: 20px; }
        .ai-heading.h3 { font-size: 17px; }

        .ai-list-item {
            margin: 8px 0 8px 1.5rem;
            color: #e5e7eb;
            line-height: 1.6;
            list-style-type: disc;
        }

        .ai-text {
            font-size: 15px;
            line-height: 1.75;
            color: #e5e7eb;
        }

        .ai-list {
            margin-left: 18px;
            margin-bottom: 12px;
        }

        .ai-list li {
            margin-bottom: 6px;
        }

        .ai-inline-code {
            background: rgba(255, 255, 255, 0.08);
            padding: 2px 6px;
            border-radius: 6px;
            font-size: 13px;
        }

        .ai-divider {
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin: 16px 0;
        }

        .ai-tree {
            background: rgba(255, 255, 255, 0.05);
            padding: 10px;
            border-radius: 10px;
            overflow-x: auto;
        }
    </style>
    <style>
        .thinking-dots span {
            animation: blink 1.4s infinite both;
        }

        .thinking-dots span:nth-child(2) {
            animation-delay: .2s;
        }

        .thinking-dots span:nth-child(3) {
            animation-delay: .4s;
        }

        @keyframes blink {
            0% {
                opacity: .2;
            }

            20% {
                opacity: 1;
            }

            100% {
                opacity: .2;
            }
        }
    </style>

</head>

<body>

    <div class="ambient-light"></div>
    <div id="overlay" class="sidebar-overlay" onclick="toggleMobileSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="flex flex-col h-full overflow-hidden">
        <div class="p-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3 sidebar-content-full">
                <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
                    <i class="fas fa-bolt text-[10px] text-black"></i>
                </div>
                <span class="font-bold text-lg tracking-tight">Virologi</span>
            </div>

            <div class="hidden sidebar-content-mini w-full flex-col items-center">
                <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-white/10 transition-colors cursor-pointer"
                    onclick="toggleSidebar()">
                    <i class="fas fa-bolt text-xs"></i>
                </div>
            </div>

            <button onclick="toggleSidebar()"
                class="hidden md:flex sidebar-content-full text-gray-500 hover:text-white transition-colors">
                <i class="fas fa-bars-staggered"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto px-4 sidebar-content-full custom-scroll space-y-6 pt-4">
            <button onclick="createNewChat()"
                class="w-full py-3 px-4 rounded-xl bg-white text-black font-semibold text-sm hover:opacity-90 transition-all flex items-center justify-center gap-2 mb-6">
                <i class="fas fa-plus text-[10px]"></i> Chat Baru
            </button>

            <div id="session-list" class="space-y-1"></div>
        </div>

        <div class="hidden sidebar-content-mini flex-col items-center gap-6 pb-8 pt-4">
            <button onclick="createNewChat()"
                class="w-10 h-10 rounded-full bg-white text-black flex items-center justify-center hover:scale-110 transition-transform">
                <i class="fas fa-plus text-xs"></i>
            </button>

            <button class="text-gray-500 hover:text-white">
                <i class="fas fa-clock-rotate-left"></i>
            </button>

            <button class="text-gray-500 hover:text-white" onclick="toggleLogoutMini()">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </div>


        <div class="p-4 border-t border-white/5 sidebar-content-full">
            <div class="group relative bg-white/5 p-3 rounded-2xl transition-all hover:bg-white/[0.08]">
                <div class="flex items-center gap-3">
                    <div
                        class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex-shrink-0 flex items-center justify-center font-bold text-xs">
                        AD</div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-xs font-bold truncate">{{ Auth::user()->detail->full_name }}</p>
                        <p class="text-[10px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <button onclick="handleLogout()"
                        class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-red-500/20 text-gray-500 hover:text-red-400 transition-all"
                        title="Logout">
                        <i class="fas fa-power-off text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main -->
    <main class="flex-1 flex flex-col h-full relative overflow-hidden">
        <header class="h-20 flex items-center justify-between px-4 md:px-10 bg-black border-b border-white/10">

            <!-- LEFT -->
            <div class="flex items-center gap-3">
                <!-- Mobile sidebar toggle -->
                <button onclick="toggleMobileSidebar()"
                    class="md:hidden w-10 h-10 rounded-full flex items-center justify-center text-white hover:bg-white/10 transition">
                    <i class="fas fa-bars-staggered"></i>
                </button>

                <!-- Back to home -->
                <a href="/"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-semibold text-gray-200 hover:text-white hover:bg-white/10 transition whitespace-nowrap">
                    <i class="fas fa-arrow-left text-xs"></i>
                    <span>Beranda</span>
                </a>

                <!-- Model info (desktop only) -->
                <div class="hidden md:flex items-center gap-2 ml-2">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-widest">
                        Model:
                    </span>
                    <span class="text-xs font-bold text-white px-2 py-1 rounded bg-white/10 tracking-tight">
                        Virologi-o1_Preview
                    </span>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="flex items-center gap-3">
                <div
                    class="flex items-center gap-2 bg-emerald-500/10 text-emerald-400 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider border border-emerald-500/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Sistem Optimal
                </div>
            </div>

        </header>


        <div id="chat-viewport" class="flex-1 overflow-y-auto px-4 md:px-10 py-10 custom-scroll">
            <div class="max-w-4xl mx-auto w-full">
                <div id="welcome-view" class="mt-10 mb-20">
                    <h1 class="text-4xl md:text-6xl font-bold tracking-tighter mb-6 leading-[1.1]">
                        Apa yang ingin kamu pelajari<br>
                        <span class="text-gray-500">tentang Cyber Security & Coding hari ini?</span>
                    </h1>

                    <div class="bento-grid">
                        <div onclick="triggerPrompt('Jelaskan konsep dasar cyber security untuk pemula')"
                            class="bento-item">
                            <i class="fas fa-shield-halved text-indigo-400 mb-4 text-lg"></i>
                            <h3 class="font-bold text-sm mb-1">Dasar Cyber Security</h3>
                            <p class="text-xs text-gray-500 leading-relaxed">
                                Pelajari fundamental keamanan: threat, vulnerability, dan attack vector.
                            </p>
                        </div>

                        <div onclick="triggerPrompt('Analisis keamanan kode ini dan jelaskan potensi celahnya')"
                            class="bento-item">
                            <i class="fas fa-code text-emerald-400 mb-4 text-lg"></i>
                            <h3 class="font-bold text-sm mb-1">Analisis Kode Aman</h3>
                            <p class="text-xs text-gray-500 leading-relaxed">
                                Deteksi bug, SQL injection, XSS, dan praktik coding yang aman.
                            </p>
                        </div>

                        <div onclick="triggerPrompt('Bagaimana cara mencegah DDoS dan brute force attack di server?')"
                            class="bento-item">
                            <i class="fas fa-server text-rose-400 mb-4 text-lg"></i>
                            <h3 class="font-bold text-sm mb-1">Proteksi Server</h3>
                            <p class="text-xs text-gray-500 leading-relaxed">
                                Strategi firewall, rate limiting, dan hardening server.
                            </p>
                        </div>

                        <div onclick="triggerPrompt('Buatkan roadmap belajar programming untuk cyber security')"
                            class="bento-item">
                            <i class="fas fa-road text-amber-400 mb-4 text-lg"></i>
                            <h3 class="font-bold text-sm mb-1">Roadmap Belajar</h3>
                            <p class="text-xs text-gray-500 leading-relaxed">
                                Panduan step-by-step coding: backend, security, hingga pentest.
                            </p>
                        </div>
                    </div>
                </div>

                <div id="message-container" class="space-y-12"></div>
            </div>
        </div>

        <div class="input-container">
            <div class="input-wrapper">
                <button type="button"
                    class="w-10 h-10 rounded-xl hover:bg-white/5 text-gray-500 transition-colors flex items-center justify-center flex-shrink-0"
                    title="Lampirkan file">
                    <i class="fas fa-paperclip text-sm"></i>
                </button>

                <form id="chat-form" class="flex-1 flex items-center">
                    <textarea id="chat-input" rows="1" placeholder="Kirim pesan ke Cyber Security Assistant..."
                        class="custom-scroll" oninput="adjustInputHeight(this)"></textarea>

                    <button type="submit" id="send-btn"
                        class="w-10 h-10 rounded-xl bg-white text-black flex items-center justify-center hover:bg-gray-200 active:scale-90 transition-all disabled:opacity-30 disabled:pointer-events-none flex-shrink-0 ml-2">
                        <i class="fas fa-arrow-up text-xs"></i>
                    </button>
                </form>
            </div>

            <p class="text-[9px] text-center text-gray-600 mt-4 uppercase tracking-[0.4em] font-medium opacity-60">
                Virologi v2.5 • AI Assistant 2025</p>
        </div>
    </main>

    <div id="logout-modal"
        class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[200] hidden items-center justify-center p-6">
        <div class="bg-[#111] border border-white/10 p-8 rounded-3xl max-w-sm w-full text-center">
            <div
                class="w-16 h-16 bg-red-500/10 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 text-xl">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <h2 class="text-xl font-bold mb-2">Konfirmasi Logout</h2>
            <p class="text-gray-500 text-sm mb-8">Apakah Anda yakin ingin mengakhiri sesi ini? Semua progres yang belum
                disimpan mungkin hilang.</p>
            <div class="flex gap-3">
                <button onclick="closeLogoutModal()"
                    class="flex-1 py-3 rounded-xl bg-white/5 text-sm font-bold hover:bg-white/10 transition-colors">Batal</button>
                <button onclick="executeLogout()"
                    class="flex-1 py-3 rounded-xl bg-red-600 text-white text-sm font-bold hover:bg-red-700 transition-colors">Logout
                    Sekarang</button>
            </div>
        </div>
    </div>
    <div id="delete-chat-modal"
        class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[300] hidden items-center justify-center p-6">
        <div class="bg-[#111] border border-white/10 p-8 rounded-3xl max-w-sm w-full text-center">
            <div
                class="w-16 h-16 bg-red-500/10 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-trash"></i>
            </div>
            <h2 class="text-xl font-bold mb-2">Hapus Chat</h2>
            <p class="text-gray-500 text-sm mb-8">
                Chat ini akan dihapus permanen dan tidak dapat dikembalikan.
            </p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()"
                    class="flex-1 py-3 rounded-xl bg-white/5 hover:bg-white/10 text-sm font-bold">
                    Batal
                </button>
                <button onclick="confirmDeleteChat()"
                    class="flex-1 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-sm font-bold text-white">
                    Hapus
                </button>
            </div>
        </div>
    </div>

    <div id="correction-modal"
        class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[400] hidden items-center justify-center p-6">
        <div class="bg-[#111] border border-white/10 p-8 rounded-3xl max-w-2xl w-full">
            <div class="flex items-center gap-4 mb-6 text-emerald-500">
                <div class="w-12 h-12 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Koreksi Jawaban AI</h2>
                    <p class="text-xs text-gray-500">Ajarkan AI jawaban yang benar untuk topik ini.</p>
                </div>
            </div>
            
            <textarea id="correction-input" rows="6" 
                class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-sm text-white focus:border-emerald-500/50 focus:outline-none transition-all placeholder:text-gray-600"
                placeholder="Tuliskan jawaban yang lebih akurat di sini..."></textarea>
            
            <div class="flex gap-3 mt-8">
                <button onclick="closeCorrectionModal()"
                    class="flex-1 py-3 rounded-xl bg-white/5 hover:bg-white/10 text-sm font-bold transition-all">
                    Batal
                </button>
                <button onclick="submitCorrection()"
                    class="flex-1 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-sm font-bold text-white shadow-lg shadow-emerald-500/10 transition-all">
                    Simpan Koreksi
                </button>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        let activeSession = null
        let isCreatingSession = false
        let thinkingEl = null
        let deleteTargetToken = null
        let openMenuToken = null

        const sessionList = document.getElementById('session-list')
        const chatForm = document.getElementById('chat-form')
        const chatInput = document.getElementById('chat-input')
        const messageContainer = document.getElementById('message-container')
        const welcomeView = document.getElementById('welcome-view')
        const viewport = document.getElementById('chat-viewport')
        const sendBtn = document.getElementById('send-btn')
        const sidebar = document.getElementById('sidebar')
        const overlay = document.getElementById('overlay')
        const logoutModal = document.getElementById('logout-modal')
        const deleteModal = document.getElementById('delete-chat-modal')

        const csrfMeta = document.querySelector('meta[name="csrf-token"]')
        if (csrfMeta && window.axios) {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfMeta.getAttribute('content')
        }

        // Add response interceptor for Unauthenticated detection
        axios.interceptors.response.use(
            response => response,
            error => {
                if (error.response && (error.response.status === 401 || (error.response.data && error.response.data.message === 'Unauthenticated.'))) {
                    location.href = '/login'
                }
                return Promise.reject(error)
            }
        )

        function getTokenFromUrl() {
            const p = location.pathname.split('/')
            return p.length > 3 ? p[3] : null
        }

        function setUrl(token) {
            history.pushState({
                token
            }, '', `/ai-agent/chat/${token}`)
        }

        function escapeHtml(s) {
            return String(s).replace(/[&<>"']/g, m => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            } [m]))
        }

        function linkify(s) {
            return s.replace(/(https?:\/\/[^\s<]+)/g, u =>
                `<a href="${u}" target="_blank" class="text-sky-300 underline underline-offset-4">${u}</a>`
            )
        }

        function normalizeAiResponse(raw) {
            if (typeof raw !== 'string') return raw
            return raw
                .replace(/\r/g, '')
                .replace(/\\n/g, '\n')
                .replace(/\\t/g, '\t')
                .replace(/\\\\/g, '\\')
        }

        function stripLeakedCode(raw) {
            if (typeof raw !== 'string') return raw

            const fenceIndex = raw.indexOf('```')
        if (fenceIndex === -1) return raw

        const before = raw.slice(0, fenceIndex)
        const looksLikeCode =
                before.includes('<' + '?php') ||
                before.includes('namespace ') ||
                before.includes('class ') ||
                before.includes('function ') ||
                (before.includes('{') && before.includes('}'));

            return looksLikeCode ? raw.slice(fenceIndex) : raw;
 }

 function copyCode(btn) {
     const code = btn.closest('.ai-code-canvas')
         ?.querySelector('pre code')
         ?.innerText

     if (!code) return

     navigator.clipboard.writeText(code).then(() => {
         btn.innerText = 'Copied'
         setTimeout(() => btn.innerText = 'Copy', 1500)
     })
 }

 function renderInline(text) {
    return linkify(
        escapeHtml(text)
            .replace(/`([^`]+)`/g, '<code class="ai-inline-code">$1</code>')
                    .replace(/\*\*(.+?)\*\*/g, '<b>$1</b>')
            )
        }

         function renderAssistant(raw) {
            if (!raw) return ''

            raw = stripLeakedCode(normalizeAiResponse(raw))

            const parts = raw.split(/```/g)
    let html = ''
    let currentCard = null

    function flushCard() {
        if (!currentCard) return
        html += `
        <div class="ai-roadmap-card">
            <div class="ai-roadmap-header">
                ${currentCard.title}
            </div>
            <div class="ai-roadmap-body">
                ${currentCard.body.join('')}
            </div>
        </div>`
        currentCard = null
    }

    function renderInline(text) {
        return linkify(
            escapeHtml(text)
                .replace(/`([^`]+)`/g, '<code class="ai-inline-code">$1</code>')
                        .replace(/\*\*(.+?)\*\*/g, '<b>$1</b>')
                )
            }

            parts.forEach((block, index) => {
                // ================= CODE BLOCK =================
                if (index % 2 === 1) {
                    flushCard()

                    const lines = block.split('\n')
                    const lang = (lines.shift() || 'code').trim()
                    const code = lines.join('\n')

                    html += `
<div class="ai-code-canvas">
    <div class="ai-code-header">
        <span>${escapeHtml(lang.toUpperCase())}</span>
        <button onclick="copyCode(this)">Copy</button>
    </div>
    <pre><code>${escapeHtml(code)}</code></pre>
</div>`
                    return
                }

                // ================= TEXT BLOCK =================
                block.split('\n').forEach(line => {
                    const t = line.trim()
                    if (!t) return

                    // ---------- Roadmap Step: ### 1. Title
                    const stepMatch = t.match(/^(#+)\s*\d+\.\s*(.+)/)
                    if (stepMatch) {
                        flushCard()
                        currentCard = {
                            title: `🧭 ${escapeHtml(stepMatch[2])}`,
                            body: []
                        }
                        return
                    }

                    // ---------- Normal Heading: # Title, ## Title, or ### Title
                    const headingMatch = t.match(/^(#{1,4})\s+(.+)/)
                    if (headingMatch && !stepMatch) {
                        flushCard()
                        const level = headingMatch[1].length
                        const tag = level === 1 ? 'h1' : (level === 2 ? 'h2' : 'h3')
                        html += `
<${tag} class="ai-heading ${tag}">
    ${escapeHtml(headingMatch[2])}
</${tag}>`
                        return
                    }

                    // ---------- Section title inside card: - **Title**
                    const sectionMatch = t.match(/^-\s*\*\*(.+?)\*\*/)
                    if (sectionMatch && currentCard) {
                        currentCard.body.push(`
<div class="ai-roadmap-section-title">
    ${escapeHtml(sectionMatch[1])}
</div>`)
                        return
                    }

                    // ---------- Bullet item inside card
                    if (t.startsWith('- ') && currentCard) {
                        currentCard.body.push(`
<div class="ai-roadmap-item">
    • ${renderInline(t.slice(2))}
</div>`)
                        return
                    }

                    // ---------- Text inside card
                    if (currentCard) {
                        currentCard.body.push(`
<p class="ai-roadmap-text">
    ${renderInline(t)}
</p>`)
                        return
                    }

                    // ---------- Normal Bullet Point (outside card)
                    if (t.startsWith('- ') || t.startsWith('* ')) {
                        flushCard()
                        html += `
<li class="ai-list-item">
    ${renderInline(t.slice(2))}
</li>`
                        return
                    }

                    // ---------- Normal paragraph (outside card)
                    html += `
<p class="ai-text">
    ${renderInline(t)}
</p>`
                })
            })

            flushCard()
            return html
        }


             function scrollBottom() {
                 viewport.scrollTo({
                     top: viewport.scrollHeight,
                     behavior: 'smooth'
                 })
             }

             function appendUser(content) {
                 welcomeView.style.display = 'none'
                 const el = document.createElement('div')
                 el.className = 'flex justify-end'
                 el.innerHTML = `<div class="user-message">${escapeHtml(content)}</div>`
                 messageContainer.appendChild(el)
                 scrollBottom()
             }

             function appendAssistant(content, isStreaming = false) {
                 const el = document.createElement('div')
                 el.className = 'ai-message flex gap-5 group'
                 
                 const htmlContent = renderAssistant(content)
                 
                 el.innerHTML = `
<div class="w-9 h-9 rounded-full bg-white flex items-center justify-center flex-shrink-0 mt-1">
    <i class="fas fa-shield-halved text-black text-xs"></i>
</div>
<div class="flex-1">
    <p class="text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">
        Cyber Security Assistant
    </p>
    <div class="ai-response-content space-y-3 text-[15px] leading-relaxed">
        ${isStreaming ? '' : htmlContent}
    </div>
    
    <div class="feedback-tools mt-6 flex items-center gap-4 ${isStreaming ? 'hidden' : 'opacity-0'} group-hover:opacity-100 transition-opacity">
        <button onclick="submitFeedback(this, true)" class="text-xs text-gray-500 hover:text-emerald-400 transition-colors flex items-center gap-1.5">
            <i class="far fa-thumbs-up"></i> Bermanfaat
        </button>
        <button onclick="submitFeedback(this, false)" class="text-xs text-gray-500 hover:text-rose-400 transition-colors flex items-center gap-1.5">
            <i class="far fa-thumbs-down"></i> Kurang Tepat
        </button>
        <button onclick="openCorrectionModal(this)" class="text-xs text-gray-400 hover:text-white transition-colors flex items-center gap-1.5 ml-auto">
            <i class="fas fa-pen-nib"></i> Koreksi
        </button>
    </div>
</div>`
                 messageContainer.appendChild(el)
                 scrollBottom()
                 
                 if (isStreaming) {
                     const target = el.querySelector('.ai-response-content')
                     typewriterEffect(target, htmlContent, () => {
                         el.querySelector('.feedback-tools').classList.remove('hidden')
                         scrollBottom()
                     })
                 }
             }

             function typewriterEffect(container, html, callback) {
                 const temp = document.createElement('div')
                 temp.innerHTML = html
                 const nodes = Array.from(temp.childNodes)
                 
                 const cursor = document.createElement('span')
                 cursor.className = 'typing-cursor'
                 container.appendChild(cursor)

                 async function processNodes(nodeList, targetContainer) {
                     for (const node of nodeList) {
                         if (node.nodeType === Node.TEXT_NODE) {
                             await typeText(node.textContent, targetContainer)
                         } else {
                             const newNode = node.cloneNode(false)
                             targetContainer.appendChild(newNode)
                             if (node.childNodes.length > 0) {
                                 await processNodes(Array.from(node.childNodes), newNode)
                             }
                         }
                         scrollBottom()
                     }
                 }

                 function typeText(text, target) {
                     return new Promise(resolve => {
                         let charIndex = 0
                         const interval = setInterval(() => {
                             if (charIndex >= text.length) {
                                 clearInterval(interval)
                                 resolve()
                                 return
                             }
                             const charNode = document.createTextNode(text[charIndex++])
                             target.appendChild(charNode)
                             target.appendChild(cursor) // Always keep cursor at the end of current typing point
                             
                             if (charIndex % 5 === 0) scrollBottom()
                         }, 8)
                     })
                 }

                 processNodes(nodes, container).then(() => {
                     cursor.remove()
                     if (callback) callback()
                 })
             }

             function appendThinking() {
                 const el = document.createElement('div')
                 el.className = 'ai-message flex gap-5'
                 el.innerHTML = `
<div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center">
    <i class="fas fa-spinner fa-spin text-xs text-white/70"></i>
</div>
<div class="flex-1">
    <p class="text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">
        Cyber Security Assistant
    </p>
    <div class="text-gray-400 italic">Menganalisis permintaan keamanan...</div>
</div>`
                 messageContainer.appendChild(el)
                 thinkingEl = el
                 scrollBottom()
             }

             function removeThinking() {
                 if (thinkingEl) thinkingEl.remove()
                 thinkingEl = null
             }

             function closeAllSessionMenus() {
                 document.querySelectorAll('[data-session-menu]')
                     .forEach(m => m.classList.add('hidden'))
                 openMenuToken = null
             }

             function toggleSessionMenu(e, token) {
                 e.stopPropagation()
                 const menu = document.querySelector(`[data-session-menu="${token}"]`)
                 if (!menu) return

                 if (openMenuToken && openMenuToken !== token) closeAllSessionMenus()

                 const hidden = menu.classList.contains('hidden')
                 closeAllSessionMenus()

                 if (hidden) {
                     menu.classList.remove('hidden')
                     openMenuToken = token
                 }
             }

             function loadSessions() {
                 axios.get('/ai-agent/sessions').then(res => {
                     sessionList.innerHTML = ''
                     const items = (res.data || []).slice().sort(
                         (a, b) => (b.is_pinned ? 1 : 0) - (a.is_pinned ? 1 : 0)
                     )

                     items.forEach(s => {
                         const row = document.createElement('div')
                         row.className = `px-4 py-3 rounded-lg cursor-pointer text-sm ${
                activeSession === s.session_token
                    ? 'bg-white/10 text-white'
                    : 'text-gray-400 hover:text-white hover:bg-white/5'
            }`

                         row.innerHTML = `
<div class="flex items-center justify-between gap-3">
    <div class="truncate flex-1">${escapeHtml(s.title || 'Percakapan Baru')}</div>
    <div class="relative flex-shrink-0">
        <button class="w-8 h-8 rounded-lg hover:bg-white/10 flex items-center justify-center"
            onclick="toggleSessionMenu(event,'${s.session_token}')">
            <i class="fas fa-ellipsis text-xs"></i>
        </button>
        <div data-session-menu="${s.session_token}"
            class="hidden absolute right-0 mt-2 w-40 bg-[#111] border border-white/10 rounded-xl shadow-2xl overflow-hidden z-[60]">
            <button class="w-full px-3 py-2 text-left text-xs hover:bg-white/5"
                onclick="pinSession(event,'${s.session_token}')">
                ${s.is_pinned ? 'Unpin Chat' : 'Pin Chat'}
            </button>
            <button class="w-full px-3 py-2 text-left text-xs text-red-400 hover:bg-red-500/10"
                onclick="openDeleteModal(event,'${s.session_token}')">
                Hapus Chat
            </button>
        </div>
    </div>
</div>`
                         row.onclick = () => openSession(s.session_token)
                         sessionList.appendChild(row)
                     })
                 })
             }

             function openSession(token, push = true) {
                 closeAllSessionMenus()
                 activeSession = token
                 isCreatingSession = false
                 messageContainer.innerHTML = ''
                 welcomeView.style.display = 'none'
                 if (push) setUrl(token)
                 loadSessions()

                 axios.get(`/ai-agent/sessions/${token}`).then(res => {
                     messageContainer.innerHTML = ''
                     welcomeView.style.display = 'none'
                     res.data.messages.forEach(m =>
                         m.role === 'user' ?
                         appendUser(m.content) :
                         appendAssistant(m.content)
                     )
                 })
             }

             function createNewChat() {
                 if (isCreatingSession) return Promise.resolve()
                 isCreatingSession = true

                 return axios.post('/ai-agent/sessions')
                     .then(r => {
                         activeSession = r.data.session_token
                         setUrl(activeSession)
                         messageContainer.innerHTML = ''
                         welcomeView.style.display = 'block'
                         loadSessions()
                     })
                     .finally(() => isCreatingSession = false)
             }

             function sendMessage(text) {
                 appendUser(text)
                 appendThinking()
                 sendBtn.disabled = true

                 axios.post(`/ai-agent/sessions/${activeSession}/message`, {
                         content: text
                     })
                     .then(res => {
                         removeThinking()
                         appendAssistant(res.data.content, true)
                         loadSessions()
                     })
                     .catch(err => {
                         removeThinking()
                         appendAssistant(err.response?.data?.content || 'Permintaan tidak dapat diproses.')
                     })
                     .finally(() => {
                         sendBtn.disabled = false
                     })
             }

             chatForm.addEventListener('submit', async e => {
                 e.preventDefault()

                 const text = chatInput.value.trim()
                 if (!text) return

                 chatInput.value = ''

                 if (!activeSession) {
                     await createNewChat()
                 }

                 sendMessage(text)
             })

             chatInput.addEventListener('input', () => {
                 sendBtn.disabled = !chatInput.value.trim()
             })
    </script>

    <script>
        function adjustInputHeight(el) {
            el.style.height = 'auto'
            el.style.height = Math.min(el.scrollHeight, 240) + 'px'
        }

        function pinSession(e, token) {
            e.stopPropagation()
            closeAllSessionMenus()
            axios.post(`/ai-agent/sessions/${token}/pin`).then(loadSessions)
        }

        function openDeleteModal(e, token) {
            e.stopPropagation()
            closeAllSessionMenus()
            deleteTargetToken = token
            deleteModal.classList.remove('hidden')
            deleteModal.classList.add('flex')
        }

        function closeDeleteModal() {
            deleteTargetToken = null
            deleteModal.classList.add('hidden')
        }

        function confirmDeleteChat() {
            if (!deleteTargetToken) return
            axios.delete(`/ai-agent/sessions/${deleteTargetToken}`).then(() => {
                if (activeSession === deleteTargetToken) {
                    activeSession = null
                    history.pushState({}, '', `/ai-agent/chat`)
                    messageContainer.innerHTML = ''
                    welcomeView.style.display = 'block'
                }
                loadSessions()
                closeDeleteModal()
            })
        }

        function toggleSidebar() {
            sidebar.classList.toggle('collapsed')
        }

        function toggleMobileSidebar() {
            sidebar.classList.toggle('mobile-open')
            overlay.classList.toggle('active')
        }

        function handleLogout() {
            logoutModal.style.display = 'flex'
        }

        function closeLogoutModal() {
            logoutModal.style.display = 'none'
        }

        function executeLogout() {
            axios.post('/logout').finally(() => location.href = '/ai-agent/login')
        }

        window.addEventListener('popstate', e => {
            if (e.state?.token) openSession(e.state.token, false)
        })

        document.addEventListener('click', e => {
            if (!e.target.closest('[data-session-menu]') && !e.target.closest('button')) closeAllSessionMenus()
        })

        viewport.addEventListener('scroll', closeAllSessionMenus, {
            passive: true
        })

        document.addEventListener('DOMContentLoaded', () => {
            const token = getTokenFromUrl()
            loadSessions()
            if (token) openSession(token, false)
            sendBtn.disabled = true
        })

        function submitFeedback(btn, helpful) {
            const aiMessage = btn.closest('.ai-message')
            const responseContent = aiMessage.querySelector('.ai-response-content').innerText
            const token = activeSession

            axios.post(`/ai-agent/sessions/${token}/feedback`, {
                was_helpful: helpful,
                score: helpful ? 5 : 1,
                ai_response: responseContent
            }).then(() => {
                const parent = btn.parentElement
                parent.innerHTML = `<span class="text-[10px] text-gray-500 italic"><i class="fas fa-check mr-1"></i> Terima kasih atas feedback Anda!</span>`
            })
        }

        let currentCorrectionBtn = null

        function openCorrectionModal(btn) {
            currentCorrectionBtn = btn
            const modal = document.getElementById('correction-modal')
            modal.classList.remove('hidden')
            modal.classList.add('flex')
            document.getElementById('correction-input').focus()
        }

        function closeCorrectionModal() {
            document.getElementById('correction-modal').classList.add('hidden')
            currentCorrectionBtn = null
        }

        function submitCorrection() {
            const input = document.getElementById('correction-input')
            const correction = input.value.trim()
            if (!correction) return

            const aiMessage = currentCorrectionBtn.closest('.ai-message')
            const responseContent = aiMessage.querySelector('.ai-response-content').innerText
            const token = activeSession

            axios.post(`/ai-agent/sessions/${token}/correction`, {
                correction: correction,
                ai_response: responseContent
            }).then(() => {
                const parent = currentCorrectionBtn.parentElement
                parent.innerHTML = `<span class="text-[10px] text-emerald-500 italic"><i class="fas fa-check-double mr-1"></i> Koreksi telah disimpan untuk pembelajaran AI.</span>`
                closeCorrectionModal()
                input.value = ''
            })
        }
    </script>

</body>

</html>
