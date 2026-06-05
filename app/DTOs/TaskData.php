<?php

namespace App\DTOs;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Carbon\CarbonInterface;

readonly class TaskData
{
    public function __construct(
        public string $title,
        public ?string $description,
        public TaskPriority $priority,
        public ?TaskStatus $status,
        public ?int $assignedEmployeeId,
        public ?int $customerId,
        public ?int $departmentId,
        public ?CarbonInterface $deadlineAt,
        public int $progress = 0,
        public ?array $checklist = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'] ?? null,
            priority: TaskPriority::from($data['priority'] ?? TaskPriority::Medium->value),
            status: isset($data['status']) ? TaskStatus::from($data['status']) : null,
            assignedEmployeeId: $data['assigned_employee_id'] ?? null,
            customerId: $data['customer_id'] ?? null,
            departmentId: $data['department_id'] ?? null,
            deadlineAt: isset($data['deadline_at']) ? now()->parse($data['deadline_at']) : null,
            progress: (int) ($data['progress'] ?? 0),
            checklist: $data['checklist'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority->value,
            'status' => $this->status?->value,
            'assigned_employee_id' => $this->assignedEmployeeId,
            'customer_id' => $this->customerId,
            'department_id' => $this->departmentId,
            'deadline_at' => $this->deadlineAt,
            'progress' => $this->progress,
        ];
    }
}
