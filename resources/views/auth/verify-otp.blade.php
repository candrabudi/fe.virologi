@extends('layouts.app')

@section('meta_title', 'Verifikasi OTP | RD-VIROLOGI')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-20 px-4 relative overflow-hidden">
    <!-- Decors -->
    <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-emerald-500/10 rounded-full blur-[100px] animate-pulse"></div>
    <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-sky-500/10 rounded-full blur-[100px] animate-pulse" style="animation-delay: 2s;"></div>

    <div class="max-w-md w-full relative z-10" data-aos="zoom-in">
        <div class="glossy-card rounded-[2.5rem] p-8 lg:p-12 border border-white/40 shadow-2xl text-center">
            <div class="mb-10">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-emerald-50 text-emerald-600 mb-6 shadow-sm">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-black heading-font text-slate-900 mb-2">Verifikasi Keamanan.</h2>
                <p class="text-slate-500 text-sm">Silakan masukkan 6 digit kode yang dikirim ke kredensial Anda.</p>
            </div>

            <div id="alert-box" class="hidden mb-6 p-4 rounded-xl text-xs font-bold uppercase tracking-widest border"></div>

            <form id="otp-form" class="space-y-8">
                @csrf
                <div class="flex justify-center">
                    <input type="text" name="otp" required maxlength="6"
                           class="w-full text-center tracking-[0.5em] text-4xl font-black py-5 rounded-2xl border border-slate-200 bg-white/50 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/5 transition-all text-slate-900"
                           placeholder="000000" autofocus>
                </div>

                <div class="space-y-4">
                    <button type="submit" id="submit-btn"
                            class="w-full py-5 bg-slate-900 text-white rounded-xl font-bold text-xs uppercase tracking-[0.2em] hover:bg-emerald-600 transition-all shadow-xl shadow-slate-900/10 active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="btn-text">Konfirmasi Identitas &rarr;</span>
                        <span id="btn-loader" class="hidden flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memverifikasi...
                        </span>
                    </button>
                    
                    <button type="button" onclick="location.reload()"
                            class="text-xs font-bold text-slate-400 uppercase tracking-widest hover:text-slate-900 transition-colors">
                        Kirim Ulang Kode dalam <span id="timer">00:59</span>
                    </button>
                </div>
            </form>

            <div class="mt-10 pt-8 border-t border-slate-100">
                <a href="{{ route('login') }}" class="text-xs font-bold text-sky-600 uppercase tracking-widest hover:underline transition-all">
                    &larr; Kembali ke Masuk
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    let seconds = 59;
    const timerElement = document.getElementById('timer');
    const interval = setInterval(() => {
        seconds--;
        timerElement.innerText = `00:${seconds < 10 ? '0' : ''}${seconds}`;
        if (seconds <= 0) clearInterval(interval);
    }, 1000);

    document.getElementById('otp-form').addEventListener('submit', function(e) {
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

        axios.post('{{ route('verify-otp.post') }}', data)
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
                
                const message = error.response?.data?.message || 'Verifikasi gagal. Silakan coba lagi.';
                alertBox.innerText = message;
            });
    });
</script>
@endsection
