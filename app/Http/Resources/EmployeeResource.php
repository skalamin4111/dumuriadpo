<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->user?->name,
            'email' => $this->user?->email,
            'role' => $this->user?->getRoleNames()->first(),
            'department' => $this->department?->name,
            'designation' => $this->designation,
            'phone' => $this->phone,
            'status' => $this->status,
            'joining_date' => $this->joining_date?->toDateString(),
        ];
    }
}
