<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TugasKu - Sistem Manajemen Tugas Sekolah</title>
    
    <!-- Google Fonts: Instrument Sans & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Instrument+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS v4 Browser CDN (Zero installation required) -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Instrument Sans', sans-serif;
            background-color: #080c14;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #0d1527;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #334155;
        }
    </style>
</head>
<body class="h-full text-slate-100 flex flex-col md:flex-row overflow-hidden antialiased">

    <!-- SIDEBAR -->
    <aside class="w-full md:w-80 bg-[#0c1322] border-r border-slate-800/60 flex flex-col flex-shrink-0">
        <!-- Brand Header -->
        <div class="p-6 border-b border-slate-800/60 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2.5 bg-gradient-to-tr from-violet-600 to-indigo-600 rounded-xl shadow-lg shadow-indigo-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-xl font-extrabold bg-gradient-to-r from-white via-slate-200 to-indigo-400 bg-clip-text text-transparent">TugasKu</span>
                    <span class="block text-xs text-slate-500 font-medium">Manajemen Tugas Sekolah</span>
                </div>
            </div>
            <span class="px-2.5 py-0.5 text-[10px] font-bold text-indigo-400 bg-indigo-500/10 border border-indigo-500/20 rounded-full uppercase tracking-wider">Laravel 13</span>
        </div>

        <!-- Stats Section -->
        <div class="p-6 border-b border-slate-800/60">
            <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Statistik Tugas</h3>
            <div class="grid grid-cols-2 gap-3">
                <div class="p-3 bg-slate-900/60 border border-slate-800/60 rounded-xl">
                    <span class="block text-xs text-slate-500 font-medium">Total Tugas</span>
                    <span class="text-2xl font-bold text-slate-200">{{ $stats['total'] }}</span>
                </div>
                <div class="p-3 bg-emerald-500/5 border border-emerald-500/10 rounded-xl">
                    <span class="block text-xs text-emerald-500/60 font-medium">Selesai</span>
                    <span class="text-2xl font-bold text-emerald-400">{{ $stats['selesai'] }}</span>
                </div>
                <div class="p-3 bg-amber-500/5 border border-amber-500/10 rounded-xl">
                    <span class="block text-xs text-amber-500/60 font-medium">Sedang Aktif</span>
                    <span class="text-2xl font-bold text-amber-400">{{ $stats['belum_mulai'] + $stats['sedang_dikerjakan'] }}</span>
                </div>
                <div class="p-3 bg-rose-500/5 border border-rose-500/10 rounded-xl">
                    <span class="block text-xs text-rose-500/60 font-medium">Terlambat</span>
                    <span class="text-2xl font-bold text-rose-400">{{ $stats['terlambat'] }}</span>
                </div>
            </div>
        </div>

        <!-- Upcoming Reminders Panel -->
        <div class="p-6 flex-1 overflow-y-auto">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pengingat Terdekat</h3>
                @if($stats['mendesak'] > 0)
                    <span class="flex h-2.5 w-2.5 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-500"></span>
                    </span>
                @endif
            </div>

            <div class="space-y-3">
                @forelse($reminders as $rem)
                    <div class="p-3.5 bg-slate-900/40 hover:bg-slate-900/70 border border-slate-800/40 rounded-xl transition-all">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-[11px] font-bold px-2 py-0.5 rounded-full {{ $rem->priority === 'tinggi' ? 'bg-rose-500/10 text-rose-400 border border-rose-500/20' : ($rem->priority === 'sedang' ? 'bg-amber-500/10 text-amber-400' : 'bg-slate-800 text-slate-400') }}">
                                {{ ucfirst($rem->priority) }}
                            </span>
                            <span class="text-[10px] text-slate-400 font-medium">
                                {{ $rem->subject }}
                            </span>
                        </div>
                        <h4 class="text-xs font-semibold text-slate-200 line-clamp-1 mb-2">{{ $rem->title }}</h4>
                        
                        <!-- Time badge -->
                        <div class="inline-flex items-center space-x-1.5 text-[10px] font-bold px-2 py-0.5 rounded-md {{ $rem->due_status['color'] }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $rem->due_status['text'] }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 border border-dashed border-slate-800/60 rounded-xl">
                        <svg class="w-8 h-8 text-slate-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-xs text-slate-500">Tidak ada tugas mendesak.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <main class="flex-1 flex flex-col overflow-hidden bg-[#070b13]">
        <!-- TOP HEADER -->
        <header class="h-20 bg-[#0c1322]/80 backdrop-blur-md border-b border-slate-800/60 px-8 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-lg font-bold text-slate-100 flex items-center space-x-2">
                    <span>Selamat Datang</span>
                    <span class="inline-block text-xl">👋</span>
                </h1>
                <p class="text-xs text-slate-500 mt-0.5" id="current-date-el">Selasa, 19 Mei 2026</p>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center space-x-3">
                @if(file_exists(public_path('reports/laporan_tugas_global.html')))
                    <a href="{{ asset('reports/laporan_tugas_global.html') }}" target="_blank" title="Unduh Laporan PDF" class="px-4 py-2 bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 text-xs font-bold rounded-xl shadow-lg transition-all flex items-center space-x-2">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        <span class="hidden sm:inline">Unduh Laporan PDF</span>
                    </a>
                @endif

                <a href="{{ route('tasks.report') }}" title="Generate Laporan PDF secara asinkron" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 border border-slate-700/60 text-slate-200 text-xs font-bold rounded-xl shadow-lg transition-all flex items-center space-x-2">
                    <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="hidden sm:inline">Download PDF</span>
                </a>

                <button onclick="openModal('add-task-modal')" class="px-4 py-2 bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-500 hover:to-indigo-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-indigo-600/20 transition-all flex items-center space-x-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Tugas Baru</span>
                </button>
            </div>
        </header>

        <!-- DASHBOARD CONTAINER -->
        <div class="flex-1 overflow-y-auto p-8 space-y-6">
            
            <!-- Success Toast Notification -->
            @if(session('success'))
                <div id="toast-success" class="flex items-center justify-between p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-xs font-semibold animate-fade-in-down transition-all duration-300">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="document.getElementById('toast-success').style.display='none'" class="text-emerald-400 hover:text-white transition-colors cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif

            <!-- FILTER BAR -->
            <form action="{{ route('tasks.index') }}" method="GET" class="bg-[#0c1322]/40 border border-slate-800/40 p-4 rounded-2xl flex flex-col lg:flex-row gap-4 items-center">
                <!-- Search -->
                <div class="relative w-full lg:w-72">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul tugas..." class="w-full bg-[#080d17] border border-slate-800/80 rounded-xl pl-10 pr-4 py-2 text-xs text-slate-200 placeholder-slate-500 focus:outline-none focus:border-indigo-500 transition-colors">
                </div>

                <!-- Filters & Sorting Grid -->
                <div class="w-full flex-1 grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <!-- Status Filter -->
                    <div class="flex flex-col">
                        <select name="status" class="bg-[#080d17] border border-slate-800/80 rounded-xl px-3 py-2 text-xs text-slate-300 focus:outline-none focus:border-indigo-500 cursor-pointer">
                            <option value="semua">Semua Status</option>
                            <option value="belum_mulai" {{ request('status') === 'belum_mulai' ? 'selected' : '' }}>Belum Mulai</option>
                            <option value="sedang_dikerjakan" {{ request('status') === 'sedang_dikerjakan' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                            <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <!-- Priority Filter -->
                    <div class="flex flex-col">
                        <select name="priority" class="bg-[#080d17] border border-slate-800/80 rounded-xl px-3 py-2 text-xs text-slate-300 focus:outline-none focus:border-indigo-500 cursor-pointer">
                            <option value="semua">Semua Prioritas</option>
                            <option value="rendah" {{ request('priority') === 'rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="sedang" {{ request('priority') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="tinggi" {{ request('priority') === 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                    </div>

                    <!-- Subject Filter -->
                    <div class="flex flex-col">
                        <select name="subject" class="bg-[#080d17] border border-slate-800/80 rounded-xl px-3 py-2 text-xs text-slate-300 focus:outline-none focus:border-indigo-500 cursor-pointer">
                            <option value="semua">Semua Mapel</option>
                            @foreach($subjects as $subj)
                                <option value="{{ $subj }}" {{ request('subject') === $subj ? 'selected' : '' }}>{{ $subj }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort -->
                    <div class="flex flex-col">
                        <select name="sort" class="bg-[#080d17] border border-slate-800/80 rounded-xl px-3 py-2 text-xs text-slate-300 focus:outline-none focus:border-indigo-500 cursor-pointer">
                            <option value="deadline_dekat" {{ request('sort') === 'deadline_dekat' ? 'selected' : '' }}>Deadline Terdekat</option>
                            <option value="deadline_lama" {{ request('sort') === 'deadline_lama' ? 'selected' : '' }}>Deadline Terlama</option>
                            <option value="prioritas_tinggi" {{ request('sort') === 'prioritas_tinggi' ? 'selected' : '' }}>Prioritas Tertinggi</option>
                            <option value="terbaru" {{ request('sort') === 'terbaru' ? 'selected' : '' }}>Terbaru Dibuat</option>
                        </select>
                    </div>
                </div>

                <!-- Submit and Clear buttons -->
                <div class="flex items-center gap-2 w-full lg:w-auto">
                    <button type="submit" class="flex-1 lg:flex-initial px-4 py-2 bg-slate-800 hover:bg-slate-700 border border-slate-700/60 text-slate-200 text-xs font-bold rounded-xl transition-all cursor-pointer">
                        Filter
                    </button>
                    @if(request()->anyFilled(['search', 'status', 'priority', 'subject', 'sort']))
                        <a href="{{ route('tasks.index') }}" class="flex-1 lg:flex-initial text-center px-4 py-2 bg-slate-900/60 hover:bg-slate-800 border border-slate-800 text-slate-400 hover:text-slate-200 text-xs font-bold rounded-xl transition-all">
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <!-- TASKS GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($tasks as $task)
                    <!-- Task Card -->
                    <div class="group bg-[#0c1322]/40 hover:bg-[#0c1322]/80 border border-slate-800/60 hover:border-indigo-500/40 rounded-2xl p-6 transition-all duration-300 flex flex-col relative shadow-md hover:shadow-indigo-500/5">
                        
                        <!-- Header badge elements -->
                        <div class="flex items-center justify-between mb-4">
                            <!-- Subject -->
                            <span class="px-3 py-1 text-[11px] font-bold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-full">
                                {{ $task->subject }}
                            </span>
                            
                            <!-- Priority badge -->
                            <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-md {{ $task->priority === 'tinggi' ? 'bg-rose-500/10 text-rose-400 border border-rose-500/20' : ($task->priority === 'sedang' ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' : 'bg-blue-500/10 text-blue-400 border border-blue-500/20') }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>

                        <!-- Title & Description -->
                        <div class="flex-1 mb-6">
                            <h3 class="text-base font-bold text-slate-200 group-hover:text-white transition-colors line-clamp-1 mb-2">
                                {{ $task->title }}
                            </h3>
                            <p class="text-xs text-slate-400 line-clamp-3 leading-relaxed">
                                {{ $task->description ?? 'Tidak ada deskripsi.' }}
                            </p>
                        </div>

                        <!-- Footer details: Deadline Status -->
                        <div class="border-t border-slate-800/60 pt-4 mt-auto space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Deadline</span>
                                    <span class="text-xs text-slate-300 font-medium mt-0.5">
                                        {{ $task->deadline->translatedFormat('d M Y - H:i') }} WIB
                                    </span>
                                </div>
                                
                                <!-- Deadline status pill with countdown indicator -->
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg {{ $task->due_status['color'] }}">
                                    {{ $task->due_status['text'] }}
                                </span>
                            </div>

                            <!-- Actions bar -->
                            <div class="flex flex-col gap-3 pt-1">
                                <!-- Download Report Button (Only if completed) -->
                                @if($task->status === 'selesai')
                                    <a href="{{ route('tasks.certificate', $task) }}" target="_blank" class="w-full text-center py-2 bg-indigo-500/10 hover:bg-indigo-500/20 border border-indigo-500/30 text-indigo-400 text-[11px] font-bold rounded-lg transition-colors flex items-center justify-center space-x-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <span>Lihat Sertifikat (PDF)</span>
                                    </a>
                                @endif

                                <div class="flex items-center justify-between w-full">
                                    <!-- Quick Status Switch Action -->
                                <form action="{{ route('tasks.status', $task) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" title="Klik untuk ubah status secara cepat" class="px-3.5 py-2 rounded-xl text-xs font-semibold flex items-center space-x-2 transition-all cursor-pointer {{ $task->status === 'selesai' ? 'bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 border border-emerald-500/20' : ($task->status === 'sedang_dikerjakan' ? 'bg-amber-500/10 text-amber-400 hover:bg-amber-500/20 border border-amber-500/20' : 'bg-slate-800/80 text-slate-300 hover:bg-slate-700/80 border border-slate-700/50') }}">
                                        <span class="h-2 w-2 rounded-full {{ $task->status === 'selesai' ? 'bg-emerald-400' : ($task->status === 'sedang_dikerjakan' ? 'bg-amber-400' : 'bg-slate-400') }}"></span>
                                        <span>
                                            {{ $task->status === 'selesai' ? 'Selesai' : ($task->status === 'sedang_dikerjakan' ? 'Pengerjaan' : 'Belum Mulai') }}
                                        </span>
                                    </button>
                                </form>

                                <!-- Edit & Delete buttons -->
                                <div class="flex items-center space-x-2">
                                    <!-- Edit Button -->
                                    <button onclick="openEditModal({{ json_encode($task) }})" title="Edit tugas" class="p-2 bg-slate-800 hover:bg-indigo-600 border border-slate-700/60 hover:border-indigo-500 text-slate-300 hover:text-white rounded-lg transition-all cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus tugas" class="p-2 bg-slate-900/60 hover:bg-rose-600 border border-slate-800 hover:border-rose-500 text-slate-400 hover:text-white rounded-lg transition-all cursor-pointer">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div> <!-- Closing for inner div flex items-center -->
                            </div> <!-- Closing for outer div flex-col -->
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="col-span-full py-16 flex flex-col items-center justify-center border border-dashed border-slate-800/60 rounded-3xl bg-[#0c1322]/10">
                        <div class="p-4 bg-slate-900/80 rounded-2xl border border-slate-800 mb-4">
                            <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-300">Belum Ada Tugas Sekolah</h3>
                        <p class="text-xs text-slate-500 mt-1 max-w-sm text-center px-4 leading-relaxed">Daftar tugas kosong. Silakan tambahkan tugas sekolah baru menggunakan tombol "+ Tambah Tugas" di pojok kanan atas.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    <!-- ================= MODALS ================= -->

    <!-- 1. ADD TASK MODAL -->
    <div id="add-task-modal" class="fixed inset-0 z-50 hidden bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-[#0c1322] border border-slate-800/80 w-full max-w-lg rounded-2xl overflow-hidden shadow-2xl animate-scale-up">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-800/60 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-100 flex items-center space-x-2">
                    <span class="p-1.5 bg-indigo-500/10 text-indigo-400 rounded-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </span>
                    <span>Tambah Tugas Baru</span>
                </h3>
                <button onclick="closeModal('add-task-modal')" class="text-slate-400 hover:text-white transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('tasks.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                
                <!-- Judul -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Judul Tugas</label>
                    <input type="text" name="title" required placeholder="Contoh: Latihan Soal Turunan" class="w-full bg-[#080d17] border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-200 placeholder-slate-600 focus:outline-none focus:border-indigo-500">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" rows="3" placeholder="Tulis instruksi pengerjaan..." class="w-full bg-[#080d17] border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-200 placeholder-slate-600 focus:outline-none focus:border-indigo-500"></textarea>
                </div>

                <!-- Grid Mapel & Deadline -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Mapel -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Mata Pelajaran</label>
                        <input type="text" name="subject" required list="default-subjects" placeholder="Contoh: Matematika" class="w-full bg-[#080d17] border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-200 placeholder-slate-600 focus:outline-none focus:border-indigo-500">
                        <datalist id="default-subjects">
                            <option value="Matematika">
                            <option value="Fisika">
                            <option value="Kimia">
                            <option value="Biologi">
                            <option value="Bahasa Indonesia">
                            <option value="Bahasa Inggris">
                            <option value="Informatika">
                            <option value="Sejarah">
                        </datalist>
                    </div>

                    <!-- Deadline -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Deadline</label>
                        <input type="datetime-local" name="deadline" required class="w-full bg-[#080d17] border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-200 focus:outline-none focus:border-indigo-500">
                    </div>
                </div>

                <!-- Grid Prioritas & Status -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Prioritas -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Prioritas</label>
                        <select name="priority" required class="w-full bg-[#080d17] border border-slate-800 rounded-xl px-3 py-2.5 text-xs text-slate-300 focus:outline-none focus:border-indigo-500 cursor-pointer">
                            <option value="rendah">Rendah</option>
                            <option value="sedang" selected>Sedang</option>
                            <option value="tinggi">Tinggi</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Status Awal</label>
                        <select name="status" required class="w-full bg-[#080d17] border border-slate-800 rounded-xl px-3 py-2.5 text-xs text-slate-300 focus:outline-none focus:border-indigo-500 cursor-pointer">
                            <option value="belum_mulai" selected>Belum Mulai</option>
                            <option value="sedang_dikerjakan">Sedang Dikerjakan</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-slate-800/60 mt-4">
                    <button type="button" onclick="closeModal('add-task-modal')" class="px-4 py-2 bg-slate-900 border border-slate-800 hover:bg-slate-800 text-slate-400 hover:text-slate-200 text-xs font-bold rounded-xl transition-all cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-500 hover:to-indigo-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-indigo-600/20 transition-all cursor-pointer">
                        Simpan Tugas
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. EDIT TASK MODAL -->
    <div id="edit-task-modal" class="fixed inset-0 z-50 hidden bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-[#0c1322] border border-slate-800/80 w-full max-w-lg rounded-2xl overflow-hidden shadow-2xl animate-scale-up">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-800/60 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-100 flex items-center space-x-2">
                    <span class="p-1.5 bg-indigo-500/10 text-indigo-400 rounded-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </span>
                    <span>Edit Detail Tugas</span>
                </h3>
                <button onclick="closeModal('edit-task-modal')" class="text-slate-400 hover:text-white transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Form -->
            <form id="edit-task-form" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                
                <!-- Judul -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Judul Tugas</label>
                    <input type="text" id="edit-title" name="title" required placeholder="Contoh: Latihan Soal Turunan" class="w-full bg-[#080d17] border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-200 placeholder-slate-600 focus:outline-none focus:border-indigo-500">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi (Opsional)</label>
                    <textarea id="edit-description" name="description" rows="3" placeholder="Tulis instruksi pengerjaan..." class="w-full bg-[#080d17] border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-200 placeholder-slate-600 focus:outline-none focus:border-indigo-500"></textarea>
                </div>

                <!-- Grid Mapel & Deadline -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Mapel -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Mata Pelajaran</label>
                        <input type="text" id="edit-subject" name="subject" required list="default-subjects" placeholder="Contoh: Matematika" class="w-full bg-[#080d17] border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-200 placeholder-slate-600 focus:outline-none focus:border-indigo-500">
                    </div>

                    <!-- Deadline -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Deadline</label>
                        <input type="datetime-local" id="edit-deadline" name="deadline" required class="w-full bg-[#080d17] border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-200 focus:outline-none focus:border-indigo-500">
                    </div>
                </div>

                <!-- Grid Prioritas & Status -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Prioritas -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Prioritas</label>
                        <select id="edit-priority" name="priority" required class="w-full bg-[#080d17] border border-slate-800 rounded-xl px-3 py-2.5 text-xs text-slate-300 focus:outline-none focus:border-indigo-500 cursor-pointer">
                            <option value="rendah">Rendah</option>
                            <option value="sedang">Sedang</option>
                            <option value="tinggi">Tinggi</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Status</label>
                        <select id="edit-status" name="status" required class="w-full bg-[#080d17] border border-slate-800 rounded-xl px-3 py-2.5 text-xs text-slate-300 focus:outline-none focus:border-indigo-500 cursor-pointer">
                            <option value="belum_mulai">Belum Mulai</option>
                            <option value="sedang_dikerjakan">Sedang Dikerjakan</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-slate-800/60 mt-4">
                    <button type="button" onclick="closeModal('edit-task-modal')" class="px-4 py-2 bg-slate-900 border border-slate-800 hover:bg-slate-800 text-slate-400 hover:text-slate-200 text-xs font-bold rounded-xl transition-all cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-500 hover:to-indigo-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-indigo-600/20 transition-all cursor-pointer">
                        Perbarui Tugas
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Interactive script to handle modal opening and filling -->
    <script>
        // Set dynamic date in header
        function updateHeaderDate() {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const today  = new Date();
            const dateStr = today.toLocaleDateString('id-ID', options);
            const dateEl = document.getElementById('current-date-el');
            if (dateEl) {
                dateEl.textContent = dateStr;
            }
        }

        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        }

        function openEditModal(task) {
            // Populate form actions
            const form = document.getElementById('edit-task-form');
            form.action = `/tasks/${task.id}`;

            // Populate form values
            document.getElementById('edit-title').value = task.title;
            document.getElementById('edit-description').value = task.description || '';
            document.getElementById('edit-subject').value = task.subject;
            
            // Format datetime local correctly (YYYY-MM-DDTHH:MM)
            if (task.deadline) {
                const date = new Date(task.deadline);
                // Adjusting time zone offset to get correct local time ISO string
                const tzOffset = date.getTimezoneOffset() * 60000;
                const localISOTime = (new Date(date - tzOffset)).toISOString().slice(0, 16);
                document.getElementById('edit-deadline').value = localISOTime;
            }
            
            document.getElementById('edit-priority').value = task.priority;
            document.getElementById('edit-status').value = task.status;

            openModal('edit-task-modal');
        }

        // Close modal when clicking outside modal box
        window.addEventListener('click', function(e) {
            const addModal = document.getElementById('add-task-modal');
            const editModal = document.getElementById('edit-task-modal');
            if (e.target === addModal) {
                closeModal('add-task-modal');
            }
            if (e.target === editModal) {
                closeModal('edit-task-modal');
            }
        });

        // Initialize dynamic date
        document.addEventListener('DOMContentLoaded', function() {
            updateHeaderDate();
        });
    </script>
    <!-- ================= AI CHAT ASSISTANT ================= -->
    
    <!-- Floating Button -->
    <button onclick="toggleAiChat()" class="fixed bottom-6 right-8 p-4 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full shadow-2xl hover:scale-105 transition-transform z-40 flex items-center justify-center group border border-indigo-400/30">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
        </svg>
        <span class="absolute -top-10 right-0 bg-slate-800 text-xs text-white px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">Tanya AI Assistant</span>
    </button>

    <!-- Chat Panel -->
    <div id="ai-chat-panel" class="fixed bottom-24 right-8 w-80 bg-[#0c1322] border border-slate-700/80 rounded-2xl shadow-2xl flex flex-col z-50 overflow-hidden transform scale-0 origin-bottom-right transition-transform duration-300">
        <div class="p-4 border-b border-slate-700/80 bg-gradient-to-r from-indigo-900/40 to-purple-900/40 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                <h3 class="text-xs font-bold text-slate-200">AI Task Assistant</h3>
            </div>
            <button onclick="toggleAiChat()" class="text-slate-400 hover:text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <div class="flex-1 p-4 overflow-y-auto max-h-64 flex flex-col space-y-3 text-xs bg-[#080d17]/50" id="chat-messages">
            <!-- Initial Message -->
            <div class="flex self-start max-w-[85%] bg-slate-800/80 p-2.5 rounded-xl rounded-tl-sm border border-slate-700/50">
                <p class="text-slate-300">Halo! Ada yang bisa saya bantu terkait prioritas atau jadwal tugas sekolah Anda?</p>
            </div>
            
            @if(session('ai_user_message'))
                <div class="flex self-end max-w-[85%] bg-indigo-600/80 p-2.5 rounded-xl rounded-tr-sm">
                    <p class="text-white">{{ session('ai_user_message') }}</p>
                </div>
            @endif
            
            @if(session('ai_reply'))
                <div class="flex self-start max-w-[85%] bg-slate-800/80 p-2.5 rounded-xl rounded-tl-sm border border-slate-700/50">
                    <p class="text-slate-300">{{ session('ai_reply') }}</p>
                </div>
                <!-- Auto-open chat if there's a reply -->
                <script>document.addEventListener("DOMContentLoaded", () => toggleAiChat(true));</script>
            @endif
        </div>

        <form action="{{ route('ai.webChat') }}" method="POST" class="p-3 bg-[#0c1322] border-t border-slate-700/80 flex items-center space-x-2">
            @csrf
            <input type="text" name="message" required placeholder="Ketik pesan ke AI..." class="flex-1 bg-[#080d17] border border-slate-700 rounded-lg px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-indigo-500">
            <button type="submit" class="p-2 bg-indigo-600 hover:bg-indigo-500 rounded-lg text-white transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"></path></svg>
            </button>
        </form>
    </div>

    <script>
        function toggleAiChat(forceOpen = false) {
            const panel = document.getElementById('ai-chat-panel');
            if (forceOpen || panel.classList.contains('scale-0')) {
                panel.classList.remove('scale-0');
                panel.classList.add('scale-100');
            } else {
                panel.classList.remove('scale-100');
                panel.classList.add('scale-0');
            }
        }
    </script>
</body>
</html>
