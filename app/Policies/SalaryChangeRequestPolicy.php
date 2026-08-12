<?php

namespace App\Policies;

use App\Models\SalaryChangeRequest;
use App\Models\User;

class SalaryChangeRequestPolicy
{
    public function view(User $user, SalaryChangeRequest $salaryChangeRequest): bool
    {
        return $user->isSuperAdmin()
            || $user->department_id === $salaryChangeRequest->employee->department_id;
    }

    public function decide(User $user, SalaryChangeRequest $salaryChangeRequest): bool
    {
        return $this->view($user, $salaryChangeRequest);
    }
}