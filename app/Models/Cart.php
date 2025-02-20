<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Cart extends pivot
{

    protected $table = 'carts';

    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = null;

    protected $fillable = ['student_id', 'course_id'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
