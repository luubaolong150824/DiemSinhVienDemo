<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $grades = Grade::where('student_id', $user->id)->with('course')->get();

        $totalCredits = 0;
        $sumScore10 = 0;
        $sumScore4 = 0;
        
        $countThiLai = 0;
        $countHocLai = 0;
        $countChoDiem = 0;

        foreach ($grades as $grade) {
            if ($grade->final_score === null) {
                $countChoDiem++;
                continue;
            }

            $credits = $grade->course->credits;
            $avg10 = $grade->average;

            if ($avg10 < 4.0) {
                $countHocLai++;
            } elseif ($grade->retest_score !== null) {
                $countThiLai++;
            }

            // Chỉ tính tích lũy cho các môn đạt (D trở lên)
            if ($avg10 >= 4.0) {
                $totalCredits += $credits;
                $sumScore10 += ($avg10 * $credits);

                $p4 = 0;
                if ($avg10 >= 8.5) $p4 = 4.0;
                elseif ($avg10 >= 8.0) $p4 = 3.5;
                elseif ($avg10 >= 7.0) $p4 = 3.0;
                elseif ($avg10 >= 6.5) $p4 = 2.5;
                elseif ($avg10 >= 5.5) $p4 = 2.0;
                elseif ($avg10 >= 5.0) $p4 = 1.5;
                elseif ($avg10 >= 4.0) $p4 = 1.0;
                $sumScore4 += ($p4 * $credits);
            }
        }

        $gpa10 = $totalCredits > 0 ? round($sumScore10 / $totalCredits, 2) : 0;
        $gpa4 = $totalCredits > 0 ? round($sumScore4 / $totalCredits, 2) : 0;

        // Xếp loại Hệ 10
        $rank10 = 'Yếu';
        if ($gpa10 >= 9.0) $rank10 = 'Xuất sắc';
        elseif ($gpa10 >= 8.0) $rank10 = 'Giỏi';
        elseif ($gpa10 >= 7.0) $rank10 = 'Khá';
        elseif ($gpa10 >= 5.0) $rank10 = 'Trung bình';

        // Xếp loại Hệ 4
        $rank4 = 'Kém';
        if ($gpa4 >= 3.6) $rank4 = 'Xuất sắc';
        elseif ($gpa4 >= 3.2) $rank4 = 'Giỏi';
        elseif ($gpa4 >= 2.5) $rank4 = 'Khá';
        elseif ($gpa4 >= 2.0) $rank4 = 'Trung bình';

        return view('student.grades_dashboard', compact(
            'grades', 'gpa10', 'gpa4', 'totalCredits', 
            'rank10', 'rank4', 'countThiLai', 'countHocLai', 'countChoDiem'
        ));
    }
}