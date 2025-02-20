<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panner extends Model
{
    protected $fillable = [
        'name',
        'panner'
    ];

    public function getPannerUrlAttribute()
    {
        return env('APP_IMAGES_URL').$this->panner;
    }

}
