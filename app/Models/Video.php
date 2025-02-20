<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Video extends Model
{
    protected $fillable = [
        'title',
        'description',
        'video',
        'slug',
        'course_id',
        'order',
        'opened'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($video) {
            $video->slug = static::generateUniqueSlug($video->title);
        });

        static::updating(function ($video) {
            $video->slug = static::generateUniqueSlug($video->title);
        });
    }
    private static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $count = Video::where('slug', 'LIKE', "{$slug}%")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getVideoUrlAttribute()
    {
        return env('APP_IMAGES_URL').$this->video;
    }

}
