<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EAUT - Tạo Tài Khoản Mới</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: url('https://eaut.edu.vn/wp-content/uploads/2021/04/campus-eaut.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="antialiased flex items-center justify-center min-h-screen p-4">
    <div class="glass w-full max-w-[500px] p-10 rounded-[3.5rem] shadow-2xl animate-fadeIn">
        <div class="text-center mb-8">
            <img src="https://tse1.mm.bing.net/th/id/OIP.aMjoaVqeMWDwAbijsTRpOAHaHa?pid=Api&P=0&h=220" alt="Logo EAUT" class="h-20 mx-auto drop-shadow-lg mb-4">
            <h1 class="text-xl font-black text-[#003366] uppercase italic tracking-tighter leading-none">Đăng Ký Tài Khoản</h1>
            <p class="text-[9px] font-bold text-slate-400 uppercase mt-2 italic tracking-widest">Dành cho sinh viên khóa mới EAUT</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <div class="space-y-1">
                <label class="text-[10px] font-black text-slate-500 uppercase ml-4 italic tracking-widest">Họ và tên</label>
                <input type="text" name="name" required class="w-full bg-white/50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-[#003366] focus:ring-4 focus:ring-blue-100 shadow-inner" placeholder="Nguyễn Văn A">
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-black text-slate-500 uppercase ml-4 italic tracking-widest">Email sinh viên</label>
                <input type="email" name="email" required class="w-full bg-white/50 border-none rounded-2xl py-4 px-6 text-sm font-bold text-[#003366] focus:ring-4 focus:ring-blue-100 shadow-inner" placeholder="sv@eaut.edu.vn">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-4 italic tracking-widest">Mật khẩu</label>
                    <input type="password" name="password" required class="w-full bg-white/50 border-none rounded-2xl py-4 px-6 text-sm font-bold focus:ring-4 focus:ring-blue-100 shadow-inner" placeholder="••••••••">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-500 uppercase ml-4 italic tracking-widest">Nhập lại</label>
                    <input type="password" name="password_confirmation" required class="w-full bg-white/50 border-none rounded-2xl py-4 px-6 text-sm font-bold focus:ring-4 focus:ring-blue-100 shadow-inner" placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="w-full bg-[#003366] text-white font-black py-4 rounded-2xl shadow-xl hover:bg-slate-800 transition-all uppercase text-[11px] tracking-[0.2em] italic mt-4">
                Tạo Tài Khoản Ngay
            </button>

            <p class="text-center text-[10px] font-black text-slate-400 uppercase italic mt-6">
                Đã có tài khoản? 
                <a href="{{ route('login') }}" class="text-[#003366] hover:underline ml-1">Quay lại đăng nhập</a>
            </p>
        </form>
    </div>
</body>
</html>