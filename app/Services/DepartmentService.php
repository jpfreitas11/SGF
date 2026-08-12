<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DepartmentService
{
    public function createWithAdmin(array $data): Department
    {
        return DB::transaction(function () use ($data) {
            $department = Department::create([
                'name' => $data['name'],
            ]);

            $admin = User::create([
                'name' => 'Admin ' . $department->name,
                'email' => Str::slug($department->name) . '@sgf.test',
                'password' => Hash::make('password'),
                'role' => UserRole::DepartmentAdmin,
                'department_id' => $department->id,
            ]);

            $department->update([
                'admin_user_id' => $admin->id,
            ]);

            return $department->fresh('admin');
        });
    }
}