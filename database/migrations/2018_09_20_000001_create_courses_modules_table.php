<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesModulesTable extends Migration
{
    public function up() {
        Schema::create('courses_modules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id');
            $table->integer('year');
            $table->string('name');
            $table->unsignedInteger('lecturer_id');
            $table->timestamps();
            // Keys //
            $table->foreign('course_id')->references('id')->on('courses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('lecturer_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
        DB::statement("ALTER TABLE courses_modules AUTO_INCREMENT = 1001;");
    }

    public function down() {
        Schema::dropIfExists('courses_modules');
    }
}
