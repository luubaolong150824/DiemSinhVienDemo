<x-app-layout>
    <div class="p-8 bg-[#f8fafc] min-h-screen">
        <div class="max-w-7xl mx-auto space-y-6">
            
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 space-y-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-[1000] text-[#003366] uppercase italic tracking-tighter flex items-center gap-3">
                            <span class="w-2 h-8 bg-[#003366] rounded-full"></span>
                            Quản Lý Điểm Học Phần
                        </h2>
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] mt-1 ml-5">Hệ thống quản lý điểm EAUT</p>
                    </div>
                    <button onclick="openModal()" class="bg-[#003366] hover:bg-blue-900 text-white px-8 py-4 rounded-2xl font-black uppercase text-xs shadow-lg transition-all flex items-center gap-3">
                        <i class="fa-solid fa-plus text-sm"></i> Thêm điểm mới
                    </button>
                </div>

                <form action="{{ route('admin.grades.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-slate-50">
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm tên sinh viên..." 
                        class="w-full bg-slate-50 border-none rounded-2xl py-3.5 pl-12 pr-6 text-xs font-bold focus:ring-4 focus:ring-[#003366]/5 outline-none">
                    </div>
                    <div>
                        <select name="course_id" class="w-full bg-slate-50 border-none rounded-2xl py-3.5 px-6 text-xs font-bold text-blue-700 italic outline-none appearance-none">
                            <option value="">-- Tất cả môn học --</option>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>{{ $c->course_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-slate-100 hover:bg-slate-200 text-[#003366] font-black uppercase text-[10px] rounded-2xl transition-all">Lọc dữ liệu</button>
                        <a href="{{ route('admin.grades.index') }}" class="px-6 py-3.5 bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-2xl transition-all flex items-center"><i class="fa-solid fa-rotate-left"></i></a>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-sm overflow-hidden border border-slate-100">
                <div class="overflow-x-auto px-4 py-4">
                    <table class="w-full text-left border-separate border-spacing-y-3">
                        <thead>
                            <tr class="text-slate-400 text-[10px] uppercase font-black tracking-widest">
                                <th class="px-8 py-4">Sinh viên</th>
                                <th class="px-8 py-4">Môn học</th>
                                <th class="px-6 py-4 text-center bg-blue-50/50 rounded-tl-xl">Hệ 10</th>
                                <th class="px-6 py-4 text-center bg-indigo-50/50">Hệ 4</th>
                                <th class="px-6 py-4 text-center bg-purple-50/50 rounded-tr-xl">Điểm Chữ</th>
                                <th class="px-8 py-4 text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($grades as $grade)
                            <tr class="group bg-white hover:bg-slate-50 transition-all shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                                <td class="px-8 py-5 rounded-l-3xl border-y border-l border-slate-50">
                                    <div class="font-black text-[#003366] text-sm uppercase italic">{{ $grade->user->name ?? 'N/A' }}</div>
                                    <div class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5 italic">Lớp: {{ $grade->user->academic_year ?? 'K13-CNTT' }}</div>
                                </td>
                                <td class="px-8 py-5 text-center border-y border-slate-50 italic font-black text-blue-700 text-[11px] uppercase tracking-tighter">
                                    {{ $grade->course->course_name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-5 text-center border-y border-slate-50 font-[1000] text-lg text-[#003366] bg-blue-50/20 italic">
                                    {{ number_format($grade->average, 1) }}
                                </td>
                                <td class="px-6 py-5 text-center border-y border-slate-50 font-black text-indigo-700 bg-indigo-50/20">
                                    @php
                                        $avg = $grade->average;
                                        $gpa4 = $avg >= 8.5 ? 4.0 : ($avg >= 7.0 ? 3.0 : ($avg >= 5.5 ? 2.0 : ($avg >= 4.0 ? 1.0 : 0.0)));
                                        $letter = $grade->letter_grade;
                                        $badgeColor = match($letter) { 'A+','A' => 'bg-emerald-500', 'B+','B' => 'bg-blue-600', 'C+','C' => 'bg-amber-500', 'D+','D' => 'bg-orange-600', default => 'bg-rose-600' };
                                    @endphp
                                    {{ number_format($gpa4, 1) }}
                                </td>
                                <td class="px-6 py-5 text-center border-y border-slate-50 bg-purple-50/20 font-black">
                                    <span class="inline-block px-4 py-1.5 rounded-xl text-white text-[10px] font-black {{ $badgeColor }} shadow-lg shadow-current/20">
                                        {{ $letter }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center rounded-r-3xl border-y border-r border-slate-50">
                                    <div class="flex justify-center gap-2">
                                        <button onclick='editGrade(@json($grade))' class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 hover:bg-[#003366] hover:text-white transition-all flex items-center justify-center shadow-sm">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </button>
                                        <form action="{{ route('admin.grades.destroy', $grade) }}" method="POST" onsubmit="return confirm('Xác nhận xóa điểm?')">
                                            @csrf @method('DELETE')
                                            <button class="w-9 h-9 rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center shadow-sm">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="p-20 text-center text-slate-300 font-black uppercase italic tracking-[0.5em]">Không tìm thấy dữ liệu</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-10 bg-slate-50/50 border-t border-slate-100 flex justify-between items-center">
                    <p class="text-[10px] font-black text-slate-400 italic uppercase">Hiển thị {{ $grades->count() }} kết quả / Trang {{ $grades->currentPage() }}</p>
                    <div class="luxury-pagination">{{ $grades->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div id="gradeModal" class="fixed inset-0 bg-[#001833]/80 backdrop-blur-md z-[100] flex items-center justify-center p-6 hidden">
        <div class="bg-white rounded-[3rem] w-full max-w-2xl shadow-2xl overflow-hidden border border-white/20 transform transition-all">
            <div class="px-10 py-8 bg-[#003366] flex justify-between items-center text-white">
                <div>
                    <h3 id="modalTitle" class="text-xl font-[1000] uppercase italic tracking-tighter">Cập nhật điểm</h3>
                    <p class="text-blue-300 text-[9px] font-black uppercase tracking-widest mt-1 italic">Học viện Công nghệ Đông Á</p>
                </div>
                <button onclick="closeModal()" class="w-10 h-10 rounded-full bg-white/10 text-white hover:bg-white/20 transition-all flex items-center justify-center"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form action="{{ route('admin.grades.store') }}" method="POST" class="p-10 space-y-8 bg-white">
                @csrf
                <div class="grid grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label class="ml-2 text-[10px] font-black text-slate-400 uppercase tracking-widest italic block">Sinh viên</label>
                        <select name="student_id" id="student_id_select" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-black text-[#003366] outline-none">
                            <option value="">-- Danh sách --</option>
                            @foreach($students as $s) <option value="{{ $s->id }}">{{ $s->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="space-y-3">
                        <label class="ml-2 text-[10px] font-black text-slate-400 uppercase tracking-widest italic block">Môn học</label>
                        <select name="course_id" id="course_id_select" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-sm font-black text-blue-700 italic outline-none">
                            <option value="">-- Học phần --</option>
                            @foreach($courses as $c) <option value="{{ $c->id }}">{{ $c->course_name }}</option> @endforeach
                        </select>
                    </div>
                </div>

                <div class="bg-slate-50 p-8 rounded-[2rem] grid grid-cols-4 gap-4 shadow-inner">
                    @foreach(['attendance_score' => '10%', 'midterm_score' => '30%', 'final_score' => '60%', 'retest_score' => 'Lại'] as $name => $label)
                    <div class="space-y-3">
                        <label class="block text-center text-[9px] font-black text-slate-400 uppercase italic">{{ $label }}</label>
                        <input type="number" name="{{ $name }}" id="score_{{ $name }}" step="0.1" min="0" max="10" placeholder="0.0" 
                        class="w-full bg-white border-none rounded-xl py-3 text-center text-sm font-[1000] text-[#003366] shadow-sm outline-none focus:ring-4 focus:ring-[#003366]/10">
                    </div>
                    @endforeach
                </div>

                <div class="flex items-center justify-end gap-4 pt-4">
                    <button type="button" onclick="closeModal()" class="px-8 py-4 rounded-2xl text-slate-400 font-black text-[10px] uppercase hover:bg-slate-50 transition-all">Bỏ qua</button>
                    <button type="submit" class="bg-[#003366] text-white px-12 py-4 rounded-2xl font-[1000] text-[11px] uppercase shadow-[0_15px_30px_rgba(0,51,102,0.25)] hover:scale-[1.02] active:scale-95 transition-all italic">Lưu dữ liệu</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('gradeModal');
        function openModal() {
            modal.classList.remove('hidden');
            document.getElementById('modalTitle').innerText = 'Thêm điểm mới';
            document.querySelector('#gradeModal form').reset();
        }
        function closeModal() { modal.classList.add('hidden'); }
        
        function editGrade(grade) {
            modal.classList.remove('hidden');
            document.getElementById('modalTitle').innerText = 'Chỉnh sửa điểm';
            document.getElementById('student_id_select').value = grade.student_id;
            document.getElementById('course_id_select').value = grade.course_id;
            document.getElementById('score_attendance_score').value = grade.attendance_score;
            document.getElementById('score_midterm_score').value = grade.midterm_score;
            document.getElementById('score_final_score').value = grade.final_score;
            document.getElementById('score_retest_score').value = grade.retest_score;
        }
    </script>

    <style>
        .luxury-pagination nav svg { width: 1.25rem; height: 1.25rem; }
        .luxury-pagination nav div:first-child { display: none; }
        .luxury-pagination nav span, .luxury-pagination nav a { 
            padding: 0.6rem 1rem !important; border-radius: 1rem !important; margin: 0 3px;
            font-size: 0.75rem !important; font-weight: 900 !important; color: #003366 !important;
            border: none !important; background: white !important; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }
        .luxury-pagination nav .bg-white { background: #003366 !important; color: white !important; }
    </style>
</x-app-layout>