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
    Schema::create('courses', function (Blueprint $table) {
        $table->id();
        $table->string('course_code')->unique(); // Mã môn học
        $table->string('course_name');           // Tên môn học
        $table->integer('credits');              // Số tín chỉ
        $table->string('semester');              // Học kỳ
        $table->timestamps();
    });
}
};