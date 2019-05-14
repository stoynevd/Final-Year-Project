<?php

namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'exams_sections_questions';

    protected $fillable = ['exam_id', 'section_id', 'module_question_id'];

    protected $hidden = [];

    public static $snakeAttributes = false;

    public function exam() {
        return $this->belongsTo('App\Models\Exam');
    }

    public function section() {
        return $this->belongsTo('App\Models\Exam\Section');
    }

    public function moduleQuestion() {
        return $this->belongsTo('App\Models\Course\Module\Question');
    }
}
