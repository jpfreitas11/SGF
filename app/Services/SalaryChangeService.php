<?php

namespace App\Services;

use App\Enums\RequestStatus;
use App\Models\Employee;
use App\Models\SalaryChangeRequest;
use App\Models\SalaryHistory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SalaryChangeService
{
    public function request(Employee $employee, float $newSalary, string $reason, User $user): SalaryChangeRequest
    {
        if ($newSalary <= (float) $employee->salary) {
            throw ValidationException::withMessages([
                'new_salary' => 'O novo salario precisa ser maior que o salario atual.',
            ]);
        }

        return SalaryChangeRequest::create([
            'employee_id' => $employee->id,
            'old_salary' => $employee->salary,
            'new_salary' => $newSalary,
            'requested_by' => $user->id,
            'status' => RequestStatus::Pending,
            'reason' => $reason,
        ]);
    }

    public function approve(SalaryChangeRequest $request, User $decider, string $reason): SalaryChangeRequest
    {
        return DB::transaction(function () use ($request, $decider, $reason) {
            if ($request->status !== RequestStatus::Pending) {
                throw ValidationException::withMessages([
                    'status' => 'Esta solicitacao ja foi decidida.',
                ]);
            }

            $employee = $request->employee()->lockForUpdate()->firstOrFail();

            SalaryHistory::create([
                'employee_id' => $employee->id,
                'old_salary' => $employee->salary,
                'new_salary' => $request->new_salary,
                'decided_by' => $decider->id,
                'reason' => $reason,
                'changed_at' => now(),
            ]);

            $employee->update([
                'salary' => $request->new_salary,
            ]);

            $request->update([
                'status' => RequestStatus::Approved,
                'decided_by' => $decider->id,
                'decision_reason' => $reason,
                'decided_at' => now(),
            ]);

            return $request->fresh();
        });
    }

    public function reject(SalaryChangeRequest $request, User $decider, string $reason): SalaryChangeRequest
    {
        if ($request->status !== RequestStatus::Pending) {
            throw ValidationException::withMessages([
                'status' => 'Esta solicitacao ja foi decidida.',
            ]);
        }

        $request->update([
            'status' => RequestStatus::Rejected,
            'decided_by' => $decider->id,
            'decision_reason' => $reason,
            'decided_at' => now(),
        ]);

        return $request->fresh();
    }
}