<x-app-layout>
    <div class="p-8 space-y-8 bg-[#f8fafc] min-h-screen">
        
        <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border-l-8 border-[#003366] flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-[1000] text-[#003366] uppercase italic tracking-tighter">Bảng Điều Khiển Hệ Thống</h2>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mt-1 italic">Chào mừng trở lại, {{ Auth::user()->name }}</p>
            </div>
            <div class="text-right italic">
                <span class="px-4 py-2 bg-slate-50 rounded-2xl text-[10px] font-black text-slate-400 uppercase border border-slate-100">
                    {{ now()->format('d/m/Y') }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 italic">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-slate-50 flex items-center gap-6">
                <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-[#003366] text-2xl shadow-inner">
                    <i class="fa-solid fa-book-bookmark"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase italic">Số môn học</p>
                    <h3 class="text-3xl font-[1000] text-[#003366]">{{ $totalCourses }}</h3>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-slate-50 flex items-center gap-6">
                <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 text-2xl shadow-inner">
                    <i class="fa-solid fa-file-invoice"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase italic">Bản ghi điểm</p>
                    <h3 class="text-3xl font-[1000] text-indigo-600">{{ $totalGrades }}</h3>
                </div>
            </div>

            <div class="bg-[#003366] p-8 rounded-[2.5rem] shadow-2xl flex items-center gap-6">
                <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center text-white text-2xl shadow-inner border border-white/10">
                    <i class="fa-solid fa-star"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-blue-200 uppercase italic">GPA Trung bình</p>
                    <h3 class="text-3xl font-[1000] text-white">{{ number_format($gpa, 2) }}</h3>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-slate-50 flex items-center gap-6">
                <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl shadow-inner">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase italic">Đối tượng</p>
                    <h3 class="text-3xl font-[1000] text-emerald-600 uppercase">{{ $totalStudents > 1 ? $totalStudents : 'Cá nhân' }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white p-12 rounded-[3.5rem] shadow-2xl border border-slate-50">
            <h3 class="text-sm font-[1000] text-[#003366] uppercase italic mb-16 flex items-center gap-4">
                <span class="w-1.5 h-6 bg-[#003366] rounded-full"></span>
                Phân tích học lực chi tiết
            </h3>

            <div class="relative px-10">
                {{-- Khu vực biểu đồ với chiều cao cố định 16rem (~256px) --}}
                <div class="flex items-end justify-around border-b-4 border-slate-100 pb-2 gap-10" style="height: 16rem;">
                    
                    @foreach([
                        ['label' => 'Giỏi / XS', 'val' => $stats['gioi'], 'color' => 'bg-[#003366]', 'text' => 'text-[#003366]'],
                        ['label' => 'Khá', 'val' => $stats['kha'], 'color' => 'bg-slate-400', 'text' => 'text-slate-400'],
                        ['label' => 'Trung bình', 'val' => $stats['trung_binh'], 'color' => 'bg-slate-200', 'text' => 'text-slate-300'],
                        ['label' => 'Yêu / Kém', 'val' => $stats['yeu'], 'color' => 'bg-rose-100', 'text' => 'text-rose-300']
                    ] as $item)
                    <div class="flex flex-col items-center w-full group">
                        @php 
                            // Nếu có điểm, ít nhất cột phải cao 3rem, nhiều nhất là 14rem
                            // Tỉ lệ: cứ mỗi môn học cho cột cao thêm 1.5rem
                            $calculatedHeight = $item['val'] * 1.5;
                            if ($item['val'] > 0 && $calculatedHeight < 3) $calculatedHeight = 3;
                            if ($calculatedHeight > 14) $calculatedHeight = 14; 
                        @endphp
                        
                        {{-- Dùng chiều cao cố định bằng rem --}}
                        <div class="w-24 {{ $item['color'] }} rounded-t-[1.5rem] shadow-lg transition-all group-hover:scale-105 relative" 
                             style="height: {{ $item['val'] > 0 ? $calculatedHeight : 0.5 }}rem;">
                             
                             @if($item['val'] > 0)
                             <span class="absolute -top-10 left-1/2 -translate-x-1/2 text-xs font-[1000] {{ $item['text'] }} bg-slate-50 px-3 py-1 rounded-full shadow-sm border border-slate-100">
                                {{ $item['val'] }}
                             </span>
                             @endif
                        </div>
                        <p class="mt-6 text-[11px] font-[1000] {{ $item['text'] }} uppercase italic tracking-[0.2em]">{{ $item['label'] }}</p>
                    </div>
                    @endforeach

                </div>
            </div>
            <p class="text-center mt-12 text-[10px] font-black text-slate-300 uppercase italic tracking-[0.4em]">East Asia University of Technology</p>
        </div>
    </div>
</x-app-layout>