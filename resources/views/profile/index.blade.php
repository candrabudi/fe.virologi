@extends('layouts.app')

@section('meta_title', 'My Profile | RD-VIROLOGI')

@section('content')
<div class="py-20 lg:py-32 relative overflow-hidden">
    <!-- Decors -->
    <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-sky-100/20 to-transparent pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-1/3 h-full bg-gradient-to-r from-indigo-100/10 to-transparent pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row gap-12 items-start">
            
            <!-- Left Sidebar: Profile Summary -->
            <div class="w-full lg:w-1/3" data-aos="fade-right">
                <div class="glossy-card rounded-[2.5rem] p-8 text-center border border-white shadow-xl relative overflow-hidden group">
                    <div class="absolute top-0 inset-x-0 h-32 bg-gradient-to-br from-slate-900 via-slate-800 to-sky-900"></div>
                    
                    <div class="relative pt-12 mb-8">
                        <div class="inline-block relative">
                            <img src="{{ $user->detail->avatar_url }}" alt="{{ $user->detail->full_name }}" 
                                 class="w-32 h-32 rounded-[2rem] object-cover border-4 border-white shadow-lg relative z-10 group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute -inset-2 bg-gradient-to-tr from-sky-500 to-indigo-500 rounded-[2.2rem] blur opacity-30 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                    </div>

                    <h2 class="text-2xl font-black heading-font text-slate-900 mb-2">{{ $user->detail->full_name }}</h2>
                    <p class="text-[10px] font-bold text-sky-600 uppercase tracking-[0.3em] mb-6">@<span>{{ $user->username }}</span> | {{ ucfirst($user->role) }}</p>
                    
                    <div class="pt-8 border-t border-slate-100 space-y-4">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400 font-bold uppercase tracking-widest">Portal Access</span>
                            <span class="text-slate-900 font-bold">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400 font-bold uppercase tracking-widest">Status</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 font-bold uppercase tracking-widest text-[9px]">
                                <span class="w-1 h-1 rounded-full bg-emerald-600 mr-1.5 animate-pulse"></span>
                                {{ $user->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Settings Form -->
            <div class="w-full lg:w-2/3" data-aos="fade-left">
                <div class="glossy-card rounded-[2.5rem] p-8 lg:p-12 border border-white shadow-xl">
                    <div class="mb-12">
                        <h3 class="text-3xl font-black heading-font text-slate-900 mb-4">Core Identity.</h3>
                        <p class="text-slate-500 leading-relaxed italic text-sm">Modify your personnel records and encrypted communication channels here.</p>
                    </div>

                    @if(session('success'))
                    <div class="mb-8 p-5 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-600 text-xs font-bold uppercase tracking-widest flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                        @csrf
                        @method('PUT')

                        <!-- Identity Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Portal Handle (@)</label>
                                    <input type="text" name="username" value="{{ $user->username }}" required
                                           class="w-full px-5 py-4 rounded-xl border border-slate-200 bg-white/50 focus:outline-none focus:border-sky-500 focus:ring-4 focus:ring-sky-500/5 transition-all text-slate-900 font-medium font-mono">
                                    @error('username') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Communication Line (Email)</label>
                                    <input type="email" name="email" value="{{ $user->email }}" required
                                           class="w-full px-5 py-4 rounded-xl border border-slate-200 bg-white/50 focus:outline-none focus:border-sky-500 focus:ring-4 focus:ring-sky-500/5 transition-all text-slate-900 font-medium font-mono">
                                    @error('email') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Personnel Full Name</label>
                                    <input type="text" name="full_name" value="{{ $user->detail->full_name }}" required
                                           class="w-full px-5 py-4 rounded-xl border border-slate-200 bg-white/50 focus:outline-none focus:border-sky-500 focus:ring-4 focus:ring-sky-500/5 transition-all text-slate-900 font-medium">
                                    @error('full_name') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Secure Mobile Link</label>
                                    <input type="text" name="phone_number" value="{{ $user->detail->phone_number }}"
                                           class="w-full px-5 py-4 rounded-xl border border-slate-200 bg-white/50 focus:outline-none focus:border-sky-500 focus:ring-4 focus:ring-sky-500/5 transition-all text-slate-900 font-medium font-mono">
                                </div>
                            </div>
                        </div>

                        <!-- Avatar Section -->
                        <div class="pt-8 border-t border-slate-100">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 ml-1">Holographic Representation (Avatar)</label>
                            <div class="flex items-center space-x-6">
                                <div class="w-16 h-16 rounded-2xl overflow-hidden bg-slate-100 border-2 border-slate-200">
                                    <img src="{{ $user->detail->avatar_url }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="avatar" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-bold file:uppercase file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 transition-all">
                                    <p class="text-[9px] text-slate-400 mt-2 font-bold uppercase tracking-widest">Supports PNG, JPG (Max 2MB)</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-8 text-right">
                            <button type="submit" 
                                    class="px-10 py-5 bg-slate-900 text-white rounded-xl font-bold text-xs uppercase tracking-[0.2em] hover:bg-sky-600 transition-all shadow-xl shadow-slate-900/20 active:scale-[0.98]">
                                Update Records &rarr;
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
