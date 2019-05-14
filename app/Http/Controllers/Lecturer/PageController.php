<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Auth;
use Storage;

class PageController extends Controller
{
    public function showDashboard() {
        $data['modulesCount'] = Auth::user()->modules()->count();
        $data['examsCount'] = Auth::user()->exams()->count();
        $data['questionsCount'] = Auth::user()->exams()->count();
        foreach(Auth::user()->modules as $module) {
            $data['questionsCount'] += $module->questions()->count();
        }
        return view('public/lecturer/dashboard/dashboard')->with(['data' => $data]);
    }

    public function showModules() {
        return view('public/lecturer/modules/modules')->with(['modules' => Auth::user()->modules]);
    }

    public function showModule($id) {
        $module = Auth::user()->modules()->where('id', $id)->first();
        if(is_null($module)) {
            return redirect('/modules');
        }
        $data['moduleName'] = $module->course->shortName.'-'.$module->id.' '.$module->name;
        $data['examsCount'] = $module->exams()->count();
        $data['questionsCount'] = $module->questions()->count();
        $data['averageExamLength'] = $module->exams()->sum('length') / $data['examsCount'];
        $data['averageExamQuestions'] = 0;
        foreach($module->exams as $exam) {
            $data['averageExamQuestions'] += $exam->questions()->count();
        }
        $data['averageExamQuestions'] = $data['averageExamQuestions'] / $data['examsCount'];
        return view('public/lecturer/modules/module')->with(['module' => $module->load('course'), 'data' => $data]);
    }

    public function showModuleExams($id) {
        $module = Auth::user()->modules()->where('id', $id)->first();
        if(is_null($module)){
            return redirect('/dashboard');
        }
        return view('public/lecturer/modules/module_exams')->with(['module' => $module->load('exams.lecturer')]);
    }

    public function showModuleExam($id, $examId) {
        $module = Auth::user()->modules()->where('id', $id)->first();
        if(is_null($module)) {
            return redirect('/dashboard');
        }
        $exam = $module->exams()->where('id', $examId)->first();
        if(is_null($exam)) {
            return redirect('/modules/'.$module->id.'/exams');
        }
        return view('public/lecturer/modules/module_exam')->with(['module' => $module, 'exam' => $exam->load('sections.questions.moduleQuestion', 'questions'), 'modules' => Auth::user()->modules->load('course')]);
    }

    public function showModuleQuestions($id) {
        $module = Auth::user()->modules()->where('id', $id)->first();
        if(is_null($module)) {
            return redirect('/dashboard');
        }
        return view('public/lecturer/modules/module_questions')->with(['module' => $module->load('questions')]);
    }

    public function showModuleQuestion($id, $questionId) {
        $module = Auth::user()->modules()->where('id', $id)->first();
        if(is_null($module)) {
            return redirect('/modules');
        }
        $question = $module->questions()->where('id', $questionId)->first();
        if(is_null($question)) {
            return redirect('/modules/'.$id.'/questions');
        }
        $question['imageUrl'] = null;
        if(!is_null($question->imageServerName)) {
            $question['imageUrl'] = Storage::url('uploads/'.$question->imageServerName);
        }
        return view('public/lecturer/modules/module_question')->with(['question' => $question, 'modules' => Auth::user()->modules->load('course')]);
    }

    public function showNewQuestion() {
        return view('public/lecturer/new_question')->with(['modules' => Auth::user()->modules->load('course')]);
    }

    public function showNewExam() {
        return view('public/lecturer/new_exam')->with(['modules' => Auth::user()->modules->load('course', 'questions')]);
    }

    public function printExam($id, $type) {
        $exam = Auth::user()->exams()->where('id', $id)->first();
        if(is_null($exam)) {
            return redirect('/dashboard');
        }
        if($type == 'questions') {
            return view('prints/exam-questions')->with(['exam' => $exam->load('sections.questions.moduleQuestion')]);
        }
        elseif($type == 'questionsAnswers') {
            return view('prints/exam-questionsAnswers')->with(['exam' => $exam->load('sections.questions.moduleQuestion')]);
        }
        elseif($type == 'answers') {
            return view('prints/exam-answers')->with(['exam' => $exam->load('sections.questions.moduleQuestion')]);
        }
        return redirect('/modules/'.$exam->module_id.'/exams/'.$exam->id);
    }
}
