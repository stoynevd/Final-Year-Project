<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = ['name', 'shortName'];

    protected $hidden = [];

    public function modules() {
        return $this->hasMany('App\Models\Course\Module');
    }
}
