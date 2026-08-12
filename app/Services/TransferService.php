<?php

namespace App\Services;

use App\Enums\RequestStatus;
use App\Models\Employee;
use App\Models\TransferRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransferService
{
    public function request(Employee $employee, int $toDepartmentId, string $reason, User $user): TransferRequest
    {
        if ($employee->department_id === $toDepartmentId) {
            throw ValidationException::withMessages([
                'to_department_id' => 'O funcionario ja pertence a este setor.',
            ]);
        }

        return TransferRequest::create([
            'employee_id' => $employee->id,
            'from_department_id' => $employee->department_id,
            'to_department_id' => $toDepartmentId,
            'requested_by' => $user->id,
            'status' => RequestStatus::Pending,
            'reason' => $reason,
        ]);
    }

    public function approve(TransferRequest $request, User $decider, string $reason): TransferRequest
    {
        return DB::transaction(function () use ($request, $decider, $reason) {
            if ($request->status !== RequestStatus::Pending) {
                throw ValidationException::withMessages([
                    'status' => 'Esta solicitacao ja foi decidida.',
                ]);
            }

            $employee = $request->employee()->lockForUpdate()->firstOrFail();

            $employee->update([
                'department_id' => $request->to_department_id,
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

    public function reject(TransferRequest $request, User $decider, string $reason): TransferRequest
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