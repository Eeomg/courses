<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    public $fillable = [
        'name',
        'image'
    ];

    public function getImageUrlAttribute()
    {
        return env('APP_IMAGES_URL').$this->image;
    }
}
