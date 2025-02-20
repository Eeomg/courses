<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'student_id',
        'total_price',
        'phone',
        'checked',
        'payment_id',
        'reset'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function courses()
    {
        return $this->belongsToMany(
            Course::class,
            'courses_orders',
            'order_id',
            'course_id'
        );
    }

    public function getResetUrlAttribute()
    {
        return env('APP_IMAGES_URL').$this->reset;
    }
}
