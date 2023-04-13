<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomStudent;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddstudentController extends Controller
{
    public function index(Request $request)
    {

        $semester = Semester::all();
        if ($request->ajax()) {
            $student = Student::where('name', 'LIKE', '%' . $request->search . '%')->get();
            return response()->json($student);
        } else {
            $student = Student::all();
        }
        $room = Room::all();
        $teacher = Teacher::all();
        return view('admin.student.add-student-room', ['student' => $student, 'semester' => $semester, 'room' => $room, 'teacher' => $teacher, 'semester' => $semester]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'student_id' => 'required',
                'teacher_id' => 'required',
                'room_id' => 'required',
                'semester_id' => 'required',
            ],
            [
                'student_id.required' => "Sinh viên không được để trống.",
                'teacher_id.required' => 'Giáo viên không được để trống.',
                'room_id.required' => 'Lớp học không được để trống.',
                'semester_id.required' => 'Kỳ học không được để trống.',
            ]
        );
        if ($validator->passes()) {
            $student = Student::whereIn('id', $request->student_id)->get();
            foreach ($student as $row) {
                $data = new RoomStudent();
                $data->student_id = $row->id;
                $data->teacher_id = $request->teacher_id;
                $data->room_id = $request->room_id;
                $data->semester_id = $request->semester_id;
                $data->save();
            };
            return response()->json(['success' => 'Thêm sinh viên vào lớp thành công', 'request' => $request->student_id, 'data' => $data]);
        }
        return response()->json([
            'message' => array_combine($validator->errors()->keys(), $validator->errors()->all()),
        ]);
    }
}
