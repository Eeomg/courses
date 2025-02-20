<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $fillable = [
        'name',
        'description',
        'phone'
    ];


    public function getCoverUrlAttribute()
    {
        return env('APP_IMAGES_URL') . $this->cover;
    }
}
