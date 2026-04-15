<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-8 animate-fadeIn">
        <div class="flex items-center gap-4 bg-white p-8 rounded-[2.5rem] shadow-sm border-l-8 border-[#003366]">
            <div class="h-16 w-16 bg-slate-100 rounded-3xl flex items-center justify-center text-[#003366] text-3xl shadow-inner"><i class="fa-solid fa-id-card-clip"></i></div>
            <div>
                <h2 class="text-3xl font-black text-[#003366] uppercase italic tracking-tighter leading-none">Hồ Sơ Cá Nhân</h2>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] mt-2 italic">Cập nhật ảnh & Thông tin định danh EAUT</p>
            </div>
        </div>

        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf @method('patch')
            
            <div class="space-y-6">
                <div class="bg-[#003366] p-8 rounded-[3rem] shadow-2xl text-white relative overflow-hidden">
                    <div class="relative z-30 text-center">
                        
                        <div class="relative group mx-auto mb-6 h-40 w-40 cursor-pointer z-50" onclick="document.getElementById('avatarInput').click()">
                            <div class="h-full w-full rounded-[2.5rem] flex items-center justify-center bg-white text-[#003366] text-6xl font-black italic shadow-2xl border-4 border-white overflow-hidden">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" id="avatarPreview" class="w-full h-full object-cover">
                                @else
                                    <span id="avatarTextPreview">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                @endif
                                
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white rounded-[2.5rem]">
                                    <i class="fa-solid fa-camera text-3xl mb-1"></i>
                                    <span class="text-[9px] font-black uppercase">Đổi ảnh</span>
                                </div>
                            </div>
                            <input type="file" name="avatar" id="avatarInput" accept="image/*" class="hidden" onchange="previewImage(this)">
                        </div>

                        <h3 class="text-xl font-black uppercase italic tracking-tighter">{{ Auth::user()->name }}</h3>
                        <p class="text-[10px] font-bold text-white/50 uppercase tracking-[0.2em] mt-2">Mã số: {{ Auth::user()->id + 10000 }}</p>
                    </div>
                    <i class="fa-solid fa-fingerprint absolute -bottom-10 -left-10 text-[12rem] opacity-5 -rotate-12 z-0"></i>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white p-10 rounded-[3.5rem] shadow-xl border border-slate-100">
                    <div class="flex items-center gap-3 mb-8 border-b pb-6"><i class="fa-solid fa-user-pen text-[#003366]"></i><h3 class="text-lg font-black uppercase italic">Thông tin định danh</h3></div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2"><label class="text-[10px] font-black text-slate-400 uppercase italic ml-2">Họ và tên</label><input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-[#003366] shadow-inner"></div>
                        <div class="space-y-2"><label class="text-[10px] font-black text-slate-400 uppercase italic ml-2">Email</label><input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-[#003366] shadow-inner"></div>
                        <div class="space-y-2"><label class="text-[10px] font-black text-slate-400 uppercase italic ml-2">Ngày sinh</label><input type="date" name="birthday" value="{{ Auth::user()->birthday ? \Carbon\Carbon::parse(Auth::user()->birthday)->format('Y-m-d') : '' }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-[#003366] shadow-inner"></div>
                        <div class="space-y-2"><label class="text-[10px] font-black text-slate-400 uppercase italic ml-2">Quê quán</label><input type="text" name="hometown" value="{{ Auth::user()->hometown }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-[#003366] shadow-inner"></div>
                    </div>
                    <div class="flex justify-end pt-6 mt-6 border-t"><button type="submit" class="bg-[#003366] text-white font-black py-4 px-10 rounded-2xl shadow-xl uppercase text-[10px] tracking-widest italic hover:bg-slate-800 transition-all">Lưu thay đổi hồ sơ</button></div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById('avatarPreview');
                    var textPreview = document.getElementById('avatarTextPreview');
                    if (preview) { preview.src = e.target.result; } 
                    else {
                        var img = document.createElement('img');
                        img.id = 'avatarPreview'; img.src = e.target.result; img.className = 'w-full h-full object-cover';
                        textPreview.parentNode.appendChild(img); textPreview.parentNode.removeChild(textPreview);
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>