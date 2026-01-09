@extends('layouts.app')

@section('meta_title', 'Arsip Personel | RD-VIROLOGI')

@section('content')
<div class="pt-24 pb-12 lg:pt-32 relative min-h-screen">
    <!-- Sophisticated Background Decors -->
    <div class="fixed top-0 right-0 w-1/2 h-full bg-gradient-to-l from-sky-100/10 to-transparent pointer-events-none"></div>
    <div class="fixed bottom-0 left-0 w-1/2 h-full bg-gradient-to-r from-indigo-100/5 to-transparent pointer-events-none"></div>

    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-12 relative z-10">
        <!-- Profile Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12" data-aos="fade-down">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-indigo-500/10 text-indigo-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-full border border-indigo-500/20">Izin Keamanan: Alpha</span>
                    <div class="h-[1px] w-12 bg-slate-200"></div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">UID Karyawan: #{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <h2 class="text-5xl font-black text-slate-900 tracking-tighter leading-none">Berkas <span class="text-indigo-500">Personel.</span></h2>
                <p class="text-slate-500 mt-4 max-w-xl text-sm leading-relaxed font-medium">
                    Kelola kredensial operatif, identitas holografik, dan protokol komunikasi aman Anda.
                </p>
            </div>

            <div class="flex items-center gap-4">
               <a href="{{ route('dashboard') }}" class="px-7 py-4 bg-white border border-slate-200 rounded-[1.5rem] text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 hover:text-sky-600 hover:border-sky-200 transition-all flex items-center gap-3 shadow-sm group">
                   <i class="ri-arrow-left-up-line group-hover:-translate-y-1 group-hover:-translate-x-1 transition-transform"></i> Kembali ke Pusat
               </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Left Column: Dossier Card -->
            <div class="lg:col-span-4" data-aos="fade-right">
                <div class="glossy-card rounded-[3.5rem] p-10 border border-white shadow-2xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-10 opacity-[0.03]">
                        <i class="ri-fingerprint-fill text-[15rem]"></i>
                    </div>

                    <div class="relative z-10 text-center">
                        <div class="inline-block relative mb-10">
                            <div class="w-52 h-52 rounded-[4rem] overflow-hidden border-8 border-white shadow-2xl transition-transform duration-700 group-hover:rotate-2">
                                <img src="{{ $user->detail->avatar_url }}" class="w-full h-full object-cover" alt="avatar">
                            </div>
                            <div class="absolute -inset-4 bg-gradient-to-tr from-sky-500/20 to-indigo-500/20 rounded-[4.5rem] blur-2xl -z-10 group-hover:opacity-100 transition-opacity"></div>
                            <div class="absolute bottom-3 right-3 w-14 h-14 bg-emerald-500 border-4 border-white rounded-2xl flex items-center justify-center text-white shadow-xl">
                                <i class="ri-shield-user-fill text-2xl"></i>
                            </div>
                        </div>

                        <h3 class="text-3xl font-black text-slate-900 tracking-tighter mb-2">{{ $user->detail->full_name }}</h3>
                        <p class="text-[10px] font-black text-sky-600 uppercase tracking-[0.4em] mb-10">@<span>{{ $user->username }}</span> | {{ strtoupper($user->role) }}</p>
                        
                        <div class="space-y-4 py-8 border-y border-slate-100/80 mb-10">
                            <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-[0.2em]">
                                <span class="text-slate-400">Status Portal</span>
                                <span class="text-emerald-500 bg-emerald-50 px-3 py-1.5 rounded-xl border border-emerald-100 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Operasional
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-[0.2em]">
                                <span class="text-slate-400">Metode Otentikasi</span>
                                <span class="text-indigo-500 bg-indigo-50 px-3 py-1.5 rounded-xl border border-indigo-100">MFA Aktif</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-left">
                            <div class="p-5 bg-slate-50/50 rounded-3xl border border-slate-100 shadow-sm">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Akses Terakhir</p>
                                <p class="text-[11px] font-black text-slate-800">{{ $user->last_login_at ? $user->last_login_at->format('d M, H:i') : 'N/A' }}</p>
                            </div>
                            <div class="p-5 bg-slate-50/50 rounded-3xl border border-slate-100 shadow-sm">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Tingkat Keamanan</p>
                                <p class="text-[11px] font-black text-slate-800 text-indigo-600">Level 4</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings Form -->
            <div class="lg:col-span-8" data-aos="fade-left">
                <div class="glossy-card rounded-[3.5rem] p-10 lg:p-14 border border-white shadow-2xl relative overflow-hidden">
                    <div class="flex items-center gap-5 mb-14">
                        <div class="w-14 h-14 bg-slate-900 rounded-[1.5rem] flex items-center justify-center text-white shadow-xl shadow-slate-900/20">
                            <i class="ri-equalizer-fill text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="text-2xl font-black text-slate-900 uppercase tracking-tighter">Konsol Modulasi</h4>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-1">Tulis Ulang Detail Personel</p>
                        </div>
                    </div>

                    @if(session('success'))
                    <div class="mb-12 p-6 bg-emerald-500/10 border border-emerald-500/20 rounded-[2rem] flex items-center gap-5 text-emerald-600 animate-fade-in shadow-sm">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/20">
                            <i class="ri-checkbox-circle-fill text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.15em]">Sinkronisasi Berhasil</p>
                            <p class="text-[10px] font-bold opacity-80 mt-1 uppercase tracking-widest">{{ session('success') }}</p>
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-12">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-12">
                            <!-- Field Item -->
                            <div class="space-y-4 group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2 group-focus-within:text-sky-600 transition-colors">Handle Operatif</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-7 flex items-center pointer-events-none">
                                        <i class="ri-at-fill text-slate-400 group-focus-within:text-sky-500 transition-colors"></i>
                                    </div>
                                    <input type="text" name="username" value="{{ $user->username }}" required
                                           class="w-full bg-slate-50/80 border border-slate-200 rounded-[2rem] py-6 pl-16 pr-8 focus:outline-none focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 transition-all font-mono text-sm text-slate-700 shadow-sm">
                                </div>
                                @error('username') <p class="text-rose-500 text-[9px] font-black mt-1 uppercase tracking-widest ml-2">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-4 group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2 group-focus-within:text-sky-600 transition-colors">Email Terenkripsi</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-7 flex items-center pointer-events-none">
                                        <i class="ri-mail-star-fill text-slate-400 group-focus-within:text-sky-500 transition-colors"></i>
                                    </div>
                                    <input type="email" name="email" value="{{ $user->email }}" required
                                           class="w-full bg-slate-50/80 border border-slate-200 rounded-[2rem] py-6 pl-16 pr-8 focus:outline-none focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 transition-all font-mono text-sm text-slate-700 shadow-sm">
                                </div>
                                @error('email') <p class="text-rose-500 text-[9px] font-black mt-1 uppercase tracking-widest ml-2">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-4 group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2 group-focus-within:text-sky-600 transition-colors">Nama Lengkap Personel</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-7 flex items-center pointer-events-none">
                                        <i class="ri-user-star-fill text-slate-400 group-focus-within:text-sky-500 transition-colors"></i>
                                    </div>
                                    <input type="text" name="full_name" value="{{ $user->detail->full_name }}" required
                                           class="w-full bg-slate-50/80 border border-slate-200 rounded-[2rem] py-6 pl-16 pr-8 focus:outline-none focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 transition-all text-sm font-black text-slate-800 shadow-sm">
                                </div>
                                @error('full_name') <p class="text-rose-500 text-[9px] font-black mt-1 uppercase tracking-widest ml-2">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-4 group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2 group-focus-within:text-sky-600 transition-colors">Frekuensi Uplink (Telepon)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-7 flex items-center pointer-events-none">
                                        <i class="ri-smartphone-fill text-slate-400 group-focus-within:text-sky-500 transition-colors"></i>
                                    </div>
                                    <input type="text" name="phone_number" value="{{ $user->detail->phone_number }}"
                                           class="w-full bg-slate-50/80 border border-slate-200 rounded-[2rem] py-6 pl-16 pr-8 focus:outline-none focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 transition-all font-mono text-sm text-slate-700 shadow-sm">
                                </div>
                            </div>
                        </div>

                        <div class="pt-10 space-y-5">
                            <label class="block text-[10px] font-black text-slate-700 uppercase tracking-[0.2em] ml-2">Visual Identitas (Avatar)</label>
                            <label class="group relative flex items-center justify-center w-full h-40 border-2 border-dashed border-slate-200 rounded-[2.5rem] bg-slate-50/50 hover:bg-sky-50/50 hover:border-sky-300 transition-all cursor-pointer overflow-hidden shadow-inner">
                                <div class="text-center relative z-10">
                                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-300 group-hover:text-sky-500 group-hover:scale-110 transition-all mx-auto shadow-sm">
                                        <i class="ri-cloud-upload-fill text-2xl"></i>
                                    </div>
                                    <p class="text-[10px] font-black text-slate-400 mt-4 uppercase tracking-[0.2em] group-hover:text-sky-700 transition-colors">Tarik untuk unggah representasi holografik</p>
                                </div>
                                <input type="file" name="avatar" class="hidden">
                            </label>
                        </div>

                        <div class="pt-12 flex justify-end">
                            <button type="submit" 
                                    class="w-full sm:w-auto px-20 py-6 bg-slate-900 hover:bg-sky-600 text-white rounded-[2rem] font-black text-xs uppercase tracking-[0.4em] transition-all shadow-2xl shadow-slate-900/20 active:scale-95 flex items-center justify-center gap-5 group">
                                Tulis Ulang Rekaman
                                <i class="ri-save-3-fill text-xl group-hover:animate-bounce"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
