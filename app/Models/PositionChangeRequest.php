<?php

namespace App\Models;

use App\Enums\RequestStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PositionChangeRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'old_position_id',
        'new_position_id',
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
            'status' => RequestStatus::class,
            'decided_at' => 'datetime',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function oldPosition(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'old_position_id');
    }

    public function newPosition(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'new_position_id');
    }
}