@extends('layouts.app')

@section('meta_title', 'Rekrutmen Personel | RD-VIROLOGI')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-20 px-4 relative overflow-hidden">
    <!-- Decors -->
    <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-violet-500/10 rounded-full blur-[100px] animate-pulse"></div>
    <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-cyan-500/10 rounded-full blur-[100px] animate-pulse" style="animation-delay: 2s;"></div>

    <div class="max-w-xl w-full relative z-10" data-aos="zoom-in">
        <div class="glossy-card rounded-[2.5rem] p-8 lg:p-12 border border-white/40 shadow-2xl">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-violet-50 text-violet-600 mb-6 shadow-sm">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-black heading-font text-slate-900 mb-2">Bergabung dengan Jaringan.</h2>
                <p class="text-slate-500 text-sm">Inisialisasi profil operatif taktis Anda.</p>
            </div>

            <div id="alert-box" class="hidden mb-6 p-4 rounded-xl text-xs font-bold uppercase tracking-widest border"></div>

            <form id="register-form" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap Operatif</label>
                        <input type="text" name="full_name" required
                               class="w-full px-5 py-4 rounded-xl border border-slate-200 bg-white/50 focus:outline-none focus:border-violet-500 focus:ring-4 focus:ring-violet-500/5 transition-all text-slate-900 font-medium"
                               placeholder="contoh: John Doe">
                        <p class="error-msg text-red-500 text-[10px] mt-1 font-bold hidden" id="error-full_name"></p>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Handle Portal (@)</label>
                        <input type="text" name="username" required
                               class="w-full px-5 py-4 rounded-xl border border-slate-200 bg-white/50 focus:outline-none focus:border-violet-500 focus:ring-4 focus:ring-violet-500/5 transition-all text-slate-900 font-medium font-mono"
                               placeholder="agent_zero">
                        <p class="error-msg text-red-500 text-[10px] mt-1 font-bold hidden" id="error-username"></p>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Saluran Komunikasi (Email)</label>
                    <input type="email" name="email" required
                           class="w-full px-5 py-4 rounded-xl border border-slate-200 bg-white/50 focus:outline-none focus:border-violet-500 focus:ring-4 focus:ring-violet-500/5 transition-all text-slate-900 font-medium"
                           placeholder="j.doe@virologi.tech">
                    <p class="error-msg text-red-500 text-[10px] mt-1 font-bold hidden" id="error-email"></p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Kunci Akses (Password)</label>
                        <input type="password" name="password" required
                               class="w-full px-5 py-4 rounded-xl border border-slate-200 bg-white/50 focus:outline-none focus:border-violet-500 focus:ring-4 focus:ring-violet-500/5 transition-all text-slate-900 font-medium"
                               placeholder="••••••••">
                        <p class="error-msg text-red-500 text-[10px] mt-1 font-bold hidden" id="error-password"></p>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Verifikasi Kunci</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full px-5 py-4 rounded-xl border border-slate-200 bg-white/50 focus:outline-none focus:border-violet-500 focus:ring-4 focus:ring-violet-500/5 transition-all text-slate-900 font-medium"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center space-x-3 py-2">
                    <input type="checkbox" required class="w-4 h-4 rounded border-slate-300 text-violet-600 focus:ring-violet-500/20">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest leading-tight">
                        Saya setuju dengan <a href="#" class="text-violet-600 hover:underline">protokol</a> dan perjanjian kerahasiaan.
                    </span>
                </div>

                <button type="submit" id="submit-btn"
                        class="w-full py-5 bg-slate-900 text-white rounded-xl font-bold text-xs uppercase tracking-[0.2em] hover:bg-violet-600 transition-all shadow-xl shadow-slate-900/10 active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                    <span id="btn-text">Inisiasi Rekrutmen &rarr;</span>
                    <span id="btn-loader" class="hidden flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Merekrut...
                    </span>
                </button>
            </form>

            <div class="mt-10 pt-8 border-t border-slate-100 text-center">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                    Sudah menjadi operatif? <a href="{{ route('login') }}" class="text-violet-600 hover:text-violet-700">Masuk Portal</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('register-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = document.getElementById('submit-btn');
        const btnText = document.getElementById('btn-text');
        const btnLoader = document.getElementById('btn-loader');
        const alertBox = document.getElementById('alert-box');
        
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        submitBtn.disabled = true;
        btnText.classList.add('hidden');
        btnLoader.classList.remove('hidden');
        alertBox.classList.add('hidden');
        document.querySelectorAll('.error-msg').forEach(el => el.classList.add('hidden'));

        axios.post('{{ route('register.post') }}', data)
            .then(response => {
                if (response.data.success) {
                    alertBox.classList.remove('hidden', 'bg-red-50', 'text-red-600', 'border-red-100');
                    alertBox.classList.add('bg-emerald-50', 'text-emerald-600', 'border-emerald-100');
                    alertBox.innerText = response.data.message;
                    
                    setTimeout(() => {
                        window.location.href = response.data.redirect;
                    }, 2000);
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                btnText.classList.remove('hidden');
                btnLoader.classList.add('hidden');
                
                if (error.response?.status === 422) {
                    const errors = error.response.data.errors;
                    Object.keys(errors).forEach(key => {
                        const errorEl = document.getElementById('error-' + key);
                        if (errorEl) {
                            errorEl.innerText = errors[key][0];
                            errorEl.classList.remove('hidden');
                        }
                    });
                    alertBox.classList.remove('hidden', 'bg-emerald-50', 'text-emerald-600', 'border-emerald-100');
                    alertBox.classList.add('bg-red-50', 'text-red-600', 'border-red-100');
                    alertBox.innerText = 'Inisialisasi gagal. Silakan periksa persyaratan.';
                } else {
                    alertBox.classList.remove('hidden', 'bg-emerald-50', 'text-emerald-600', 'border-emerald-100');
                    alertBox.classList.add('bg-red-50', 'text-red-600', 'border-red-100');
                    alertBox.innerText = error.response?.data?.message || 'Rekrutmen gagal. Kesalahan server internal.';
                }
            });
    });
</script>
@endsection
