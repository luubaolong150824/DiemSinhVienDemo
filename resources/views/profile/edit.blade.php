<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-8 animate-fadeIn">
        <div class="flex items-center gap-4 bg-white p-8 rounded-[2.5rem] shadow-sm border-l-8 border-[#003366]">
            <div class="h-16 w-16 bg-slate-100 rounded-3xl flex items-center justify-center text-[#003366] text-3xl shadow-inner">
                <i class="fa-solid fa-id-card-clip"></i>
            </div>
            <div>
                <h2 class="text-3xl font-black text-[#003366] uppercase italic tracking-tighter">Hồ Sơ Cá Nhân</h2>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] mt-1 italic">Quản lý thông tin định danh & Bảo mật hệ thống EAUT</p>
            </div>
        </div>

        @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
            <div class="bg-emerald-500 text-white p-5 rounded-[2rem] shadow-lg flex items-center gap-4 animate-bounce">
                <i class="fa-solid fa-circle-check text-2xl"></i>
                <span class="font-black uppercase text-xs tracking-widest">Hệ thống đã cập nhật dữ liệu mới thành công!</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="space-y-6">
                <div class="bg-[#003366] p-8 rounded-[3rem] shadow-2xl text-white relative overflow-hidden group">
                    <div class="relative z-10 text-center">
                        <div class="h-32 w-32 bg-white rounded-[2.5rem] mx-auto mb-6 flex items-center justify-center text-[#003366] text-5xl font-black italic shadow-2xl border-4 border-white/20 transform group-hover:rotate-6 transition-transform">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h3 class="text-xl font-black uppercase italic tracking-tighter">{{ Auth::user()->name }}</h3>
                        <p class="text-[10px] font-bold text-white/50 uppercase tracking-[0.2em] mt-2 italic">Mã số định danh: {{ Auth::user()->id + 10000 }}</p>
                        
                        <div class="mt-8 pt-8 border-t border-white/10 space-y-4 text-left">
                            <div class="flex justify-between items-center">
                                <span class="text-[9px] font-black uppercase text-white/40">Chuyên ngành</span>
                                <span class="text-xs font-bold italic">{{ Auth::user()->department ?? 'Chưa cập nhật' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[9px] font-black uppercase text-white/40">Lớp khóa</span>
                                <span class="text-xs font-bold italic">{{ Auth::user()->academic_year ?? 'Chưa cập nhật' }}</span>
                            </div>
                        </div>
                    </div>
                    <i class="fa-solid fa-fingerprint absolute -bottom-10 -left-10 text-[12rem] opacity-5 -rotate-12"></i>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-8">
                
                <div class="bg-white p-10 rounded-[3.5rem] shadow-xl border border-slate-100">
                    <div class="flex items-center gap-3 mb-8 border-b border-slate-50 pb-6">
                        <i class="fa-solid fa-user-pen text-[#003366] text-xl"></i>
                        <h3 class="text-lg font-black text-slate-800 uppercase italic tracking-tight">Cập nhật thông tin định danh</h3>
                    </div>

                    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf @method('patch')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase ml-3 tracking-widest italic">Họ và tên đầy đủ</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-[#003366] focus:ring-4 focus:ring-slate-100 transition-all shadow-inner" placeholder="Nguyễn Văn A">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase ml-3 tracking-widest italic">Địa chỉ Email</label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-[#003366] focus:ring-4 focus:ring-slate-100 transition-all shadow-inner" placeholder="sv@eaut.edu.vn">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase ml-3 tracking-widest italic">Ngày tháng năm sinh</label>
                                <input type="date" name="birthday" value="{{ Auth::user()->birthday ? \Carbon\Carbon::parse(Auth::user()->birthday)->format('Y-m-d') : '' }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-[#003366] focus:ring-4 focus:ring-slate-100 transition-all shadow-inner">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase ml-3 tracking-widest italic">Quê quán / Thường trú</label>
                                <input type="text" name="hometown" value="{{ Auth::user()->hometown }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-[#003366] focus:ring-4 focus:ring-slate-100 transition-all shadow-inner" placeholder="Ví dụ: Hà Nội">
                            </div>
                        </div>
                        <div class="flex justify-end pt-4">
                            <button type="submit" class="bg-[#003366] hover:bg-slate-800 text-white font-black py-4 px-10 rounded-2xl shadow-xl transition-all uppercase text-[10px] tracking-[0.3em] italic hover:-translate-y-1">Lưu thay đổi hồ sơ</button>
                        </div>
                    </form>
                </div>

                <div class="bg-white p-10 rounded-[3.5rem] shadow-xl border border-slate-100 relative overflow-hidden">
                    <div class="flex items-center gap-3 mb-8 border-b border-slate-50 pb-6">
                        <i class="fa-solid fa-shield-halved text-[#003366] text-xl"></i>
                        <h3 class="text-lg font-black text-slate-800 uppercase italic tracking-tight">Thiết lập mật khẩu an toàn</h3>
                    </div>

                    <form method="post" action="{{ route('profile.updatePassword') }}" class="space-y-6">
                        @csrf @method('put')
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase ml-3 tracking-widest italic">Mật khẩu hiện tại</label>
                            <input type="password" name="current_password" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-4 focus:ring-slate-100 shadow-inner" placeholder="••••••••">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase ml-3 tracking-widest italic">Mật khẩu mới</label>
                                <input type="password" name="password" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-4 focus:ring-slate-100 shadow-inner" placeholder="Ít nhất 8 ký tự">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase ml-3 tracking-widest italic">Nhập lại mật khẩu mới</label>
                                <input type="password" name="password_confirmation" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-4 focus:ring-slate-100 shadow-inner" placeholder="Xác nhận lại">
                            </div>
                        </div>
                        <div class="flex justify-end pt-4">
                            <button type="submit" class="bg-slate-800 hover:bg-black text-white font-black py-4 px-10 rounded-2xl shadow-xl transition-all uppercase text-[10px] tracking-[0.3em] italic hover:-translate-y-1">Cập nhật mật khẩu mới</button>
                        </div>
                    </form>
                    <i class="fa-solid fa-lock absolute -top-10 -right-10 text-9xl text-slate-50"></i>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn { animation: fadeIn 0.6s ease-out forwards; }
    </style>
</x-app-layout>