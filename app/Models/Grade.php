<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    // Bổ sung thêm 'score' vào fillable để lưu được điểm tổng kết nếu cần
    protected $fillable = [
        'student_id', 
        'course_id', 
        'attendance_score', 
        'midterm_score', 
        'final_score', 
        'retest_score',
        'score'
    ];

    /**
     * Quan trọng: Đổi tên từ student() thành user() 
     * để khớp với lệnh $grade->user trong View và Controller.
     */
    public function user() 
    { 
        return $this->belongsTo(User::class, 'student_id'); 
    }

    public function course() 
    { 
        return $this->belongsTo(Course::class, 'course_id'); 
    }

    /**
     * Tính điểm tổng kết hệ 10 theo trọng số EAUT (10% - 30% - 60%)
     * Truy cập bằng: $grade->average
     */
    public function getAverageAttribute()
    {
        $attendance = $this->attendance_score ?? 0;
        $midterm = $this->midterm_score ?? 0;
        $final = $this->final_score ?? 0;

        $calculatedScore = ($attendance * 0.1) + ($midterm * 0.3) + ($final * 0.6);
        
        // Nếu có điểm thi lại và cao hơn điểm tính toán thì lấy điểm thi lại
        if ($this->retest_score !== null && $this->retest_score > $calculatedScore) {
            return round($this->retest_score, 1);
        }

        return round($calculatedScore, 1);
    }

    /**
     * Quy đổi sang thang điểm chữ chuẩn EAUT
     * Truy cập bằng: $grade->letter_grade
     */
    public function getLetterGradeAttribute()
    {
        $avg = $this->average;
        if ($avg >= 9.0) return 'A+';
        if ($avg >= 8.5) return 'A';
        if ($avg >= 8.0) return 'B+';
        if ($avg >= 7.0) return 'B';
        if ($avg >= 6.5) return 'C+';
        if ($avg >= 5.5) return 'C';
        if ($avg >= 5.0) return 'D+';
        if ($avg >= 4.0) return 'D';
        return 'F';
    }
}
// Bài làm của Xuân Nam