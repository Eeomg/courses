<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Student extends Model
{
    use HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    public function courses()
    {
        return $this->belongsToMany(
            Course::class,
            'student_courses',
            'student_id',
            'course_id'
        )->with(['videos','pdfs']);
    }

    public function cart()
    {
        return $this->belongsToMany(Course::class, 'carts', 'student_id', 'course_id');
    }

}
