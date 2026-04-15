<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $blueprint) {
            // Thêm 2 cột còn thiếu vào
            $blueprint->string('academic_year')->nullable()->after('email');
            $blueprint->string('department')->nullable()->after('academic_year');
            $blueprint->string('hometown')->nullable()->after('department');
            $blueprint->date('birthday')->nullable()->after('hometown');
            $blueprint->string('avatar')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['academic_year', 'department', 'hometown', 'birthday', 'avatar']);
        });
    }
};