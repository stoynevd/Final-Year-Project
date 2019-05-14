<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('rank', ['Admin', 'Lecturer'])->default('Lecturer');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name')->unique();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
    }
}
