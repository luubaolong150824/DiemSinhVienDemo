<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('grades', function (Blueprint $table) {
        $table->id();
        // Liên kết khóa ngoại với bảng users và courses
        $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
        $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
        
        $table->decimal('score', 4, 2)->nullable(); // Điểm số
        $table->timestamps();

        // Đảm bảo 1 sinh viên chỉ có 1 đầu điểm cho 1 môn
        $table->unique(['student_id', 'course_id']);
    });
}
};