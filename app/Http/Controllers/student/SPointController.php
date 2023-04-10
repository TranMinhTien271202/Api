<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SPointController extends Controller
{
    public function index(Request $request){
        return view('student.point.index');
    }
}
