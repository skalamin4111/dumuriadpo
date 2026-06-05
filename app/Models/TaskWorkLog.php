<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskWorkLog extends Model
{
    protected $fillable = ['task_id', 'employee_id', 'user_id', 'minutes', 'notes', 'worked_at'];

    protected function casts(): array
    {
        return ['worked_at' => 'datetime'];
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
