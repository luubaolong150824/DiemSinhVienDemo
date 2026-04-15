<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Lấy từ khóa tìm kiếm và lọc lớp từ Request
        $search = $request->input('search');
        $classFilter = $request->input('class');

        // Query lấy sinh viên (role student)
        $query = User::role('student');

        // Nếu có nhập ô tìm kiếm (Tên hoặc MSV)
        if ($search) {
            $query->where(function($q) use ($search) {
                // Tìm theo tên
                $q->where('name', 'LIKE', "%{$search}%")
                  // Hoặc tìm theo MSV (Logic MSV = ID + 10000)
                  ->orWhere('id', '=', (int)$search - 10000);
            });
        }

        // Nếu có chọn lọc theo lớp
        if ($classFilter) {
            $query->where('academic_year', $classFilter);
        }

        // Phân trang: Mỗi trang hiện 10 thằng, giữ lại các tham số tìm kiếm trên URL
        $users = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        // Lấy danh sách các lớp duy nhất để hiện lên cái Dropdown lọc
        $classes = User::role('student')->whereNotNull('academic_year')->distinct()->pluck('academic_year');

        return view('admin.users.index', compact('users', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'academic_year' => 'nullable|string',
            'department' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'academic_year' => $request->academic_year,
            'department' => $request->department,
        ]);

        $user->assignRole('student');

        return redirect()->route('admin.users.index')->with('success', 'Thêm sinh viên thành công!');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'academic_year' => 'nullable|string',
            'department' => 'nullable|string',
        ]);

        $user->update($request->only('name', 'email', 'academic_year', 'department'));

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Xóa sinh viên thành công!');
    }
}