<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Course;
use App\Models\Course\Module;
use App\Models\User;

class ActionController extends Controller
{
    public function logout() {
        Auth::logout();
        return redirect('/');
    }
    //Adding a new lecturer to the system
    public function createLecturer(Request $request) {
        //Validating the input from the view
        $validator = Validator::make($request->all(), [
            'name'      =>  'bail|required|unique:users|max:191',
            'email'     =>  'bail|required|email|unique:users|max:191',
            'password'  =>  'bail|required|min:6|max:32'
        ]);
        //if the validator fails, return an error
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        //create the Lecturer
        $user = User::create([
            'rank'      => 'Lecturer',
            'email'     => $request->input('email'),
            'password'  => bcrypt($request->input('password')),
            'name'      => $request->input('name')
        ]);
        //And return a success boolean
        return response()->json(['success' => true]);
    }
    //Delete a selected lecturer
    public function deleteLecturer(Request $request) {
        //Validate the input from the view
        $validator = Validator::make($request->all(), [
            'id'        => 'bail|required|numeric'
        ]);
        //if the validator fails, return an error
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        //Find the lecturer by the id returned from the view
        $lecturer = User::where('rank', 'Lecturer')->where('id', $request->id);
        //If the lecturer does not exist
        if(is_null($lecturer)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        //Delete the lecturer
        $lecturer->delete();
        return response()->json(['success' => true, 'message' => 'You have successfully deleted the specified question.']);
    }
    //Update the lecturer
    public function updateLecturer(Request $request) {
        //Validate the input from the view
        $validator = Validator::make($request->all(), [
            'name'      =>  'bail|required|max:191',
            'email'     =>  'bail|required|email|exists:users|max:191',
        ]);
        //if the validator fails, return an error
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        //Find the lecturer from the database
        $lecturer = User::where('rank', 'Lecturer')->where('id', $request->id)->first();
        //Check if the lecturer exists
        if(is_null($lecturer)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        //Update the Lecturer
        $lecturer->update([
            'rank'      => 'Lecturer',
            'email'     => isset($lecturer) ? $request->input('email') : $lecturer->email,
            'password'  => $lecturer->password,
            'name'      => $request->input('name')
        ]);
        return response()->json(['success' => true, 'message' => 'You have successfully updated the Course.']);
    }
    //Create a new Admin
    public function createAdmin(Request $request) {
        //Validate the input from the view
        $validator = Validator::make($request->all(), [
            'name'      =>  'bail|required|unique:users|max:191',
            'email'     =>  'bail|required|email|unique:users|max:191',
            'password'  =>  'bail|required|min:6|max:32'
        ]);
        //if the validator fails, return an error
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        //Create the new admin
        $user = User::create([
            'rank'      => 'Admin',
            'email'     => $request->input('email'),
            'password'  => bcrypt($request->input('password')),
            'name'      => $request->input('name')
        ]);
        return response()->json(['success' => true]);
    }
    //Creating a new course
    public function createCourse(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'      =>  'bail|required|max:191',
            'shortName' =>  'bail|required|min:2|max:4'
        ]);
        //if the validator fails, return an error
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        //Create the course
        Course::create($request->all());
        return response()->json(['success' => true]);
    }
    //Delete the course
    public function deleteCourse(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'        => 'bail|required|numeric'
        ]);
        //if the validator fails, return an error
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        //Find the course
        $course = Course::where('id', $request->id);
        //Check if the course actually exists
        if(is_null($course)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        //Delete the course
        $course->delete();
        return response()->json(['success' => true, 'message' => 'You have successfully deleted the specified question.']);
    }
    //Update a selected course
    public function updateCourse(Request $request) {
        //Validate the input from the view
        $validator = Validator::make($request->all(), [
            'id'            => 'bail|required|numeric',
            'name'          => 'bail|required|max:191',
            'shortName' =>  'bail|required|min:2|max:4'
        ]);
        //if the validator fails, return an error
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        //Find the course from the database
        $course = Course::find($request->input('id'))->first();
        //Check if the course exists
        if(is_null($course)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        //Update the course
        $course->update([
            'name'          => $request->input('name'),
            'shortName'     => $request->input('shortName')
        ]);
        return response()->json(['success' => true, 'message' => 'You have successfully updated the Course.']);
    }
    //Deleting a Module
    public function deleteModule(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'        => 'bail|required|numeric'
        ]);
        //if the validator fails, return an error
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        //Find the Module in the database
        $module = Module::where('id', $request->id);
        //Check if the Module exists
        if(is_null($module)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        //Delete the module
        $module->delete();
        return response()->json(['success' => true, 'message' => 'You have successfully deleted the specified question.']);
    }
    //Create the Module
    public function createModule(Request $request) {
        //Validate the input from the view
        $validator = Validator::make($request->all(), [
            'course_id'     => 'bail|required|numeric',
            'name'          => 'bail|required|max:191',
            'year'          => 'bail|required|numeric|min:1|max:4',
            'lecturer_id'   => 'bail|required|numeric'
        ]);
        //if the validator fails, return an error
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        //Find the Course
        $course = Course::find($request->input('course_id'));
        //Check if the course exists
        if(is_null($course)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        //Check if the lecturer exists
        $lecturer = User::find($request->input('lecturer_id'));
        if(is_null($lecturer) || $lecturer->rank == 'Admin') {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        //Create the Module
        Module::create([
            'course_id'     => $course->id,
            'year'          => $request->input('year'),
            'name'          => $request->input('name'),
            'lecturer_id'   => $lecturer->id
        ]);
        return response()->json(['success' => true]);
    }
    //Updating a Module
    public function updateModule(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'            => 'bail|required|numeric',
            'course_id'     => 'bail|required|numeric',
            'name'          => 'bail|required|max:191',
            'year'          => 'bail|required|numeric|min:1|max:4',
            'lecturer_id'   => 'bail|required|numeric'
        ]);
        //if the validator fails, return an error
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        //Find the Module
        $module = Module::find($request->input('id'));
        //Check if the Module exists
        if(is_null($module)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
        }
        //Check if the course is changed
        if($module->course_id != $request->input('course_id')){
            $course = Course::find($request->input('course_id'));
            if(is_null($course)) {
                return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
            }
        }
        //Check if the lecturer exists
        if($module->lecturer_id != $request->input('lecturer_id')){
            $lecturer = User::find($request->input('lecturer_id'));
            if(is_null($lecturer) || $lecturer->rank == 'Admin') {
                return response()->json(['success' => false, 'message' => 'Something went wrong. Please, try again later.']);
            }
        }
        //Update module
        $module->update([
            'course_id'     => isset($course) ? $course->id : $module->course_id,
            'year'          => $request->input('year'),
            'name'          => $request->input('name'),
            'lecturer_id'   => isset($lecturer) ? $lecturer->id : $module->lecturer_id
        ]);
        return response()->json(['success' => true, 'message' => 'You have successfully updated the Module.']);
    }

}
