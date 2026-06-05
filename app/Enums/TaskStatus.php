<?php

namespace App\Enums;

enum TaskStatus: string
{
    case New = 'new';
    case Assigned = 'assigned';
    case InProgress = 'in_progress';
    case OnHold = 'on_hold';
    case PendingReview = 'pending_review';
    case PendingApproval = 'pending_approval';
    case Completed = 'completed';
    case Rejected = 'rejected';
    case Cancelled = 'cancelled';
    case Overdue = 'overdue';

    public function label(): string
    {
        return str($this->value)->replace('_', ' ')->title()->toString();
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
