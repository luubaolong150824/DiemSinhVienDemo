<x-app-layout>
    <div class="space-y-6 animate-fadeIn">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border-l-8 border-[#003366]">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h2 class="text-2xl font-black text-[#003366] uppercase italic tracking-tighter">Quản Lý Sinh Viên</h2>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic font-bold">Hệ thống định danh sinh viên EAUT</p>
                </div>
                <button onclick="openAddModal()" 
                        class="bg-[#003366] hover:bg-slate-800 text-white font-black py-4 px-8 rounded-2xl shadow-xl transition-all flex items-center gap-3 uppercase text-[10px] tracking-widest italic">
                    <i class="fa-solid fa-user-plus text-lg"></i> Thêm sinh viên mới
                </button>
            </div>

            <form action="{{ route('admin.users.index') }}" method="GET" class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2 relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-5 top-4 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Nhập tên hoặc Mã sinh viên để tìm..." 
                           class="w-full bg-slate-50 border-none rounded-2xl py-4 pl-12 pr-6 text-sm font-bold text-[#003366] focus:ring-4 focus:ring-blue-50 shadow-inner">
                </div>
                <div class="relative">
                    <i class="fa-solid fa-filter absolute left-5 top-4 text-slate-400"></i>
                    <select name="class" class="w-full bg-slate-50 border-none rounded-2xl py-4 pl-12 pr-6 text-sm font-bold text-[#003366] focus:ring-4 focus:ring-blue-50 shadow-inner appearance-none cursor-pointer">
                        <option value="">Tất cả các lớp</option>
                        @foreach($classes as $class)
                            <option value="{{ $class }}" {{ request('class') == $class ? 'selected' : '' }}>Lớp {{ $class }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-[#003366] text-white font-black py-4 rounded-2xl transition-all uppercase text-[10px] tracking-widest shadow-lg hover:bg-slate-800">
                    Lọc dữ liệu
                </button>
            </form>
        </div>

        <div class="bg-white rounded-[3rem] shadow-xl border border-slate-100 overflow-hidden">
            <table class="w-full text-left text-[11px] font-bold italic">
                <thead class="bg-[#003366] text-white uppercase tracking-[0.2em]">
                    <tr>
                        <th class="p-6">Mã SV</th>
                        <th class="p-6">Họ Và Tên</th>
                        <th class="p-6">Email</th>
                        <th class="p-6">Lớp / Khóa</th>
                        <th class="p-6">Khoa</th>
                        <th class="p-6 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition-colors uppercase tracking-tighter">
                        <td class="p-6 text-[#003366] font-black italic">{{ $user->id + 10000 }}</td>
                        <td class="p-6 text-slate-800">{{ $user->name }}</td>
                        <td class="p-6 text-slate-400 lowercase italic">{{ $user->email }}</td>
                        <td class="p-6"><span class="px-3 py-1 bg-blue-50 text-[#003366] rounded-lg">{{ $user->academic_year ?? 'N/A' }}</span></td>
                        <td class="p-6 text-slate-500">{{ $user->department ?? 'CNTT' }}</td>
                        <td class="p-6 text-center space-x-3">
                            {{-- NÚT SỬA ĐÃ GÁN HÀM --}}
                            <button onclick='editUser(@json($user))' class="text-blue-500 hover:text-blue-700">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Xóa thằng này à mày?')" class="text-red-400 hover:text-red-600">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-20 text-center italic text-slate-300 uppercase font-black tracking-widest opacity-30">Không tìm thấy sinh viên phù hợp</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-8 bg-slate-50 border-t border-slate-100 flex justify-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL GIỮ NGUYÊN GIAO DIỆN MÀY THÍCH --}}
    <div id="modalAddUser" class="fixed inset-0 bg-slate-900/90 backdrop-blur-md hidden flex items-center justify-center z-[9999] p-4">
        <div class="bg-white rounded-[3.5rem] w-full max-w-xl p-12 shadow-2xl animate-fadeIn">
            <h3 id="modalTitle" class="text-2xl font-black text-[#003366] uppercase italic mb-8 border-b pb-4">🚀 Thêm Sinh Viên Mới</h3>
            
            <form id="userForm" action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
                @csrf
                <div id="methodField"></div> {{-- Chỗ này để nhét @method('PUT') khi sửa --}}
                
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="name" id="userName" placeholder="Họ và tên" required class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold shadow-inner">
                    <input type="email" name="email" id="userEmail" placeholder="Email" required class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold shadow-inner">
                </div>
                
                {{-- Ô mật khẩu sẽ ẩn đi khi Sửa để tránh lỗi --}}
                <div id="passwordArea">
                    <input type="password" name="password" id="userPassword" placeholder="Mật khẩu mặc định" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold shadow-inner">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="academic_year" id="userYear" placeholder="Lớp (VD: K13-CNTT)" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold shadow-inner">
                    <input type="text" name="department" id="userDept" placeholder="Khoa (VD: Công nghệ thông tin)" class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold shadow-inner">
                </div>
                
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-[2] bg-[#003366] text-white font-black py-4 rounded-2xl uppercase text-[10px] tracking-widest shadow-xl">Xác nhận lưu</button>
                    <button type="button" onclick="document.getElementById('modalAddUser').classList.add('hidden')" class="flex-1 bg-slate-100 text-slate-500 font-black py-4 rounded-2xl uppercase text-[10px] tracking-widest">Hủy</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modalAddUser');
        const form = document.getElementById('userForm');

        function openAddModal() {
            modal.classList.remove('hidden');
            document.getElementById('modalTitle').innerText = '🚀 Thêm Sinh Viên Mới';
            document.getElementById('passwordArea').classList.remove('hidden');
            document.getElementById('methodField').innerHTML = '';
            form.action = "{{ route('admin.users.store') }}";
            form.reset();
        }

        function editUser(user) {
            modal.classList.remove('hidden');
            document.getElementById('modalTitle').innerText = '📝 Sửa Sinh Viên: ' + user.name;
            
            // Ẩn mật khẩu khi sửa vì thường không cho admin sửa pass trực tiếp ở đây
            document.getElementById('passwordArea').classList.add('hidden');
            
            // Cấu hình lại Form sang Update
            form.action = `/admin/users/${user.id}`;
            document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';

            // Đổ dữ liệu vào Input
            document.getElementById('userName').value = user.name;
            document.getElementById('userEmail').value = user.email;
            document.getElementById('userYear').value = user.academic_year || '';
            document.getElementById('userDept').value = user.department || '';
        }
    </script>
</x-app-layout>