@extends('layouts.app')

@section('meta_title', 'Masuk | RD-VIROLOGI')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-20 px-4 relative overflow-hidden">
    <!-- Decors -->
    <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-sky-500/10 rounded-full blur-[100px] animate-pulse"></div>
    <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-indigo-500/10 rounded-full blur-[100px] animate-pulse" style="animation-delay: 2s;"></div>

    <div class="max-w-md w-full relative z-10" data-aos="zoom-in">
        <div class="glossy-card rounded-[2.5rem] p-8 lg:p-12 border border-white/40 shadow-2xl">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-sky-50 text-sky-600 mb-6 shadow-sm">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-black heading-font text-slate-900 mb-2">Portal Akses.</h2>
                <p class="text-slate-500 text-sm">Silakan verifikasi kredensial Anda untuk melanjutkan.</p>
            </div>

            <div id="alert-box" class="hidden mb-6 p-4 rounded-xl text-xs font-bold uppercase tracking-widest border"></div>

            <form id="login-form" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Username atau Email</label>
                    <input type="text" name="login" required
                           class="w-full px-5 py-4 rounded-xl border border-slate-200 bg-white/50 focus:outline-none focus:border-sky-500 focus:ring-4 focus:ring-sky-500/5 transition-all text-slate-900 font-medium"
                           placeholder="Masukkan handle Anda...">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Kata Sandi</label>
                    <input type="password" name="password" required
                           class="w-full px-5 py-4 rounded-xl border border-slate-200 bg-white/50 focus:outline-none focus:border-sky-500 focus:ring-4 focus:ring-sky-500/5 transition-all text-slate-900 font-medium"
                           placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between py-2">
                    <label class="flex items-center space-x-3 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500/20">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest group-hover:text-slate-900 transition-colors">Ingat Saya</span>
                    </label>
                    <a href="#" class="text-xs font-bold text-sky-600 uppercase tracking-widest hover:text-sky-700 transition-colors">Lupa Portal?</a>
                </div>

                <button type="submit" id="submit-btn"
                        class="w-full py-5 bg-slate-900 text-white rounded-xl font-bold text-xs uppercase tracking-[0.2em] hover:bg-sky-600 transition-all shadow-xl shadow-slate-900/10 active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                    <span id="btn-text">Inisiasi Koneksi &rarr;</span>
                    <span id="btn-loader" class="hidden flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menghubungkan...
                    </span>
                </button>
            </form>

            <div class="mt-10 pt-8 border-t border-slate-100 text-center">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                    Operative Baru? <a href="{{ route('register') }}" class="text-sky-600 hover:text-sky-700 underline decoration-sky-500/30 underline-offset-4">Bergabung dengan Jaringan</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('login-form').addEventListener('submit', function(e) {
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

        axios.post('{{ route('login.post') }}', data)
            .then(response => {
                if (response.data.success) {
                    alertBox.classList.remove('hidden', 'bg-red-50', 'text-red-600', 'border-red-100');
                    alertBox.classList.add('bg-emerald-50', 'text-emerald-600', 'border-emerald-100');
                    alertBox.innerText = response.data.message;
                    
                    setTimeout(() => {
                        window.location.href = response.data.redirect;
                    }, 1000);
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                btnText.classList.remove('hidden');
                btnLoader.classList.add('hidden');
                
                alertBox.classList.remove('hidden', 'bg-emerald-50', 'text-emerald-600', 'border-emerald-100');
                alertBox.classList.add('bg-red-50', 'text-red-600', 'border-red-100');
                
                const message = error.response?.data?.message || 'Terjadi kesalahan. Silakan coba lagi.';
                alertBox.innerText = message;
            });
    });
</script>
@endsection
