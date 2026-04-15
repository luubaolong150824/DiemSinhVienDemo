<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EAUT - Đăng Nhập Hệ Thống</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(rgba(0, 51, 102, 0.7), rgba(0, 51, 102, 0.7)), 
                        url('https://eaut.edu.vn/wp-content/uploads/2021/04/campus-eaut.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(15px);
            border-radius: 4rem; /* Bo góc cực đại cho sang */
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.6);
        }
        input:focus { transform: scale(1.02); transition: all 0.2s ease; }
    </style>
</head>
<body class="p-4">

    <div class="glass-card w-full max-w-[460px] p-12 animate-fadeIn relative overflow-hidden">
        <div class="absolute -top-20 -right-20 h-40 w-40 bg-blue-50 rounded-full opacity-50"></div>

        <div class="text-center mb-12 relative z-10">
            <img src="https://tse1.mm.bing.net/th/id/OIP.aMjoaVqeMWDwAbijsTRpOAHaHa?pid=Api&P=0&h=220" 
                 alt="Logo EAUT" 
                 class="h-32 mx-auto drop-shadow-2xl mb-4">
            <h1 class="text-4xl font-black text-[#003366] uppercase italic tracking-[ -0.05em] leading-none">EAUT</h1>
            <div class="h-1.5 w-12 bg-[#003366] mx-auto mt-4 rounded-full"></div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.4em] mt-3 italic">Hệ Thống Quản Lý Đào Tạo</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6 relative z-10">
            @csrf

            <div class="space-y-2">
                <label class="text-[9px] font-black text-slate-500 uppercase ml-5 tracking-[0.2em] italic">Tài khoản truy cập</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-[#003366]">
                        <i class="fa-solid fa-user-tag text-sm"></i>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus 
                           class="w-full bg-slate-50 border-none rounded-[2rem] py-5 pl-14 pr-8 text-sm font-black text-[#003366] focus:ring-4 focus:ring-blue-100 shadow-inner transition-all" 
                           placeholder="Mã sinh viên / Email">
                </div>
                @error('email') <p class="text-[10px] text-red-500 font-bold ml-6 italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="text-[9px] font-black text-slate-500 uppercase ml-5 tracking-[0.2em] italic">Mật khẩu định danh</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-[#003366]">
                        <i class="fa-solid fa-shield-halved text-sm"></i>
                    </div>
                    <input type="password" name="password" required 
                           class="w-full bg-slate-50 border-none rounded-[2rem] py-5 pl-14 pr-8 text-sm font-black text-[#003366] focus:ring-4 focus:ring-blue-100 shadow-inner transition-all" 
                           placeholder="••••••••">
                </div>
                @error('password') <p class="text-[10px] text-red-500 font-bold ml-6 italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-between px-4">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-[#003366] focus:ring-[#003366]">
                    <span class="text-[10px] font-black text-slate-400 uppercase italic group-hover:text-[#003366] transition-colors">Duy trì đăng nhập</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-[10px] font-black text-[#003366] uppercase italic hover:underline tracking-tighter">Quên mật khẩu?</a>
            </div>

            <div class="pt-4">
                <button type="submit" 
                        class="w-full bg-[#003366] text-white font-black py-5 rounded-[2rem] shadow-2xl shadow-blue-900/40 hover:bg-slate-800 transition-all uppercase text-[11px] tracking-[0.4em] italic hover:-translate-y-1.5 active:scale-95">
                    Đăng Nhập Ngay
                </button>
            </div>

            <div class="text-center pt-6">
                <p class="text-[9px] font-black text-slate-400 uppercase italic tracking-widest">
                    Chưa có tài khoản EAUT? 
                    <a href="{{ route('register') }}" class="text-[#003366] hover:underline font-black ml-1">Đăng ký tại đây</a>
                </p>
            </div>
        </form>
    </div>

    <style>
        @keyframes fadeIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
        .animate-fadeIn { animation: fadeIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
    </style>
</body>
</html>