<?php

namespace App\Policies;

use App\Models\PositionChangeRequest;
use App\Models\User;

class PositionChangeRequestPolicy
{
    public function view(User $user, PositionChangeRequest $positionChangeRequest): bool
    {
        return $user->isSuperAdmin()
            || $user->department_id === $positionChangeRequest->employee->department_id;
    }

    public function decide(User $user, PositionChangeRequest $positionChangeRequest): bool
    {
        return $this->view($user, $positionChangeRequest);
    }
}