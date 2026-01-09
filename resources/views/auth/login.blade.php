<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | RD-VIROLOGI</title>
    
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
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --accent: #6366f1;
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
                radial-gradient(at 0% 0%, rgba(14, 165, 233, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(14, 165, 233, 0.1) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(99, 102, 241, 0.1) 0px, transparent 50%);
        }

        .glass-card {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .input-glow:focus {
            box-shadow: 0 0 20px rgba(14, 165, 233, 0.15);
            border-color: rgba(14, 165, 233, 0.5);
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

        /* OTP Input Styling */
        .otp-input {
            width: 48px;
            height: 56px;
            background: rgba(15, 23, 42, 0.4);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 800;
            font-family: 'JetBrains Mono', monospace;
            color: var(--primary);
            transition: all 0.3s;
        }

        .otp-input:focus {
            border-color: var(--primary);
            background: rgba(14, 165, 233, 0.1);
            box-shadow: 0 0 15px rgba(14, 165, 233, 0.2);
            outline: none;
        }

        .section-transition {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <!-- Modern Cyber HUD Background -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden bg-[#020617]">
        <!-- Scanning Grid -->
        <div class="absolute inset-0 opacity-20" 
             style="background-image: linear-gradient(#1e293b 1px, transparent 1px), linear-gradient(90deg, #1e293b 1px, transparent 1px); background-size: 40px 40px;">
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#020617] via-transparent to-[#020617]"></div>

        <!-- Rotating Tactical Elements -->
        <div class="absolute top-[-10%] right-[-10%] w-[600px] h-[600px] border border-sky-500/10 rounded-full animate-[spin_20s_linear_infinite]">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-4 h-4 bg-sky-500/40 rounded-full blur-sm"></div>
        </div>
        <div class="absolute bottom-[-20%] left-[-10%] w-[800px] h-[800px] border border-indigo-500/5 rounded-full animate-[spin_35s_linear_infinite_reverse]">
            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-6 h-6 bg-indigo-500/20 rounded-full blur-sm"></div>
        </div>

        <!-- Floating Live Data Panels -->
        <div class="absolute top-20 left-10 w-48 h-32 glass-card rounded-xl p-3 border-white/5 opacity-40 float-anim" style="animation-duration: 8s;">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-[8px] font-bold text-sky-400 uppercase">System Status</span>
            </div>
            <div class="space-y-1">
                <div class="h-1 bg-sky-500/20 rounded-full w-full"></div>
                <div class="h-1 bg-sky-500/20 rounded-full w-3/4"></div>
                <div class="h-1 bg-sky-500/20 rounded-full w-5/6"></div>
            </div>
        </div>

        <div class="absolute bottom-40 right-20 w-56 h-40 glass-card rounded-xl p-4 border-white/5 opacity-30 float-anim" style="animation-duration: 10s; animation-delay: 2s;">
            <div class="text-[8px] font-bold text-indigo-400 uppercase mb-2">Encryption Key V2</div>
            <div class="font-mono text-[10px] text-slate-500 break-all leading-tight">
                01100111 01100101 01101101 01101001 01101110 01101001
            </div>
        </div>

        <!-- Glowing Pulse Overlay -->
        <div class="absolute inset-0 bg-radial-gradient from-sky-500/5 to-transparent pointer-events-none"></div>
    </div>

    <div class="mesh-gradient"></div>

    <!-- Back to Home Floating Button -->
    <a href="/" class="fixed top-6 left-6 z-[100] group flex items-center gap-3 py-2 px-4 rounded-full bg-white/5 hover:bg-white/10 border border-white/5 hover:border-white/20 transition-all backdrop-blur-md">
        <div class="w-8 h-8 rounded-full bg-sky-500/20 flex items-center justify-center group-hover:bg-sky-500 transition-colors">
            <i class="ri-arrow-left-line text-sky-400 group-hover:text-white transition-colors"></i>
        </div>
        <span class="text-[10px] font-bold text-slate-400 group-hover:text-white uppercase tracking-[0.2em] pr-2">Kembali ke Beranda</span>
    </a>

    <!-- Decoration Orbs -->
    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-sky-500/10 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-indigo-500/10 blur-[120px] rounded-full pointer-events-none"></div>

    <div class="w-full max-w-[480px] relative z-10">
        <!-- Logo Section -->
        <div class="text-center mb-8 float-anim">
            <a href="/" class="inline-flex items-center gap-3">
                <div class="w-14 h-14 bg-gradient-to-br from-sky-400 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-sky-500/20 shadow-lg border border-white/20">
                    <i class="ri-shield-flash-line text-3xl text-white"></i>
                </div>
                <div class="text-left">
                    <h1 class="text-2xl font-black tracking-tight leading-none text-white">RD-VIROLOGI</h1>
                    <p class="text-[10px] font-bold text-sky-400 tracking-[0.3em] uppercase opacity-80 mt-1">Intelligence Network</p>
                </div>
            </a>
        </div>

        <!-- Login Card -->
        <div class="glass-card rounded-[2.5rem] overflow-hidden p-8 md:p-12 relative border border-white/5">
            <div class="absolute top-0 right-0 p-8 opacity-10">
                <i class="ri-fingerprint-line text-8xl text-sky-400"></i>
            </div>

            <div class="relative z-10">
                <!-- Login Section -->
                <div id="login-section" class="section-transition opacity-100 scale-100 translate-x-0">
                    <div class="mb-10">
                        <h2 class="text-3xl font-extrabold text-white mb-2">Selamat Datang.</h2>
                        <p class="text-slate-400 text-sm font-medium">Autentikasi diperlukan untuk mengakses Secure Operations Center.</p>
                    </div>

                    <div id="alert-box" class="hidden mb-8 p-4 rounded-2xl text-xs font-bold uppercase tracking-wider border flex items-center gap-3">
                        <i id="alert-icon" class="ri-information-line text-lg"></i>
                        <span id="alert-message"></span>
                    </div>

                    <form id="login-form" class="space-y-6">
                        @csrf
                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.15em] ml-1">Username / Email Handle</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <i class="ri-user-6-line text-slate-500 group-focus-within:text-sky-400 transition-colors"></i>
                                </div>
                                <input type="text" name="login" required
                                       class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl py-4 pl-12 pr-5 focus:outline-none focus:ring-0 input-glow transition-all text-sm font-medium placeholder:text-slate-600"
                                       placeholder="Ketik identitas Anda...">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.15em] ml-1">Kunci Akses</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <i class="ri-lock-2-line text-slate-500 group-focus-within:text-sky-400 transition-colors"></i>
                                </div>
                                <input type="password" name="password" id="password" required
                                       class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl py-4 pl-12 pr-12 focus:outline-none focus:ring-0 input-glow transition-all text-sm font-medium placeholder:text-slate-600"
                                       placeholder="••••••••">
                                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-500 hover:text-sky-400 transition-colors">
                                    <i id="eye-icon" class="ri-eye-line"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="relative">
                                    <input type="checkbox" name="remember" class="peer hidden">
                                    <div class="w-5 h-5 rounded-md border-2 border-slate-700 peer-checked:bg-sky-500 peer-checked:border-sky-500 transition-all flex items-center justify-center">
                                        <i class="ri-check-line text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                                    </div>
                                </div>
                                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest group-hover:text-slate-300 transition-colors">Jaga Koneksi</span>
                            </label>
                            <a href="#" class="text-[11px] font-bold text-sky-400 uppercase tracking-widest hover:text-sky-300 hover:underline underline-offset-4 transition-all">Dekripsi Sandi?</a>
                        </div>

                        <button type="submit" id="submit-btn"
                                class="shimmer-btn w-full py-4 bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 text-white rounded-2xl font-bold text-xs uppercase tracking-[0.25em] transition-all shadow-lg shadow-sky-500/20 active:scale-[0.98] disabled:opacity-50 flex items-center justify-center gap-3">
                            <span id="btn-text">Verifikasi Secure Access</span>
                            <div id="btn-loader" class="hidden">
                                <svg class="animate-spin h-4 w-4 text-white" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <i id="btn-icon" class="ri-arrow-right-line text-lg"></i>
                        </button>
                    </form>

                    <div class="mt-12 text-center relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-white/5"></div>
                        </div>
                        <span class="relative bg-[#0b1224] px-4 text-slate-600 text-[10px] font-bold uppercase tracking-[0.2em]">Opsi Tambahan</span>
                    </div>

                    <div class="mt-8 text-center">
                        <p class="text-xs font-medium text-slate-500">
                            Belum memiliki operatif? 
                            <a href="{{ route('register') }}" class="text-sky-400 hover:text-sky-300 font-bold ml-1 transition-colors">Rekrut Sekarang</a>
                        </p>
                    </div>
                </div>

                <!-- OTP Section -->
                <div id="otp-section" class="section-transition hidden opacity-0 scale-95 translate-x-full">
                    <div class="mb-10">
                        <button onclick="switchSection('login')" class="mb-4 inline-flex items-center gap-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest hover:text-sky-400 transition-colors">
                            <i class="ri-arrow-left-s-line"></i> Kembali ke Login
                        </button>
                        <h2 class="text-3xl font-extrabold text-white mb-2">Verifikasi 2FA.</h2>
                        <p class="text-slate-400 text-sm font-medium">Masukkan 6-digit kode OTP yang telah dikirimkan ke saluran komunikasi Anda.</p>
                    </div>

                    <div id="otp-alert-box" class="hidden mb-8 p-4 rounded-2xl text-xs font-bold uppercase tracking-wider border flex items-center gap-3">
                        <i id="otp-alert-icon" class="ri-information-line text-lg"></i>
                        <span id="otp-alert-message"></span>
                    </div>

                    <form id="otp-form" class="space-y-8">
                        @csrf
                        <div class="flex justify-between gap-2 md:gap-4">
                            <input type="text" maxlength="1" class="otp-input" data-index="0" required>
                            <input type="text" maxlength="1" class="otp-input" data-index="1" required>
                            <input type="text" maxlength="1" class="otp-input" data-index="2" required>
                            <input type="text" maxlength="1" class="otp-input" data-index="3" required>
                            <input type="text" maxlength="1" class="otp-input" data-index="4" required>
                            <input type="text" maxlength="1" class="otp-input" data-index="5" required>
                        </div>

                        <div class="text-center">
                            <p class="text-[11px] font-bold text-slate-500 uppercase tracking-[0.2em]">
                                Tidak menerima kode? 
                                <button type="button" class="text-sky-400 hover:text-sky-300 ml-1 transition-colors">Kirim Ulang</button>
                            </p>
                        </div>

                        <button type="submit" id="otp-submit-btn"
                                class="shimmer-btn w-full py-4 bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 text-white rounded-2xl font-bold text-xs uppercase tracking-[0.25em] transition-all shadow-lg shadow-sky-500/20 active:scale-[0.98] disabled:opacity-50 flex items-center justify-center gap-3">
                            <span id="otp-btn-text">Validasi Token Akses</span>
                            <div id="otp-btn-loader" class="hidden">
                                <svg class="animate-spin h-4 w-4 text-white" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="mt-8 text-center">
            <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">
                &copy; {{ date('Y') }} RD-VIROLOGI <span class="mx-2">•</span> Enkripsi Bit-ke-Bit Standar Militer
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.className = 'ri-eye-off-line';
            } else {
                pwd.type = 'password';
                icon.className = 'ri-eye-line';
            }
        }

        function switchSection(target) {
            const loginSection = document.getElementById('login-section');
            const otpSection = document.getElementById('otp-section');

            if (target === 'otp') {
                loginSection.classList.replace('opacity-100', 'opacity-0');
                loginSection.classList.replace('scale-100', 'scale-95');
                loginSection.classList.add('translate-x-[-100%]');
                
                setTimeout(() => {
                    loginSection.classList.add('hidden');
                    otpSection.classList.remove('hidden');
                    setTimeout(() => {
                        otpSection.classList.replace('opacity-0', 'opacity-100');
                        otpSection.classList.replace('scale-95', 'scale-100');
                        otpSection.classList.replace('translate-x-full', 'translate-x-0');
                        document.querySelector('.otp-input').focus();
                    }, 50);
                }, 500);
            } else {
                otpSection.classList.replace('opacity-100', 'opacity-0');
                otpSection.classList.replace('scale-100', 'scale-95');
                otpSection.classList.replace('translate-x-0', 'translate-x-full');

                setTimeout(() => {
                    otpSection.classList.add('hidden');
                    loginSection.classList.remove('hidden');
                    setTimeout(() => {
                        loginSection.classList.replace('opacity-0', 'opacity-100');
                        loginSection.classList.replace('scale-95', 'scale-100');
                        loginSection.classList.remove('translate-x-[-100%]');
                    }, 50);
                }, 500);
            }
        }

        // OTP Input Logic
        const otpInputs = document.querySelectorAll('.otp-input');
        otpInputs.forEach((input, index) => {
            input.addEventListener('keyup', (e) => {
                if (e.key >= 0 && e.key <= 9) {
                    if (index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                } else if (e.key === 'Backspace') {
                    if (index > 0) {
                        otpInputs[index - 1].focus();
                    }
                }
            });

            // Handle Paste Event
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text').trim();
                const digits = pasteData.match(/\d/g);

                if (digits) {
                    digits.forEach((digit, i) => {
                        if (otpInputs[i]) {
                            otpInputs[i].value = digit;
                        }
                    });

                    // Focus the next empty or last input
                    const nextIndex = Math.min(digits.length, otpInputs.length - 1);
                    otpInputs[nextIndex].focus();
                }
            });
        });

        document.getElementById('login-form').addEventListener('submit', function(e) {
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

            axios.post('{{ route("login.post") }}', data)
                .then(response => {
                    if (response.data.success) {
                        alertBox.classList.remove('hidden', 'bg-red-500/10', 'text-red-400', 'border-red-500/20');
                        alertBox.classList.add('bg-emerald-500/10', 'text-emerald-400', 'border-emerald-500/20');
                        alertIcon.className = 'ri-checkbox-circle-line text-lg';
                        alertMessage.innerText = response.data.message;
                        
                        setTimeout(() => {
                            switchSection('otp');
                        }, 800);
                    }
                })
                .catch(error => {
                    submitBtn.disabled = false;
                    btnText.innerText = "Verifikasi Secure Access";
                    btnLoader.classList.add('hidden');
                    btnIcon.classList.remove('hidden');
                    
                    alertBox.classList.remove('hidden', 'bg-emerald-500/10', 'text-emerald-400', 'border-emerald-500/20');
                    alertBox.classList.add('bg-red-500/10', 'text-red-400', 'border-red-500/20');
                    alertIcon.className = 'ri-error-warning-line text-lg';
                    
                    const message = error.response?.data?.message || 'Identitas atau kunci akses tidak valid.';
                    alertMessage.innerText = message;
                });
        });

        document.getElementById('otp-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = document.getElementById('otp-submit-btn');
            const btnText = document.getElementById('otp-btn-text');
            const btnLoader = document.getElementById('otp-btn-loader');
            const alertBox = document.getElementById('otp-alert-box');
            const alertMessage = document.getElementById('otp-alert-message');
            const alertIcon = document.getElementById('otp-alert-icon');

            let otp = "";
            otpInputs.forEach(input => otp += input.value);

            submitBtn.disabled = true;
            btnText.innerText = "Memvalidasi Token...";
            btnLoader.classList.remove('hidden');
            alertBox.classList.add('hidden');

            axios.post('{{ route("verify-otp.post") }}', { otp: otp })
                .then(response => {
                    if (response.data.success) {
                        alertBox.classList.remove('hidden', 'bg-red-500/10', 'text-red-400', 'border-red-500/20');
                        alertBox.classList.add('bg-emerald-500/10', 'text-emerald-400', 'border-emerald-500/20');
                        alertIcon.className = 'ri-checkbox-circle-line text-lg';
                        alertMessage.innerText = response.data.message;

                        setTimeout(() => {
                            window.location.href = response.data.redirect;
                        }, 1000);
                    }
                })
                .catch(error => {
                    submitBtn.disabled = false;
                    btnText.innerText = "Validasi Token Akses";
                    btnLoader.classList.add('hidden');
                    
                    alertBox.classList.remove('hidden', 'bg-emerald-500/10', 'text-emerald-400', 'border-emerald-500/20');
                    alertBox.classList.add('bg-red-500/10', 'text-red-400', 'border-red-500/20');
                    alertIcon.className = 'ri-error-warning-line text-lg';
                    
                    const message = error.response?.data?.message || 'Kode verifikasi tidak valid atau kedaluwarsa.';
                    alertMessage.innerText = message;
                });
        });
    </script>
</body>
</html>
