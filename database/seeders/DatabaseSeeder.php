<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Xóa sạch bảng users và roles để làm lại từ đầu cho chắc
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::table('roles')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Tạo Role
        $adminRole = Role::create(['name' => 'admin']);
        $studentRole = Role::create(['name' => 'student']);

        // 2. Tạo Admin Duy Nhất
        $admin = User::create([
            'name' => 'Phạm Thế Anh Admin',
            'email' => 'admin@eaut.edu.vn',
            'password' => Hash::make('password'),
            'department' => 'Quản trị hệ thống',
        ]);
        $admin->assignRole($adminRole);

        // 3. Mảng dữ liệu mẫu để trộn
        $hos = ['Nguyễn', 'Trần', 'Lê', 'Phạm', 'Hoàng', 'Huỳnh', 'Phan', 'Vũ', 'Võ', 'Đặng'];
        $tens = ['An', 'Bình', 'Cường', 'Dũng', 'Giang', 'Hùng', 'Kiên', 'Linh', 'Minh', 'Nam', 'Phúc', 'Quang', 'Sơn', 'Tùng', 'Vinh'];
        $lops = ['K13-CNTT', 'K14-CNTT', 'K15-CNTT', 'K13-OTO', 'K14-KT'];

        echo "Đang nạp 200 sinh viên... Đợi tí nhé!\n";

        // 4. Vòng lặp ép chạy đủ 200 lần
        for ($i = 1; $i <= 200; $i++) {
            $hoRandom = $hos[array_rand($hos)];
            $tenRandom = $tens[array_rand($tens)];
            
            $student = User::create([
                'name' => $hoRandom . ' ' . $tenRandom . ' (' . $i . ')',
                'email' => "sv" . $i . "@eaut.edu.vn", // Email duy nhất theo số thứ tự
                'password' => Hash::make('password'),
                'academic_year' => $lops[array_rand($lops)],
                'department' => 'Công nghệ thông tin',
                'hometown' => 'Hà Nội',
            ]);

            $student->assignRole($studentRole);
        }

        echo "Xong! Tổng cộng có: " . User::count() . " tài khoản.\n";
    }
}