<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Document extends Model implements HasMedia
{
    use BelongsToCompany;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = ['company_id', 'uploaded_by', 'documentable_type', 'documentable_id', 'disk', 'path', 'original_name', 'mime_type', 'size', 'version', 'tags', 'permissions'];

    protected function casts(): array
    {
        return ['tags' => 'array', 'permissions' => 'array'];
    }

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }
}
