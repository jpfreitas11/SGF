<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EmployeePolicy
{
    
    public function viewAny(User $user): bool
    {
        return true;
    }

  
    public function view(User $user, Employee $employee): bool
    {
        return $user->isSuperAdmin() || $user->department_id === $employee->department_id;
    }

    public function create(User $user): bool
    {
         return $user->isSuperAdmin() || $user->isDepartmentAdmin();
    }

   
    public function update(User $user, Employee $employee): bool
    {
         return $user->isSuperAdmin() || $user->department_id === $employee->department_id;
    }

    
    public function delete(User $user, Employee $employee): bool
    {
         return $user->isSuperAdmin() || $user->department_id === $employee->department_id;
    }

    
    public function restore(User $user, Employee $employee): bool
    {
        return false;
    }

    public function forceDelete(User $user, Employee $employee): bool
    {
        return false;
    }
}
