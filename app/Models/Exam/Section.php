<?php

namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'exams_sections';

    protected $fillable = ['exam_id', 'name'];

    protected $hidden = [];

    public function exam() {
        return $this->belongsTo('App\Models\Exam');
    }

    public function questions() {
        return $this->hasMany('App\Models\Exam\Question');
    }
}
