<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    // Thêm các trường mới vào mảng fillable
    protected $fillable = [
        'name',
        'email',
        'password',
        'birthday',
        'hometown',
        'department',
        'academic_year',
    ];

    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id');
    }
}