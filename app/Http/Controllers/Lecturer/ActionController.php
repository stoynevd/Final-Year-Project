<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Auth;
use App;
use Storage;
use Validator;
use App\Models\Course\Module\Question as ModuleQuestion;
use App\Models\Exam;
use App\Models\Exam\Question as ExamSectionQuestion;
use App\Models\Exam\Section as ExamSection;

class ActionController extends Controller
{
    public function logout() {
        Auth::logout();
        return redirect('/');
    }
    //Create an Exam
    public function createExam(Request $request) {
        //Validate the input from the view
        $validator = Validator::make($request->all(), [
            'module_id'         => 'bail|required|numeric',
            'numberOfSections'  => 'bail|required|numeric|min:1|max:5',
            'randomQuestions'   => 'bail|required|boolean',
            'sections'          => 'bail|required|array',
            'name'              => 'bail|required',
            'length'            => 'bail|required|numeric|min:10'
        ]);
        //if the validator fails, return an error
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        //Find the Module
        $module = Auth::user()->modules()->where('id', $request->input('module_id'))->first();
        //Check if the module exists
        if(is_null($module)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        //Check if the exam is going to be with Random Questions
        if($request->input('randomQuestions')) {
            $totalQuestions = 0;
            foreach($request->input('sections') as $key => $section) {
                if(is_null($section['name'])) {
                    return response()->json(['success' => false, 'message' => 'Section #'.($key + 1).' has an invalid name.']);
                }
                if(!is_numeric($section['numberOfQuestions']) || $section['numberOfQuestions'] <= 0) {
                    return response()->json(['success' => false, 'message' => 'Section #'.($key + 1).' has an invalid number of questions.']);
                }
                $totalQuestions += $section['numberOfQuestions'];
            }
            if($totalQuestions > $module->questions()->count()) {
                return response()->json(['success' => false, 'message' => 'Not enough questions (Have: '.$module->questions()->count().', Needed: '.$totalQuestions.').']);
            }
            //Create the Exam
            $exam = Exam::create([
                'module_id'     => $module->id,
                'lecturer_id'   => Auth::user()->id,
                'name'          => $request->input('name'),
                'length'        => $request->input('length')
            ]);
            $questions = $module->questions()->inRandomOrder()->take($totalQuestions)->get();
            $counter = 0;
            foreach($request->input('sections') as $section) {
                $examSection = ExamSection::create([
                    'exam_id'   => $exam->id,
                    'name'      => $section['name']
                ]);
                for($i = 0; $i < $section['numberOfQuestions']; $i++) {
                    ExamSectionQuestion::create([
                        'exam_id'            => $exam->id,
                        'section_id'         => $examSection->id,
                        'module_question_id' => $questions[$counter]->id
                    ]);
                    $counter++;
                }
            }
        }
        else {
            foreach($request->input('sections') as $key => $section) {
                if(is_null($section['name'])) {
                    return response()->json(['success' => false, 'message' => 'Section #'.($key + 1).' has an invalid name.']);
                }
                if(count($section['questions']) <= 0) {
                    return response()->json(['success' => false, 'message' => 'Section #'.($key + 1).' has 0 questions.']);
                }
                foreach($section['questions'] as $key2 => $question) {
                    $checkQuestion = ModuleQuestion::find($question['id']);
                    if(is_null($checkQuestion) || $checkQuestion->module_id != $module->id) {
                        return response()->json(['success' => false, 'message' => 'Section #'.($key + 1).', Question #'.($key2 + 1).' not found.']);
                    }
                }
            }
            $exam = Exam::create([
                'module_id'     => $module->id,
                'lecturer_id'   => Auth::user()->id,
                'name'          => $request->input('name'),
                'length'        => $request->input('length')
            ]);
            foreach($request->input('sections') as $section) {
                $examSection = ExamSection::create([
                    'exam_id'   => $exam->id,
                    'name'      => $section['name']
                ]);
                foreach($section['questions'] as $key2 => $question) {
                    ExamSectionQuestion::create([
                        'exam_id'            => $exam->id,
                        'section_id'         => $examSection->id,
                        'module_question_id' => $question['id']
                    ]);
                }
            }
        }
        return response()->json(['success' => true]);
    }
    //Delete the Exam
    public function deleteExam(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'        => 'bail|required|numeric',
            'module_id' => 'bail|required|numeric'
        ]);
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        $module = Auth::user()->modules()->where('id', $request->input('module_id'))->first();
        if(is_null($module)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        $exam = $module->exams()->where('id', $request->input('id'))->first();
        if(is_null($exam)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        $exam->delete();
        return response()->json(['success' => true, 'message' => 'You have successfully deleted the specified question.']);
    }

    public function updateExam(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'        => 'bail|required|numeric',
            'module_id' => 'bail|required|numeric',
            'name'      => 'bail|required',
            'length'    => 'bail|required|numeric|min:10'
        ]);
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        $exam = Auth::user()->exams()->where('id', $request->input('id'))->first();
        if(is_null($exam)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        if(Auth::user()->modules()->where('id', $request->input('module_id'))->count() == 0) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        $exam->update([
            'module_id' => $request->input('module_id'),
            'name'      => $request->input('name'),
            'length'    => $request->input('length')
        ]);
        return response()->json(['success' => true, 'message' => 'You have successfully updated the specified exam.']);
    }

