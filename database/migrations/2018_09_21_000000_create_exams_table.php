<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTable extends Migration
{
    public function up() {
        Schema::create('exams', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('module_id');
            $table->unsignedInteger('lecturer_id');
            $table->longText('name');
            $table->integer('length');
            $table->timestamps();
            // Keys //
            $table->foreign('module_id')->references('id')->on('courses_modules')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('lecturer_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('exams');
    }
}
