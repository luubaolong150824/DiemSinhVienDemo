<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        /** * QUAN TRỌNG: Đổi 'student' thành 'user' để khớp với hàm user() trong Model Grade
         * Tao đã thêm paginate(10) để nó phân trang cho mày rồi.
         */
        $grades = Grade::with(['user', 'course'])->latest()->paginate(10);
        
        $students = User::role('student')->get();
        $courses = Course::all();
        
        return view('admin.grades.index', compact('grades', 'students', 'courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'attendance_score' => 'nullable|numeric|min:0|max:10',
            'midterm_score' => 'nullable|numeric|min:0|max:10',
            'final_score' => 'nullable|numeric|min:0|max:10',
            'retest_score' => 'nullable|numeric|min:0|max:10',
        ]);

        // Tính toán điểm tổng kết trước khi lưu (nếu database mày có cột score)
        $attendance = $request->attendance_score ?? 0;
        $midterm = $request->midterm_score ?? 0;
        $final = $request->final_score ?? 0;
        $score = ($attendance * 0.1) + ($midterm * 0.3) + ($final * 0.6);
        
        // Nếu điểm thi lại cao hơn thì lấy điểm thi lại
        if ($request->retest_score && $request->retest_score > $score) {
            $score = $request->retest_score;
        }

        $data['score'] = $score;

        Grade::updateOrCreate(
            ['student_id' => $data['student_id'], 'course_id' => $data['course_id']],
            $data
        );

        return back()->with('success', 'Đã cập nhật bảng điểm chi tiết thành công!');
    }

    public function destroy(Grade $grade) 
    { 
        $grade->delete(); 
        return back()->with('success', 'Đã xóa điểm thành công!'); 
    }
}