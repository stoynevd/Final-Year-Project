<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Course\Module;
use App\Models\Course\Module\Question as ModuleQuestion;
use App\Models\Exam;
use App\Models\Exam\Section as ExamSection;
use App\Models\Exam\Question as ExamQuestion;

class DatabaseSeeder extends Seeder
{
    public function run() {
        $admin = User::create([
            'rank'      => 'Admin',
            'email'     => 'dmstoynev@abv.bg',
            'password'  => bcrypt('123456'),
            'name'      => 'Dimitar Stoynev'
        ]);
        $lecturer = User::create([
            'rank'      => 'Lecturer',
            'email'     => 'john@doe.com',
            'password'  => bcrypt('123456'),
            'name'      => 'PhD John Doe'
        ]);
        $course1 = Course::create(['name' => 'Computer Science', 'shortName' => 'CS']);
        $course2 = Course::create(['name' => 'Computer Science & Mathematics', 'shortName' => 'CSM']);
        $module = Module::create([
            'course_id'     => $course1->id,
            'year'          => 1,
            'name'          => 'Basic Programming',
            'lecturer_id'   => $lecturer->id,
        ]);
        Module::create([
            'course_id'     => $course1->id,
            'year'          => 2,
            'name'          => 'Advanced Programming',
            'lecturer_id'   => $lecturer->id,
        ]);
        Module::create([
            'course_id'     => $course1->id,
            'year'          => 3,
            'name'          => 'Object Oriented Programming',
            'lecturer_id'   => $lecturer->id,
        ]);
        Module::create([
            'course_id'     => $course2->id,
            'year'          => 1,
            'name'          => 'Basic Mathematics',
            'lecturer_id'   => $lecturer->id,
        ]);
        Module::create([
            'course_id'     => $course2->id,
            'year'          => 2,
            'name'          => 'Advanced Mathematics',
            'lecturer_id'   => $lecturer->id,
        ]);
        Module::create([
            'course_id'     => $course2->id,
            'year'          => 3,
            'name'          => 'Proficient Mathematics',
            'lecturer_id'   => $lecturer->id,
        ]);
        ModuleQuestion::create([
            'module_id' => $module->id,
            'type'      => 'Gaps',
            'text'      => 'The  [#1] ____ is [#2] ____ and [#3] ____ .',
            'answers'   => []
        ]);
        ModuleQuestion::create([
            'module_id' => $module->id,
            'type'      => 'Multiple',
            'text'      => 'What color is the apple?',
            'answers'   => [['value' => 'Red', 'correct' => true], ['value' => 'Blue', 'correct' => false], ['value' => 'Green', 'correct' => true]]
        ]);
        ModuleQuestion::create([
            'module_id' => $module->id,
            'type'      => 'Open',
            'text'      => 'What color is the truck?',
            'answers'   => []
        ]);
        for($i = 0; $i < 100; $i++) {
            $questionType = rand(1,3);
            if($questionType == 1) { // Gaps
                ModuleQuestion::create([
                    'module_id' => $module->id,
                    'type'      => 'Gaps',
                    'text'      => 'The [#1] ____ is [#2] ____ and [#3] ____ .',
                    'answers'   => []
                ]);
            }
            elseif($questionType == 2) { // Multiple
                $correct = (boolean) rand(0,1);
                ModuleQuestion::create([
                    'module_id' => $module->id,
                    'type'      => 'Multiple',
                    'text'      => 'Which option/s is/are correct?',
                    'answers'   => [['value' => str_random(4), 'correct' => $correct], ['value' => str_random(4), 'correct' => !$correct], ['value' => str_random(4), 'correct' => $correct]]
                ]);
            }
            else { // Open
                ModuleQuestion::create([
                    'module_id' => $module->id,
                    'type'      => 'Open',
                    'text'      => 'What does '.str_random(6).' mean?',
                    'answers'   => []
                ]);
            }
        }
        $exam = Exam::create([
            'module_id'     => $module->id,
            'lecturer_id'   => $lecturer->id,
            'name'          => 'Introduction Test',
            'length'        => '50'
        ]);
        $section1 = ExamSection::create([
            'exam_id' => $exam->id,
            'name'    => 'Section1'
        ]);
        $section2 = ExamSection::create([
            'exam_id' => $exam->id,
            'name'    => 'Section2'
        ]);
        ExamQuestion::create([
            'exam_id'               => $exam->id,
            'section_id'            => $section1->id,
            'module_question_id'    => 1
        ]);
        ExamQuestion::create([
            'exam_id'               => $exam->id,
            'section_id'            => $section1->id,
            'module_question_id'    => 2
        ]);
        ExamQuestion::create([
            'exam_id'               => $exam->id,
            'section_id'            => $section2->id,
            'module_question_id'    => 3
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
