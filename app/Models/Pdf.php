<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pdf extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file',
        'course_id',
        'video_id'
    ];


    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function getFileUrlAttribute()
    {
        return env('APP_IMAGES_URL').$this->file;
    }
}
