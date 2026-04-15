<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EAUT - Hệ Thống Quản Lý Đào Tạo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; }
        .bg-eaut-blue { background-color: #003366; }
        .sidebar-item-active { 
            background-color: rgba(255, 255, 255, 0.1); 
            border-left: 5px solid #ffffff;
            font-weight: 900;
        }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #003366; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#F4F7F9] antialiased">
    <div class="min-h-screen flex">
        
        <div class="w-80 bg-[#003366] text-white flex-shrink-0 shadow-2xl min-h-screen flex flex-col relative z-20">
            
            <div class="p-10 text-center bg-white border-b border-slate-200">
                <div class="flex flex-col items-center gap-3">
                    <img src="https://tse1.mm.bing.net/th/id/OIP.aMjoaVqeMWDwAbijsTRpOAHaHa?pid=Api&P=0&h=220" 
                         alt="Logo EAUT" 
                         class="h-28 w-auto object-contain transform hover:scale-105 transition-transform duration-300">
                    <div class="mt-1">
                        <h1 class="text-3xl font-black text-[#003366] tracking-tighter uppercase leading-none italic">EAUT</h1>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.3em] mt-2">Hệ Thống Quản Lý Điểm</p>
                    </div>
                </div>
            </div>
            
            <nav class="mt-6 flex-1 space-y-1">
                <div class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic">Chức năng hệ thống</div>
                
                <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-8 py-4 transition-all {{ request()->routeIs('dashboard') ? 'sidebar-item-active' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-house-chimney text-lg"></i> <span>Trang Chủ</span>
                </a>

                @role('admin')
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-4 px-8 py-4 transition-all {{ request()->routeIs('admin.users.*') ? 'sidebar-item-active' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-address-card text-lg"></i> <span>Quản Lý Sinh Viên</span>
                </a>
                <a href="{{ route('admin.courses.index') }}" class="flex items-center gap-4 px-8 py-4 transition-all {{ request()->routeIs('admin.courses.*') ? 'sidebar-item-active' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-book-bookmark text-lg"></i> <span>Quản Lý Môn Học</span>
                </a>
                <a href="{{ route('admin.grades.index') }}" class="flex items-center gap-4 px-8 py-4 transition-all {{ request()->routeIs('admin.grades.*') ? 'sidebar-item-active' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-square-poll-vertical text-lg"></i> <span>Quản Lý Điểm Số</span>
                </a>
                @endrole

                @role('student')
                <a href="{{ route('student.grades') }}" class="flex items-center gap-4 px-8 py-4 transition-all {{ request()->routeIs('student.grades') ? 'sidebar-item-active' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-graduation-cap text-lg"></i> <span>Bảng Điểm Cá Nhân</span>
                </a>
                @endrole
            </nav>

            <div class="p-6 border-t border-white/10 bg-[#002244]">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-3 p-4 rounded-xl bg-red-600 hover:bg-red-700 text-white transition-all font-black uppercase text-[11px] tracking-widest shadow-lg">
                        <i class="fa-solid fa-power-off"></i> <span>Đăng Xuất Hệ Thống</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            <header class="bg-white p-6 flex justify-between items-center shadow-sm z-10 border-b border-slate-200">
                <div class="flex items-center gap-4 italic">
                    <div class="h-8 w-1 bg-[#003366] rounded-full"></div>
                    <h2 class="font-black text-[#003366] text-sm uppercase tracking-wider leading-none">Trường Đại Học Công Nghệ Đông Á</h2>
                </div>
                
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 bg-slate-50 p-2 pr-6 rounded-full border border-slate-100 hover:bg-slate-100 transition-all group shadow-sm">
                    <div class="h-10 w-10 rounded-full bg-[#003366] flex items-center justify-center text-white font-black shadow-md group-hover:scale-105 transition-transform overflow-hidden">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                        @else
                            {{ substr(Auth::user()->name, 0, 1) }}
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-black text-slate-800 uppercase leading-none group-hover:text-[#003366]">{{ Auth::user()->name }}</p>
                        <p class="text-[9px] text-slate-400 font-bold uppercase mt-1 tracking-tighter italic">Hồ sơ cá nhân</p>
                    </div>
                </a>
            </header>
            
            <main class="flex-1 overflow-y-auto p-10 bg-[#F4F7F9]">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>