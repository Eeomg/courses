<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'cover', 'slug'];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = static::generateUniqueSlug($category->title);
        });
    }

    private static function generateUniqueSlug($title)
    {
        return Str::slug($title);
    }


    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function getCoverUrlAttribute()
    {
        return env('APP_URL') .'/images/'.$this->cover;
    }

}

