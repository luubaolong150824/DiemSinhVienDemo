<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            // Thêm các cột mà hệ thống đang đòi
            $table->decimal('attendance_score', 4, 2)->nullable()->after('course_id');
            $table->decimal('midterm_score', 4, 2)->nullable()->after('attendance_score');
            $table->decimal('final_score', 4, 2)->nullable()->after('midterm_score');
            $table->decimal('retest_score', 4, 2)->nullable()->after('final_score');
        });
    }

    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn(['attendance_score', 'midterm_score', 'final_score', 'retest_score']);
        });
    }
};