<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{


    protected $fillable = [
        'title',
        'user_id',
        'description',
        'slug',
        'category_id',
        'cover',
        'price',
        'status'
    ];

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_courses','course_id','student_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function boot()
    {
        parent::boot();

        static::creating(function ($course) {
            $course->slug = static::generateUniqueSlug($course->title);
        });
    }
    private static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $count = Course::where('slug', 'LIKE', "{$slug}%")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    public function getCoverUrlAttribute($value)
    {
        return env('APP_IMAGES_URL'). $this->cover;
    }
}
