<x-app-layout>
    <div class="space-y-6">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border-b-8 border-[#003366] flex flex-col md:flex-row justify-between items-center gap-6 text-center md:text-left">
            <div class="flex items-center gap-6 flex-col md:flex-row">
                <div class="h-24 w-24 rounded-[2rem] bg-slate-50 border-4 border-slate-100 flex items-center justify-center text-[#003366] text-4xl font-black shadow-inner italic">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-black text-[#003366] uppercase italic tracking-tighter">{{ Auth::user()->name }}</h2>
                    <div class="flex flex-wrap justify-center md:justify-start gap-2 mt-2">
                        <span class="px-3 py-1 bg-slate-100 text-[#003366] text-[10px] font-black rounded-lg uppercase tracking-widest">MSV: {{ Auth::user()->id + 10000 }}</span>
                        <span class="px-3 py-1 bg-slate-100 text-[#003366] text-[10px] font-black rounded-lg uppercase tracking-widest">Lớp: {{ Auth::user()->academic_year }}</span>
                        <span class="px-3 py-1 bg-slate-100 text-[#003366] text-[10px] font-black rounded-lg uppercase tracking-widest italic font-bold">Khoa: {{ Auth::user()->department }}</span>
                    </div>
                </div>
            </div>
            <button onclick="window.print()" class="bg-[#003366] text-white p-4 rounded-2xl shadow-xl hover:scale-105 transition-all flex items-center gap-3 font-black uppercase text-[10px] tracking-widest">
                <i class="fa-solid fa-print text-lg"></i> Xuất bảng điểm
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-[#003366] text-white p-6 rounded-[2.5rem] shadow-xl flex flex-col items-center justify-center border-b-8 border-slate-900">
                <p class="text-[9px] font-black uppercase tracking-[0.3em] opacity-50 mb-3 italic">TBC Tích lũy (4.0)</p>
                <h4 class="text-5xl font-black italic tracking-tighter mb-2">{{ number_format($gpa4, 2) }}</h4>
                <div class="px-4 py-1 bg-white/20 rounded-full text-[10px] font-black uppercase italic tracking-widest">
                    Xếp loại: {{ $rank4 }}
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2.5rem] shadow-lg border border-slate-100 flex flex-col items-center justify-center border-b-8 border-slate-200">
                <p class="text-slate-400 text-[9px] font-black uppercase tracking-[0.3em] mb-3 italic">TBC Học tập (10.0)</p>
                <h4 class="text-5xl font-black text-[#003366] italic tracking-tighter mb-2">{{ number_format($gpa10, 2) }}</h4>
                <div class="px-4 py-1 bg-slate-100 rounded-full text-[10px] font-black uppercase italic tracking-widest text-[#003366]">
                    Xếp loại: {{ $rank10 }}
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2.5rem] shadow-lg border border-slate-100 flex flex-col items-center justify-center border-b-8 border-slate-200">
                <p class="text-slate-400 text-[9px] font-black uppercase tracking-[0.3em] mb-3 italic">Tín chỉ tích lũy</p>
                <h4 class="text-5xl font-black text-slate-800 italic tracking-tighter">{{ $totalCredits }}</h4>
                <div class="px-4 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase italic tracking-widest mt-2">
                    Hoàn thành
                </div>
            </div>

            <div class="bg-slate-800 p-6 rounded-[2.5rem] shadow-xl text-white space-y-3 flex flex-col justify-center">
                <div class="flex justify-between items-center px-2">
                    <span class="text-[10px] font-black uppercase italic text-slate-400">Thi lại:</span>
                    <span class="font-black text-amber-400 italic">{{ $countThiLai }} Môn</span>
                </div>
                <div class="flex justify-between items-center px-2 border-y border-white/5 py-2">
                    <span class="text-[10px] font-black uppercase italic text-slate-400">Học lại:</span>
                    <span class="font-black text-red-500 italic">{{ $countHocLai }} Môn</span>
                </div>
                <div class="flex justify-between items-center px-2">
                    <span class="text-[10px] font-black uppercase italic text-slate-400">Chờ điểm:</span>
                    <span class="font-black text-blue-400 italic">{{ $countChoDiem }} Môn</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[3rem] shadow-2xl border border-slate-100 overflow-hidden">
            <div class="p-6 bg-[#003366] text-white flex justify-between items-center italic">
                <h3 class="font-black uppercase text-xs tracking-[0.3em] flex items-center gap-2">
                    <i class="fa-solid fa-list-check"></i> Chi tiết các học phần
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-[11px] font-bold italic border-collapse">
                    <thead class="bg-slate-900 text-white uppercase tracking-widest">
                        <tr>
                            <th class="p-6">Mã học phần</th>
                            <th class="p-6">Tên học phần</th>
                            <th class="p-6 text-center">Tín chỉ</th>
                            <th class="p-6 text-center">C.Cần</th>
                            <th class="p-6 text-center">G.Kỳ</th>
                            <th class="p-6 text-center">C.Kỳ</th>
                            <th class="p-6 text-center text-amber-400">Thi lại</th>
                            <th class="p-6 text-center bg-slate-800">Tổng hệ 10</th>
                            <th class="p-6 text-center bg-slate-900">Điểm chữ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-bold">
                        @foreach($grades as $grade)
                        <tr class="hover:bg-slate-50 transition-colors uppercase text-[10px] tracking-tight">
                            <td class="p-6 text-[#003366] font-black">{{ $grade->course->course_code }}</td>
                            <td class="p-6 text-slate-700">{{ $grade->course->course_name }}</td>
                            <td class="p-6 text-center text-slate-400">{{ $grade->course->credits }}</td>
                            <td class="p-6 text-center text-slate-400">{{ $grade->attendance_score }}</td>
                            <td class="p-6 text-center text-slate-400">{{ $grade->midterm_score }}</td>
                            <td class="p-6 text-center text-slate-400">{{ $grade->final_score ?? '?' }}</td>
                            <td class="p-6 text-center text-amber-600 font-black italic">{{ $grade->retest_score ?? '-' }}</td>
                            <td class="p-6 text-center text-lg font-black text-[#003366] italic">{{ number_format($grade->average, 1) }}</td>
                            <td class="p-6 text-center">
                                <span class="px-4 py-1.5 rounded-xl font-black {{ $grade->average < 4.0 ? 'bg-red-500 text-white shadow-lg shadow-red-200' : 'bg-slate-100 text-slate-800 border border-slate-200' }}">
                                    {{ $grade->letter_grade }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-10 bg-slate-50 flex flex-col items-center justify-center gap-2 border-t border-slate-100">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.5em] italic">East Asia University of Technology</p>
                <div class="h-1 w-20 bg-[#003366] rounded-full"></div>
            </div>
        </div>
    </div>
</x-app-layout>