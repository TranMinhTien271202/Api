<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SRoomController extends Controller
{
    public function index(Request $request){
        return view('student.room.index');
    }
}
