<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'birthday' => ['nullable', 'date'],
            'hometown' => ['nullable', 'string', 'max:255'],
            // Validate ảnh: Phải là ảnh, định dạng jpeg, png, jpg, gif, tối đa 2MB
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Lấy dữ liệu cơ bản
        $userData = $request->only('name', 'email', 'birthday', 'hometown');

        // Xử lý Upload Ảnh đại diện (nếu có)
        if ($request->hasFile('avatar')) {
            // 1. Xóa ảnh cũ nếu tồn tại
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // 2. Lưu ảnh mới vào thư mục storage/app/public/avatars
            $path = $request->file('avatar')->store('avatars', 'public');
            
            // 3. Thêm đường dẫn ảnh vào dữ liệu cập nhật
            $userData['avatar'] = $path;
        }

        // Cập nhật tất cả dữ liệu
        $user->update($userData);

        return back()->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}