    public function removeQuestionFromExam(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'        => 'bail|required|numeric',
            'exam_id'   => 'bail|required|numeric'
        ]);
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        $exam = Auth::user()->exams()->where('id', $request->input('exam_id'))->first();
        if(is_null($exam)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        $question = $exam->questions()->where('id', $request->input('id'))->first();
        if(is_null($question)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        $question->delete();
        return response()->json(['success' => true, 'message' => 'You have successfully removed the specified question from the exam.']);
    }

    public function addQuestionToExam(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'            => 'bail|required|numeric',
            'module_id'     => 'bail|required|numeric',
            'exam_id'       => 'bail|required|numeric',
            'section_id'    => 'bail|required|numeric'
        ]);
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        $module = Auth::user()->modules()->where('id', $request->input('module_id'))->first();
        if(is_null($module)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        $question = $module->questions()->where('id', $request->input('id'))->first();
        if(is_null($question)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        $exam = Auth::user()->exams()->where('id', $request->input('exam_id'))->first();
        if(is_null($exam)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        $section = $exam->sections()->where('id', $request->input('section_id'))->first();
        if(is_null($section)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        if($exam->questions()->where('module_question_id', $question->id)->count() > 0) {
            return response()->json(['success' => false, 'message' => 'You have already added this question to the exam.']);
        }
        $addedQuestion = ExamSectionQuestion::create([
            'exam_id'            => $exam->id,
            'section_id'         => $section->id,
            'module_question_id' => $question->id
        ]);
        return response()->json(['success' => true, 'message' => 'You have successfully removed the specified question from the exam.', 'addedQuestion' => $addedQuestion->load('moduleQuestion')]);
    }

    public function createQuestion(Request $request) {
        $validator = Validator::make($request->all(), [
            'module_id' => 'bail|required|numeric',
            'type'      => 'bail|required|in:Gaps,Multiple,Open',
            'text'      => 'bail|required',
            'image'     => 'bail|sometimes|nullable|image'
        ]);
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        $module = Auth::user()->modules()->where('id', $request->input('module_id'))->first();
        if(is_null($module)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        if($request->input('type') == 'Gaps') {
            $question = ModuleQuestion::create([
                'module_id' => $module->id,
                'type'      => 'Gaps',
                'text'      => $request->input('text'),
                'answers'   => []
            ]);
        }
        elseif($request->input('type') == 'Multiple') {
            $answers = [];
            $correctAnswers = 0;
            foreach(json_decode($request->input('answers')) as $answer) {
                if(!is_null($answer->value) && is_bool($answer->correct)) {
                    if($answer->correct) {
                        $correctAnswers++;
                    }
                    $answers[] = ['value' => $answer->value, 'correct' => $answer->correct];
                }
            }
            if(count($answers) <= 1) {
                return response()->json(['success' => false, 'message' => 'You need at least 2 answers.']);
            }
            if($correctAnswers == 0) {
                return response()->json(['success' => false, 'message' => 'You need at least one correct answer.']);
            }
            $question = ModuleQuestion::create([
                'module_id' => $module->id,
                'type'      => 'Multiple',
                'text'      => $request->input('text'),
                'answers'   => $answers
            ]);
        }
        elseif($request->input('type') == 'Open') {
            $question = ModuleQuestion::create([
                'module_id' => $module->id,
                'type'      => 'Open',
                'text'      => $request->input('text'),
                'answers'   => []
            ]);
        }
        else {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        if(!is_null($request->file('image'))) {
            $path = $request->file('image')->store('uploads');
            $question->update(['imageServerName' => explode('/', $path)[1]]);
        }
        return response()->json(['success' => true]);
    }

    public function deleteQuestion(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'        => 'bail|required|numeric',
            'module_id' => 'bail|required|numeric'
        ]);
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        $module = Auth::user()->modules()->where('id', $request->input('module_id'))->first();
        if(is_null($module)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        $question = $module->questions()->where('id', $request->input('id'))->first();
        if(is_null($question)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        Storage::delete('uploads/'.$question->imageServerName);
        $question->delete();
        return response()->json(['success' => true, 'message' => 'You have successfully deleted the specified question.']);
    }

    public function updateQuestion(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'        => 'bail|required|numeric',
            'module_id' => 'bail|required|numeric',
            'type'      => 'bail|required|in:Gaps,Multiple,Open',
            'text'      => 'bail|required',
            'image'     => 'bail|sometimes|nullable|image'
        ]);
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        $question = ModuleQuestion::find($request->input('id'));
        if(is_null($question) || $question->module->lecturer_id != Auth::user()->id) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        if($question->module_id != $request->input('module_id')) {
            $module = Auth::user()->modules()->where('id', $request->input('module_id'))->first();
            if(is_null($module)) {
                return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
            }
        }
        if($request->input('type') == 'Gaps') {
            $question->update([
                'module_id' => $request->input('module_id'),
                'type'      => 'Gaps',
                'text'      => $request->input('text'),
                'answers'   => []
            ]);
        }
        elseif($request->input('type') == 'Multiple') {
            $answers = [];
            $correctAnswers = 0;
            foreach(json_decode($request->input('answers')) as $answer) {
                if(!is_null($answer->value) && is_bool($answer->correct)) {
                    if($answer->correct) {
                        $correctAnswers++;
                    }
                    $answers[] = ['value' => $answer->value, 'correct' => $answer->correct];
                }
            }
            if(count($answers) <= 1) {
                return response()->json(['success' => false, 'message' => 'You need at least 2 answers.']);
            }
            if($correctAnswers == 0) {
                return response()->json(['success' => false, 'message' => 'You need at least one correct answer.']);
            }
            $question->update([
                'module_id' => $request->input('module_id'),
                'type'      => 'Multiple',
                'text'      => $request->input('text'),
                'answers'   => $answers
            ]);
        }
        elseif($request->input('type') == 'Open') {
            $question->update([
                'module_id' => $request->input('module_id'),
                'type'      => 'Open',
                'text'      => $request->input('text'),
                'answers'   => []
            ]);
        }
        else {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        $imageUrl = null;
        if(!is_null($request->file('image'))) {
            Storage::delete('uploads/'.$question->imageServerName);
            $path = $request->file('image')->store('uploads');
            $question->update(['imageServerName' => explode('/', $path)[1]]);
            $imageUrl = Storage::url($path);
        }
        return response()->json(['success' => true, 'message' => 'You have successfully updated the specified question.', 'imageUrl' => $imageUrl]);
    }

    public function removeImageFromQuestion(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'        => 'bail|required|numeric',
            'module_id' => 'bail|required|numeric'
        ]);
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        $module = Auth::user()->modules()->where('id', $request->input('module_id'))->first();
        if(is_null($module)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        $question = $module->questions()->where('id', $request->input('id'))->first();
        if(is_null($question)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        Storage::delete('uploads/'.$question->imageServerName);
        $question->update(['imageServerName' => null]);
        return response()->json(['success' => true, 'message' => 'You have successfully deleted the specified question image.']);
    }

    public function exportExam($id, $type) {
        $exam = Auth::user()->exams()->where('id', $id)->first();
        if(is_null($exam)) {
            return redirect('/dashboard');
        }
        $html = view('exports.exam', ['exam' => $exam->load('sections.questions.moduleQuestion')])->render();
        if($type == 'pdf') {
            $pdf = App::make('dompdf.wrapper');
            return $pdf->loadHTML($html)->download('Exam.pdf');
        }
        else {
            $headers = array(
                "Content-type"          => "text/html",
                "Content-Disposition"   => "attachment;Filename=Exam.doc"
            );
            return \Response::make($html, 200, $headers);
        }
    }
}
