<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Position extends Model
{
    protected $fillable = ['title', 'level', 'reports_to_id'];

    public function reportsTo(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'reports_to_id');
    }

    public function isAbove(Position $other): bool
    {
        return $this->level > $other->level;
    }
}