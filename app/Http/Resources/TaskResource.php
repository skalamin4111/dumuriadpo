<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'status' => $this->status,
            'progress' => $this->progress,
            'deadline_at' => $this->deadline_at?->toISOString(),
            'assignee' => $this->assignee?->user?->name,
            'customer' => $this->customer?->name,
            'department' => $this->department?->name,
        ];
    }
}
