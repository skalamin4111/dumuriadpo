<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class ComputerTrainingNotice extends Model
{
    use BelongsToCompany;

    protected $fillable = [
        'company_id',
        'title',
        'body',
        'publish_date',
        'audience',
        'is_active',
        'image_path',
        'target_course',
        'target_batch_id',
        'target_student_id',
    ];

    protected function casts(): array
    {
        return [
            'publish_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function batch()
    {
        return $this->belongsTo(ComputerTrainingBatch::class, 'target_batch_id');
    }

    public function student()
    {
        return $this->belongsTo(ComputerTrainingStudent::class, 'target_student_id');
    }
}
