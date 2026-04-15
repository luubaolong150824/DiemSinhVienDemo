<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        // Lấy danh sách môn học mới nhất
        $courses = Course::latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_code' => 'required|string|unique:courses',
            'course_name' => 'required|string|max:255',
            'credits'     => 'required|integer|min:1|max:10',
            'semester'    => 'required|string',
        ]);

        Course::create($data);

        return back()->with('success', 'Đã thêm môn học ' . $data['course_name'] . ' thành công!');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return back()->with('success', 'Đã xóa môn học thành công!');
    }
}