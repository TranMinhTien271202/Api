<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Point;
use App\Models\Room;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentLoginController extends Controller
{
    public function index()
    {

        return view('student.auth.login');
    }
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|min:6'
            ],
            [
                'email.required' => "Email không được để trống.",
                'email.email' => "Email không đúng định dạng.",
                'password.required' => 'Mật khẩu không được để trống.',
                'password.min' => "Mật khẩu phải lớn hơn 6 ký tự.",
            ]
        );
        if ($validator->passes()) {
            if ($request->ajax()) {
                if (auth('student')->attempt(['email' => $request->email, 'password' => $request->password])) {
                    return response()->json(['status' => 1, 'success' => 'Đăng nhập thành công']);
                }
                return response()->json(['status' => 2, 'error' => 'Đăng nhập thất bại']);
            }
        }
        return response()->json([
            'message' => array_combine($validator->errors()->keys(), $validator->errors()->all()),
        ]);
    }
    public function register()
    {
        return view('student.auth.register');
    }
    public function registerPost(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|unique:students',
                'name' => 'required',
                'password' => 'required:min6'
            ],
            [
                'email.required' => "Email không được để trống.",
                'email.email' => "Email không đúng định dạng.",
                'email.unique' => "Email đã tồn tại",
                'password.required' => 'Mật khẩu không được để trống.',
                'name.required' => 'Tên không được để trống.',
                'password.min' => "Mật khẩu phải lớn hơn 6 ký tự.",
            ]
        );
        if ($validator->passes()) {
            $student =  Student::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            return response()->json(['success' => 'Đăng ký thành công.', $student]);
        }

        return response()->json([
            'message' => array_combine($validator->errors()->keys(), $validator->errors()->all()),
        ]);
    }
    public function logout()
    {
        auth('student')->logout();
        return redirect()->route('student.index');
    }
    public function dashboard()
    {
        $nofiti = Notification::where('student_id', auth('student')->user()->id)->limit(5)->orderBy('id', 'DESC')->get();
        $nofitis = Notification::where('student_id', auth('student')->user()->id)->where('status', 0)->limit(5)->orderBy('id', 'DESC')->get();
        $teacher = Teacher::all();
        $student = Student::all();
        $subject = Subject::all();
        $day = Carbon::now()->format('Y/m/d');
        $semester = Semester::whereDate('start_date', '<=', $day)->whereDate('end_date', '>=', $day)->first();
        $room = Room::where('semester_id', '=', $semester->id)->pluck('id')->toArray();
        $data = Point::whereIn('room_id', $room)
            ->selectRaw('points.*, sum(value) / count(value) as total')
            ->groupBy('points.student_id')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();
        return view('student.index', ['teacher' => $teacher, 'student' => $student, 'subject' => $subject, 'data' => $data, 'semester' => $semester, 'nofiti' => $nofiti, 'nofitis' => $nofitis]);
    }
}
