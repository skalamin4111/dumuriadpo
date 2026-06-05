<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'company_name' => $this->company_name,
            'type' => $this->type,
            'status' => $this->status,
            'tasks_count' => $this->tasks_count ?? $this->tasks()->count(),
        ];
    }
}
