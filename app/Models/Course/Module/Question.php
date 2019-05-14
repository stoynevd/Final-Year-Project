<?php

namespace App\Models\Course\Module;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'courses_modules_questions';

    protected $fillable = ['module_id', 'type', 'text', 'answers', 'imageServerName'];

    protected $hidden = [];

    protected $casts = [
        'answers' => 'array'
    ];

    public function module() {
        return $this->belongsTo('App\Models\Course\Module');
    }
}
