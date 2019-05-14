<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesModulesQuestionsTable extends Migration
{
    public function up() {
        Schema::create('courses_modules_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('module_id');
            $table->enum('type', ['Gaps', 'Multiple', 'Open']);
            $table->longText('text');
            $table->longText('answers')->nullable();
            $table->longText('imageServerName')->nullable();
            $table->timestamps();
            // Keys //
            $table->foreign('module_id')->references('id')->on('courses_modules')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('courses_modules_questions');
    }
}
