<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
     use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'document',
        'department_id',
        'position_id',
        'salary',
        'hired_at',
    ];

    protected function casts(): array
    {
        return [
            'salary' => 'decimal:2',
            'hired_at' => 'date',
        ];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function salaryHistories(): HasMany
{
    return $this->hasMany(SalaryHistory::class);
}

    public function positionHistories(): HasMany
{
    return $this->hasMany(PositionHistory::class);
}
}
