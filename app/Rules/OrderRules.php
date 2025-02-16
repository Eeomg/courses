<?php

namespace App\Rules;

use App\Models\Video;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OrderRules implements ValidationRule
{
    public $course_id;
    public $video_id;
    public function __construct($course_id,$video_id = null)
    {
        $this->course_id = $course_id;
        $this->video_id = $video_id;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = Video::where('course_id',$this->course_id)->where('order',$value);

        if($this->video_id)
        {
            $query->where('id','<>',$this->video_id);
        }

        if($query->exists()){
            $fail('this order already exists.');
        }

    }
}
