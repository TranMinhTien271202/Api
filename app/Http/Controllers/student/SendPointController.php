<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Point;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendPointController extends Controller
{
    public function index(){
        $student = Student::where('id',auth('student')->user()->id)->first();
        $data = Point::where('student_id', auth('student')->user()->id)->get();
        Mail::send('student.mail.index', compact('student'), function ($email) use ($student,$data) {
            $email->subject('UbWork - Bảng điểm');
            $email->to($student->email, $student->name);
        });
        return back();
    }
    public function view(){
        $data = Point::where('student_id', auth('student')->user()->id)->get();
        return view('student.mail.index',['data' => $data]);
    }
}
