<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exams';

    protected $fillable = ['module_id', 'lecturer_id', 'name', 'length'];

    protected $hidden = [];

    protected $appends = ['sectionsCount', 'questionsCount'];

    public function module() {
        return $this->belongsTo('App\Models\Course\Module');
    }

    public function lecturer() {
        return $this->belongsTo('App\Models\User');
    }

    public function sections() {
        return $this->hasMany('App\Models\Exam\Section');
    }

    public function questions() {
        return $this->hasMany('App\Models\Exam\Question');
    }

    public function getSectionsCountAttribute() {
        return $this->sections()->count();
    }

    public function getQuestionsCountAttribute() {
        return $this->questions()->count();
    }
}
