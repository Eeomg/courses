<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursesOrders extends Model
{
    protected $fillable = [
        'course_id',
        'order_id',
        'price',
        'title',
        'cover'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
