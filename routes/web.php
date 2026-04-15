<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Trang chủ: Nếu chưa login thì vào Login, rồi thì vào Dashboard
Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard chung
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // NHÓM QUYỀN ADMIN
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('courses', CourseController::class);
        Route::resource('grades', GradeController::class);
    });

    // NHÓM QUYỀN SINH VIÊN
    Route::get('/my-grades', [StudentController::class, 'index'])->name('student.grades');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// FIX LỖI ĐĂNG XUẤT: Ép buộc về trang Login
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

require __DIR__.'/auth.php';

// Thay đổi dòng Dashboard cũ thành dòng này
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
// Profile Routes
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
Route::post('admin/notifications', function (Illuminate\Http\Request $request) {
    App\Models\Notification::create($request->all());
    return back();
})->name('admin.notifications.store');