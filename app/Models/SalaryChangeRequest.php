<?php

namespace App\Models;

use App\Enums\RequestStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalaryChangeRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'old_salary',
        'new_salary',
        'requested_by',
        'decided_by',
        'status',
        'reason',
        'decision_reason',
        'decided_at',
    ];

    protected function casts(): array
    {
        return [
            'old_salary' => 'decimal:2',
            'new_salary' => 'decimal:2',
            'status' => RequestStatus::class,
            'decided_at' => 'datetime',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}