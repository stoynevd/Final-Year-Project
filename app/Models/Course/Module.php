<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'courses_modules';

    protected $fillable = ['course_id', 'year', 'name', 'lecturer_id'];

    protected $hidden = [];

    public function course() {
        return $this->belongsTo('App\Models\Course');
    }

    public function lecturer() {
        return $this->belongsTo('App\Models\User');
    }

    public function exams() {
        return $this->hasMany('App\Models\Exam');
    }
    
    public function questions() {
        return $this->hasMany('App\Models\Course\Module\Question');
    }
}
