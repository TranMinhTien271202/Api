<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function nofiti($id){
        // $nofiti = Notification::where('student_id', auth('student')->user()->id)->get();
        $nofiti = Notification::find($id)->update(['status' => 1]);
        // dd($nofiti);
        return back();
    }
}
