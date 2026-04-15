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
            background: url('https://eaut.edu.vn/wp-content/uploads/2021/04/campus-eaut.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .bg-eaut-blue { background-color: #003366; }
    </style>
</head>
<body class="antialiased flex items-center justify-center min-h-screen p-4">
    <div class="glass w-full max-w-[450px] p-10 rounded-[3rem] shadow-2xl animate-fadeIn">
        <div class="text-center mb-8">
            <img src="https://tse1.mm.bing.net/th/id/OIP.aMjoaVqeMWDwAbijsTRpOAHaHa?pid=Api&P=0&h=220" alt="Logo EAUT" class="h-24 mx-auto drop-shadow-lg mb-4">
            <h1 class="text-2xl font-black text-[#003366] uppercase italic tracking-tighter">Đăng Nhập Portal</h1>
            <div class="h-1 w-12 bg-[#003366] mx-auto mt-2 rounded-full"></div>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div class="space-y-1">
                <label class="text-[10px] font-black text-slate-500 uppercase ml-4 tracking-widest italic">Tài khoản Email</label>
                <div class="relative">
                    <i class="fa-solid fa-envelope absolute left-5 top-4 text-slate-400 text-sm"></i>
                    <input type="email" name="email" required autofocus class="w-full bg-white/50 border-none rounded-2xl py-4 pl-12 pr-6 text-sm font-bold text-[#003366] focus:ring-4 focus:ring-blue-100 shadow-inner" placeholder="sv@eaut.edu.vn">
                </div>
                @error('email') <p class="text-[10px] text-red-500 font-bold ml-4 mt-1 italic">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-black text-slate-500 uppercase ml-4 tracking-widest italic">Mật khẩu</label>
                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-5 top-4 text-slate-400 text-sm"></i>
                    <input type="password" name="password" required class="w-full bg-white/50 border-none rounded-2xl py-4 pl-12 pr-6 text-sm font-bold text-[#003366] focus:ring-4 focus:ring-blue-100 shadow-inner" placeholder="••••••••">
                </div>
                @error('password') <p class="text-[10px] text-red-500 font-bold ml-4 mt-1 italic">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-between px-2">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-[#003366] focus:ring-[#003366]">
                    <span class="text-[10px] font-black text-slate-500 uppercase italic group-hover:text-[#003366]">Ghi nhớ</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[10px] font-black text-[#003366] uppercase italic hover:underline">Quên mật khẩu?</a>
                @endif
            </div>

            <button type="submit" class="w-full bg-[#003366] text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-900/20 hover:bg-slate-800 transition-all uppercase text-[11px] tracking-[0.3em] italic hover:-translate-y-1">
                Vào Hệ Thống
            </button>

            <p class="text-center text-[10px] font-black text-slate-400 uppercase italic mt-6">
                Chưa có tài khoản? 
                <a href="{{ route('register') }}" class="text-[#003366] hover:underline ml-1">Đăng ký ngay</a>
            </p>
        </form>
    </div>

    <style>
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fadeIn { animation: fadeIn 0.8s ease-out forwards; }
    </style>
</body>
</html>