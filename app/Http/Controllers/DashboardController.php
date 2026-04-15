<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Kiểm tra đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userId = $user->id;

        // 2. Kiểm tra xem có phải Admin không 
        // TAO GIỮ NGUYÊN CODE CỦA MÀY VÀ THÊM PHẦN CHECK TÊN ĐỂ TRÁNH LỖI HIỆN SỐ 0
        $isAdmin = (
            $user->role === 'admin' || 
            $user->email === 'admin@gmail.com' || 
            str_contains(strtolower($user->name), 'admin') // Nếu tên có chữ admin thì coi là admin luôn
        );

        if ($isAdmin) {
            // Thống kê toàn trường cho Admin (Giữ nguyên logic của mày)
            $totalCourses = Course::count();
            $totalGrades = Grade::count();
            $totalStudents = User::count();
            $gpa = Grade::avg('score') ?: 0;

            $stats = [
                'gioi' => Grade::where('score', '>=', 8.0)->count(),
                'kha' => Grade::where('score', '>=', 6.5)->where('score', '<', 8.0)->count(),
                'trung_binh' => Grade::where('score', '>=', 5.0)->where('score', '<', 6.5)->count(),
                'yeu' => Grade::where('score', '<', 5.0)->count(),
            ];
        } else {
            // Thống kê cá nhân cho Sinh viên (Giữ nguyên logic của mày)
            $totalCourses = Grade::where('student_id', $userId)->count();
            $totalGrades = Grade::where('student_id', $userId)->count();
            $totalStudents = 1; // Là chính nó
            $gpa = Grade::where('student_id', $userId)->avg('score') ?: 0;

            $stats = [
                'gioi' => Grade::where('student_id', $userId)->where('score', '>=', 8.0)->count(),
                'kha' => Grade::where('student_id', $userId)->where('score', '>=', 6.5)->where('score', '<', 8.0)->count(),
                'trung_binh' => Grade::where('student_id', $userId)->where('score', '>=', 5.0)->where('score', '<', 6.5)->count(),
                'yeu' => Grade::where('student_id', $userId)->where('score', '<', 5.0)->count(),
            ];
        }

        // Trả về view với đầy đủ biến mà code cũ của mày đang dùng
        return view('dashboard', compact('totalCourses', 'totalGrades', 'totalStudents', 'gpa', 'stats'));
    }
}