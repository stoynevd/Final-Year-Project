<?php

namespace App\Http\Controllers\All;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function showLanding() {
        return view('public/all/landing');
    }
}
