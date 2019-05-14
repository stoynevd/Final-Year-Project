<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function showRegister() {
        return view('public/guest/register');
    }

    public function showLogin() {
        return view('public/guest/login');
    }

    public function showForgottenPassword() {
        return view('public/guest/forgotten_password');
    }
}
