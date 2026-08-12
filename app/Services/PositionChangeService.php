<?php

namespace App\Services;

use App\Enums\RequestStatus;
use App\Models\Employee;
use App\Models\Position;
use App\Models\PositionChangeRequest;
use App\Models\PositionHistory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PositionChangeService
{
    public function request(Employee $employee, Position $newPosition, string $reason, User $user): PositionChangeRequest
    {
        $employee->load('position');

        if ($newPosition->level <= $employee->position->level) {
            throw ValidationException::withMessages([
                'new_position_id' => 'Promocao precisa mover o funcionario para um cargo superior.',
            ]);
        }

        return PositionChangeRequest::create([
            'employee_id' => $employee->id,
            'old_position_id' => $employee->position_id,
            'new_position_id' => $newPosition->id,
            'requested_by' => $user->id,
            'status' => RequestStatus::Pending,
            'reason' => $reason,
        ]);
    }

    public function approve(PositionChangeRequest $request, User $decider, string $reason): PositionChangeRequest
    {
        return DB::transaction(function () use ($request, $decider, $reason) {
            if ($request->status !== RequestStatus::Pending) {
                throw ValidationException::withMessages([
                    'status' => 'Esta solicitacao ja foi decidida.',
                ]);
            }

            $employee = $request->employee()->lockForUpdate()->firstOrFail();

            PositionHistory::create([
                'employee_id' => $employee->id,
                'old_position_id' => $employee->position_id,
                'new_position_id' => $request->new_position_id,
                'decided_by' => $decider->id,
                'reason' => $reason,
                'changed_at' => now(),
            ]);

            $employee->update([
                'position_id' => $request->new_position_id,
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

    public function reject(PositionChangeRequest $request, User $decider, string $reason): PositionChangeRequest
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