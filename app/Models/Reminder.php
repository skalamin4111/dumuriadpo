<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reminder extends Model
{
    use BelongsToCompany;

    public const SERVICES = [
        'bank-asia' => 'Bank Asia',
        'lsfc' => 'LSFC',
        'computer-training' => 'Computer Training',
        'digital-services' => 'Digital Services',
    ];

    public const CONTACT_TYPES = [
        'office_visit' => 'Office visit',
        'phone_call' => 'Phone call',
        'other' => 'Other',
    ];

    protected $fillable = [
        'company_id',
        'task_id',
        'customer_id',
        'user_id',
        'title',
        'service_section',
        'contact_type',
        'purpose',
        'follow_up_notes',
        'remind_at',
        'is_sent',
        'status',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'remind_at' => 'datetime',
            'is_sent' => 'boolean',
            'completed_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function officer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function getServiceLabelAttribute(): string
    {
        return self::SERVICES[$this->service_section] ?? 'General service';
    }

    public function getContactTypeLabelAttribute(): string
    {
        return self::CONTACT_TYPES[$this->contact_type] ?? 'Other';
    }
}
