<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekrutmen Personel | RD-VIROLOGI</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <style>
        :root {
            --primary: #8b5cf6;
            --primary-dark: #7c3aed;
            --accent: #22d3ee;
            --dark: #0f172a;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #020617;
            color: #f8fafc;
            overflow: hidden; /* Prevent scrolling for stand-alone layout */
        }

        .canvas-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .mesh-gradient {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background-color: #020617;
            background-image: 
                radial-gradient(at 10% 20%, rgba(139, 92, 246, 0.15) 0px, transparent 50%),
                radial-gradient(at 90% 80%, rgba(34, 211, 238, 0.1) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(139, 92, 246, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(34, 211, 238, 0.1) 0px, transparent 50%);
        }

        .glass-card {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .input-glow:focus {
            box-shadow: 0 0 20px rgba(139, 92, 246, 0.15);
            border-color: rgba(139, 92, 246, 0.5);
        }

        .shimmer-btn {
            position: relative;
            overflow: hidden;
        }

        .shimmer-btn::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.1) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            transform: rotate(45deg);
            transition: all 0.5s;
            opacity: 0;
        }

        .shimmer-btn:hover::after {
            opacity: 1;
            left: 100%;
            top: 100%;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .float-anim {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>
<body class="min-h-screen py-10 flex items-center justify-center p-4">
    <!-- Modern Cyber HUD Background -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden bg-[#020617]">
        <!-- Scanning Grid -->
        <div class="absolute inset-0 opacity-10" 
             style="background-image: linear-gradient(#8b5cf6 1px, transparent 1px), linear-gradient(90deg, #8b5cf6 1px, transparent 1px); background-size: 50px 50px;">
        </div>
        
        <!-- Rotating Tactical Elements -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[1000px] h-[1000px] border border-violet-500/5 rounded-full animate-[spin_60s_linear_infinite]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] border border-violet-500/10 rounded-full animate-[spin_40s_linear_infinite_reverse]">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-2 h-2 bg-violet-500/30 rounded-full"></div>
        </div>

        <!-- Floating Live Data Panels -->
        <div class="absolute top-40 right-10 w-48 h-24 glass-card rounded-xl p-3 border-white/5 opacity-30 float-anim" style="animation-duration: 7s;">
            <div class="text-[7px] font-bold text-violet-400 uppercase mb-2">Satellite Uplink</div>
            <div class="flex gap-1 items-end">
                <div class="w-1 bg-violet-500/40 h-8"></div>
                <div class="w-1 bg-violet-500/40 h-12"></div>
                <div class="w-1 bg-violet-500/40 h-6"></div>
                <div class="w-1 bg-violet-500/40 h-10"></div>
            </div>
        </div>

        <div class="absolute bottom-20 left-10 w-56 h-32 glass-card rounded-xl p-4 border-white/5 opacity-20 float-anim" style="animation-duration: 12s; animation-delay: 1s;">
            <div class="text-[7px] font-bold text-fuchsia-400 uppercase mb-2">Personnel Database</div>
            <div class="font-mono text-[9px] text-slate-600 space-y-1">
                <div>> SEARCHING...</div>
                <div>> NO RECORD FOUND</div>
                <div class="animate-pulse">> AWAITING INPUT_</div>
            </div>
        </div>
    </div>

    <div class="mesh-gradient"></div>

    <!-- Back to Home Floating Button -->
    <a href="/" class="fixed top-6 left-6 z-[100] group flex items-center gap-3 py-2 px-4 rounded-full bg-white/5 hover:bg-white/10 border border-white/5 hover:border-white/20 transition-all backdrop-blur-md">
        <div class="w-8 h-8 rounded-full bg-violet-500/20 flex items-center justify-center group-hover:bg-violet-500 transition-colors">
            <i class="ri-arrow-left-line text-violet-400 group-hover:text-white transition-colors"></i>
        </div>
        <span class="text-[10px] font-bold text-slate-400 group-hover:text-white uppercase tracking-[0.2em] pr-2">Kembali ke Beranda</span>
    </a>

    <div class="w-full max-w-[640px] relative z-10">
        <!-- Logo Section -->
        <div class="text-center mb-8 float-anim">
            <a href="/" class="inline-flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-fuchsia-600 rounded-2xl flex items-center justify-center shadow-lg shadow-violet-500/20 border border-white/20">
                    <i class="ri-user-add-line text-2xl text-white"></i>
                </div>
                <div class="text-left">
                    <h1 class="text-xl font-black tracking-tight leading-none text-white uppercase">RD-VIROLOGI</h1>
                    <p class="text-[9px] font-bold text-violet-400 tracking-[0.3em] uppercase opacity-80 mt-1">Recruitment Protocol</p>
                </div>
            </a>
        </div>

        <!-- Registration Card -->
        <div class="glass-card rounded-[2.5rem] overflow-hidden p-8 md:p-12 relative border border-white/5">
            <div class="relative z-10">
                <div class="mb-10 text-center">
                    <h2 class="text-3xl font-extrabold text-white mb-2">Inisialisasi Operatif.</h2>
                    <p class="text-slate-400 text-sm font-medium">Lengkapi profil Anda untuk bergabung dengan jaringan pertahanan siber global kami.</p>
                </div>

                <div id="alert-box" class="hidden mb-8 p-4 rounded-2xl text-xs font-bold uppercase tracking-wider border flex items-center gap-3">
                    <i id="alert-icon" class="ri-information-line text-lg"></i>
                    <span id="alert-message"></span>
                </div>

                <form id="register-form" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.15em] ml-1">Identitas Lengkap</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <i class="ri-user-line text-slate-500 group-focus-within:text-violet-400 transition-colors"></i>
                                </div>
                                <input type="text" name="full_name" required
                                       class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl py-4 pl-12 pr-5 focus:outline-none focus:ring-0 input-glow transition-all text-sm font-medium placeholder:text-slate-600"
                                       placeholder="Nama Lengkap...">
                            </div>
                            <p class="error-msg text-red-500 text-[10px] mt-1 font-bold hidden pl-1" id="error-full_name"></p>
                        </div>

                        <!-- Username -->
                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.15em] ml-1">Nama Sandi (@)</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <i class="ri-at-line text-slate-500 group-focus-within:text-violet-400 transition-colors"></i>
                                </div>
                                <input type="text" name="username" required
                                       class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl py-4 pl-12 pr-5 focus:outline-none focus:ring-0 input-glow transition-all text-sm font-medium placeholder:text-slate-600 font-mono"
                                       placeholder="agent_key">
                            </div>
                            <p class="error-msg text-red-500 text-[10px] mt-1 font-bold hidden pl-1" id="error-username"></p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.15em] ml-1">Saluran Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <i class="ri-mail-line text-slate-500 group-focus-within:text-violet-400 transition-colors"></i>
                            </div>
                            <input type="email" name="email" required
                                   class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl py-4 pl-12 pr-5 focus:outline-none focus:ring-0 input-glow transition-all text-sm font-medium placeholder:text-slate-600"
                                   placeholder="email@secure.network">
                        </div>
                        <p class="error-msg text-red-500 text-[10px] mt-1 font-bold hidden pl-1" id="error-email"></p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.15em] ml-1">Kunci Keamanan</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <i class="ri-lock-password-line text-slate-500 group-focus-within:text-violet-400 transition-colors"></i>
                                </div>
                                <input type="password" name="password" required
                                       class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl py-4 pl-12 pr-5 focus:outline-none focus:ring-0 input-glow transition-all text-sm font-medium placeholder:text-slate-600"
                                       placeholder="••••••••">
                            </div>
                            <p class="error-msg text-red-500 text-[10px] mt-1 font-bold hidden pl-1" id="error-password"></p>
                        </div>

                        <!-- Confirmation -->
                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.15em] ml-1">Verifikasi Kunci</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <i class="ri-shield-check-line text-slate-500 group-focus-within:text-violet-400 transition-colors"></i>
                                </div>
                                <input type="password" name="password_confirmation" required
                                       class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl py-4 pl-12 pr-5 focus:outline-none focus:ring-0 input-glow transition-all text-sm font-medium placeholder:text-slate-600"
                                       placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 py-2">
                        <div class="relative mt-1">
                            <input type="checkbox" name="terms" required id="terms" class="peer hidden">
                            <div class="w-5 h-5 rounded-md border-2 border-slate-700 peer-checked:bg-violet-500 peer-checked:border-violet-500 transition-all flex items-center justify-center">
                                <i class="ri-check-line text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                            </div>
                        </div>
                        <label for="terms" class="text-[11px] font-bold text-slate-500 uppercase tracking-widest leading-relaxed cursor-pointer hover:text-slate-300 transition-colors">
                            Saya menerima <a href="#" class="text-violet-400 hover:text-violet-300 underline underline-offset-4">Protokol Keamanan</a> dan perjanjian kerahasiaan data.
                        </label>
                    </div>

                    <button type="submit" id="submit-btn"
                            class="shimmer-btn w-full py-5 bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-500 hover:to-indigo-500 text-white rounded-2xl font-bold text-xs uppercase tracking-[0.25em] transition-all shadow-lg shadow-violet-500/20 active:scale-[0.98] disabled:opacity-50 flex items-center justify-center gap-3">
                        <span id="btn-text">Daftarkan Personel</span>
                        <div id="btn-loader" class="hidden">
                            <svg class="animate-spin h-4 w-4 text-white" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        <i id="btn-icon" class="ri-radar-line text-lg"></i>
                    </button>
                </form>

                <div class="mt-12 text-center">
                    <p class="text-xs font-medium text-slate-500">
                        Sudah terdaftar sebagai operatif? 
                        <a href="{{ route('login') }}" class="text-violet-400 hover:text-violet-300 font-bold ml-1 transition-colors">Masuk Portal</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="mt-8 text-center">
            <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest leading-loose">
                Sistem Pendaftaran Terenkripsi Bit-ke-Bit<br>
                &copy; {{ date('Y') }} RD-VIROLOGI THREAT CENTER
            </p>
        </div>
    </div>

    <script>
        document.getElementById('register-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = e.target;
            const submitBtn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const btnLoader = document.getElementById('btn-loader');
            const btnIcon = document.getElementById('btn-icon');
            const alertBox = document.getElementById('alert-box');
            const alertMessage = document.getElementById('alert-message');
            const alertIcon = document.getElementById('alert-icon');
            
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            submitBtn.disabled = true;
            btnText.innerText = "Memproses...";
            btnLoader.classList.remove('hidden');
            btnIcon.classList.add('hidden');
            alertBox.classList.add('hidden');
            document.querySelectorAll('.error-msg').forEach(el => el.classList.add('hidden'));

            axios.post('{{ route("register.post") }}', data)
                .then(response => {
                    if (response.data.success) {
                        alertBox.classList.remove('hidden', 'bg-red-500/10', 'text-red-400', 'border-red-500/20');
                        alertBox.classList.add('bg-emerald-500/10', 'text-emerald-400', 'border-emerald-500/20');
                        alertIcon.className = 'ri-checkbox-circle-line text-lg';
                        alertMessage.innerText = response.data.message;
                        
                        submitBtn.classList.remove('from-violet-600', 'to-indigo-600');
                        submitBtn.classList.add('from-emerald-500', 'to-teal-600');
                        btnText.innerText = "Rekrutmen Berhasil";
                        
                        setTimeout(() => {
                            window.location.href = response.data.redirect;
                        }, 1500);
                    }
                })
                .catch(error => {
                    submitBtn.disabled = false;
                    btnText.innerText = "Daftarkan Personel";
                    btnLoader.classList.add('hidden');
                    btnIcon.classList.remove('hidden');
                    
                    alertBox.classList.remove('hidden', 'bg-emerald-500/10', 'text-emerald-400', 'border-emerald-500/20');
                    alertBox.classList.add('bg-red-500/10', 'text-red-400', 'border-red-500/20');
                    alertIcon.className = 'ri-error-warning-line text-lg';
                    
                    if (error.response?.status === 422) {
                        const errors = error.response.data.errors;
                        Object.keys(errors).forEach(key => {
                            const errorEl = document.getElementById('error-' + key);
                            if (errorEl) {
                                errorEl.innerText = errors[key][0];
                                errorEl.classList.remove('hidden');
                            }
                        });
                        alertMessage.innerText = 'Validasi gagal. Mohon periksa kembali input Anda.';
                    } else {
                        alertMessage.innerText = error.response?.data?.message || 'Terjadi kesalahan sistem internal.';
                    }
                });
        });
    </script>
</body>
</html>
