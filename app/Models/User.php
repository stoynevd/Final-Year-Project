<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = ['rank', 'email', 'password', 'name'];

    protected $hidden = ['password', 'remember_token'];

    public function modules() {
        return $this->hasMany('App\Models\Course\Module', 'lecturer_id');
    }

    public function exams() {
        return $this->hasMany('App\Models\Exam', 'lecturer_id');
    }
}
