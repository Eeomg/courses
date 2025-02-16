<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentsCourses extends Model
{
    protected $table = 'student_courses';
    public $fillable = ['student_id', 'course_id', 'activated'];



}
