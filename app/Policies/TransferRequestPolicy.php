<?php

namespace App\Policies;

use App\Models\TransferRequest;
use App\Models\User;

class TransferRequestPolicy
{
    public function view(User $user, TransferRequest $transferRequest): bool
    {
        return $user->isSuperAdmin()
            || $user->department_id === $transferRequest->from_department_id
            || $user->department_id === $transferRequest->to_department_id;
    }

    public function decide(User $user, TransferRequest $transferRequest): bool
    {
        return $user->isSuperAdmin()
            || $user->department_id === $transferRequest->to_department_id;
    }
}