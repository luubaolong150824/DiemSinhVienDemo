<x-app-layout>
    <div class="space-y-6">
        <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border-l-8 border-[#F37021]">
            <div>
                <h2 class="text-2xl font-black text-slate-800 uppercase italic">📚 Danh Mục Môn Học EAUT</h2>
                <p class="text-slate-400 text-[10px] font-bold uppercase mt-1 tracking-widest italic font-bold">Chuyên ngành: Công nghệ thông tin & Truyền thông</p>
            </div>
            <button onclick="document.getElementById('modalAddCourse').classList.remove('hidden')" 
                    class="bg-[#0054A6] hover:bg-[#003366] text-white font-black py-3 px-8 rounded-2xl shadow-xl transition-all flex items-center gap-3 uppercase text-[10px] tracking-widest">
                <i class="fa-solid fa-plus-circle text-lg text-[#F37021]"></i> Thêm Môn Mới
            </button>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
            <table class="w-full text-left text-sm font-bold">
                <thead class="bg-[#0054A6] text-white uppercase text-[10px] tracking-widest italic">
                    <tr>
                        <th class="p-6">Mã Môn</th>
                        <th class="p-6">Tên Môn Học</th>
                        <th class="p-6 text-center">Tín Chỉ</th>
                        <th class="p-6 text-center">Học Kỳ / Năm Học</th>
                        <th class="p-6 text-center">Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-slate-600 italic">
                    @foreach ($courses as $course)
                    <tr class="hover:bg-orange-50/50">
                        <td class="p-6 text-[#0054A6] font-black italic">{{ $course->course_code }}</td>
                        <td class="p-6 uppercase text-xs">{{ $course->course_name }}</td>
                        <td class="p-6 text-center">
                            <span class="bg-orange-100 text-[#F37021] px-3 py-1 rounded-full text-[10px] font-black">
                                {{ $course->credits }} TÍN
                            </span>
                        </td>
                        <td class="p-6 text-center text-[10px] uppercase text-slate-400 italic">
                            {{ $course->semester }}
                        </td>
                        <td class="p-6 text-center">
                            <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-3 text-red-400 hover:text-red-600 rounded-2xl transition-all shadow-sm">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-6 bg-slate-50 border-t border-gray-100 italic font-bold text-slate-400">{{ $courses->links() }}</div>
        </div>
    </div>

    <div id="modalAddCourse" class="fixed inset-0 bg-slate-900/80 backdrop-blur-md hidden flex items-center justify-center z-[9999] p-4">
        <div class="bg-white rounded-[3.5rem] shadow-2xl w-full max-w-xl p-12 border border-white/20">
            <div class="flex justify-between items-center mb-10 border-b pb-8 border-orange-100">
                <h3 class="text-2xl font-black text-[#0054A6] uppercase italic leading-none">🚀 Tạo Môn Học EAUT</h3>
                <button onclick="document.getElementById('modalAddCourse').classList.add('hidden')" class="h-10 w-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:bg-red-500 hover:text-white transition-all text-2xl">&times;</button>
            </div>
            
            <form action="{{ route('admin.courses.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase ml-3 mb-2 tracking-widest">Chọn Môn Học Mẫu (EAUT)</label>
                    <select id="course_data_select" onchange="autoFillCourse(this)" class="w-full bg-slate-50 border-gray-100 rounded-2xl p-4 text-sm font-black text-slate-800 outline-none focus:ring-4 focus:ring-orange-100 appearance-none cursor-pointer">
                        <option value="">-- Click để chọn danh mục EAUT --</option>
                        <optgroup label="✨ Cơ Bản">
                            <option value="Lập trình hướng đối tượng" data-code="OOP-EA" data-credits="3">Lập trình OOP (3 TC)</option>
                            <option value="Phát triển Web nâng cao" data-code="WEB-EA" data-credits="3">Phát triển Web (3 TC)</option>
                            <option value="Quản trị cơ sở dữ liệu" data-code="DBA-EA" data-credits="3">Quản trị CSDL (3 TC)</option>
                        </optgroup>
                        <optgroup label="💻 Kỹ Năng">
                            <option value="Tiếng Anh chuyên ngành CNTT" data-code="ENG-IT" data-credits="2">Tiếng Anh CNTT (2 TC)</option>
                            <option value="Thực tập tốt nghiệp" data-code="INTERN" data-credits="4">Thực tập (4 TC)</option>
                        </optgroup>
                        <option value="other">-- Tự nhập môn khác --</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <input type="text" id="course_name" name="course_name" required readonly placeholder="Tên môn" class="w-full bg-slate-50 border-gray-100 rounded-2xl p-4 text-sm font-black text-orange-600 outline-none">
                    <input type="text" id="course_code" name="course_code" required readonly placeholder="Mã môn" class="w-full bg-slate-50 border-gray-100 rounded-2xl p-4 text-sm font-black text-orange-600 outline-none">
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <input type="number" id="credits" name="credits" required readonly class="w-full bg-slate-50 border-gray-100 rounded-2xl p-4 text-sm font-black text-center text-orange-600 outline-none">
                    <select id="term" class="w-full bg-slate-50 border-gray-100 rounded-2xl p-4 text-sm font-black outline-none appearance-none">
                        <option value="Kỳ 1">Kỳ 1</option><option value="Kỳ 2">Kỳ 2</option><option value="Kỳ Hè">Kỳ Hè</option>
                    </select>
                    <select id="year" class="w-full bg-slate-50 border-gray-100 rounded-2xl p-4 text-sm font-black outline-none appearance-none">
                        @for ($i = date('Y'); $i >= 2000; $i--) <option value="{{ $i }}-{{ $i+1 }}">{{ $i }}-{{ $i+1 }}</option> @endfor
                    </select>
                </div>

                <input type="hidden" name="semester" id="semester_hidden">

                <button type="submit" onclick="document.getElementById('semester_hidden').value = document.getElementById('term').value + ' (' + document.getElementById('year').value + ')'"
                        class="w-full bg-[#0054A6] text-white font-black py-4 rounded-2xl hover:bg-[#F37021] shadow-xl transition-all uppercase text-[11px] tracking-[0.2em]">Kích Hoạt Môn Học EAUT</button>
            </form>
        </div>
    </div>

    <script>
        function autoFillCourse(select) {
            const opt = select.options[select.selectedIndex];
            const n = document.getElementById('course_name');
            const c = document.getElementById('course_code');
            const cr = document.getElementById('credits');
            if(select.value === 'other') { n.readOnly=c.readOnly=cr.readOnly=false; n.value=c.value=""; cr.value="3"; n.focus(); }
            else { n.value=select.value; c.value=opt.getAttribute('data-code'); cr.value=opt.getAttribute('data-credits'); n.readOnly=c.readOnly=cr.readOnly=true; }
        }
    </script>
</x-app-layout>