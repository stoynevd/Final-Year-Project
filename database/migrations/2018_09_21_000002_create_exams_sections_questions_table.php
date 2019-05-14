<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsSectionsQuestionsTable extends Migration
{
    public function up() {
        Schema::create('exams_sections_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('exam_id');
            $table->unsignedInteger('section_id');
            $table->unsignedInteger('module_question_id');
            $table->timestamps();
            // Keys //
            $table->foreign('exam_id')->references('id')->on('exams')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('exams_sections')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('module_question_id')->references('id')->on('courses_modules_questions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('exams_sections_questions');
    }
}
