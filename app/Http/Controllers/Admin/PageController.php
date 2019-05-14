<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Course\Module;
use App\Models\User;

class PageController extends Controller
{
    public function showDashboard() {
        $data['modulesCount'] = Module::all()->count();
        $data['lecturersCount'] = User::where('rank', 'Lecturer')->get()->count();
        $data['courses'] = Course::all()->count();
        return view('public/admin/dashboard/dashboard')->with(['data' => $data]);
    }

    public function showLecturers() {
        return view('public/admin/lecturers/lecturers')->with(['lecturers' => User::where('rank', 'Lecturer')->get()->load('modules.course')]);
    }

    public function showAdmins() {
        return view('public/admin/admins/admins')->with(['admins' => User::where('rank', 'Admin')->get()]);
    }

    public function showNewLecturer() {
        return view('public/admin/lecturers/new');
    }

    public function showLecturer($id) {
        $lecturer = User::where('rank', 'Lecturer')->where('id', $id)->first();
        if(is_null($lecturer)) {
            return redirect('/lecturers');
        }
        return view('public/admin/lecturers/lecturer')->with(['lecturer' => $lecturer]);
    }

    public function showNewAdmin() {
        return view('public/admin/admins/new');
    }

    public function showCourses() {
        return view('public/admin/courses/courses')->with(['courses' => Course::all()]);
    }

    public function showNewCourse() {
        return view('public/admin/courses/new');
    }

    public function showCourse($id) {
        $course = Course::where('id', $id)->first();
        if(is_null($course)) {
            return redirect('/courses');
        }
        return view('public/admin/courses/course')->with(['course' => $course]);
    }

    public function showModules() {
        return view('public/admin/modules/modules')->with(['modules' => Module::all()->load('course', 'lecturer')]);
    }

    public function showNewModule() {
        return view('public/admin/modules/new')->with(['courses' => Course::all(), 'lecturers' => User::where('rank', 'Lecturer')->get()]);
    }

    public function showModule($id) {
        $module = Module::where('id', $id)->first();
        if(is_null($module)) {
            return redirect('/modules');
        }
        return view('public/admin/modules/module')->with(['module' => $module->load('course', 'lecturer'), 'courses' => Course::all(), 'lecturers' => User::where('rank', 'Lecturer')->get()]);
    }
}
