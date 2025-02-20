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
            $category->slug = static::generateUniqueSlug($category->name);
        });
    }

    private static function generateUniqueSlug($name)
    {
        return Str::slug($name);
    }


    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function getCoverUrlAttribute()
    {
        return env('APP_IMAGES_URL').$this->cover;
    }

}

