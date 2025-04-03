<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public $timestamps = false;

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

}
