<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomStudent;
use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SRoomController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            if ($request->semester) {
                $data = RoomStudent::join('students', 'students.id', '=', 'room_students.student_id')
                    ->where('room_students.student_id', auth('student')->user()->id)
                    ->where('semester_id', $request->semester)
                    ->select('room_students.*')
                    ->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('room', function ($data) {
                        return $data->rooms->name;
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="/student/student-user/'. $row->room_id . '" class="edit btn btn-primary btn-sm"><i class="fa-solid fa-circle-info"></i></a>';
                        return $btn;
                    })
                    ->make(true);
            } else {
                $day = Carbon::now()->format('Y/m/d');
                $semester = Semester::whereDate('start_date', '<=', $day)->whereDate('end_date', '>=', $day)->first();
                $data = RoomStudent::join('students', 'students.id', '=', 'room_students.student_id')
                    ->where('room_students.student_id', auth('student')->user()->id)
                    ->where(function ($q) use ($semester){
                        if ($semester){
                            $q->where('semester_id', $semester->id);
                        }
                    })
                    ->select('room_students.*')
                    ->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('room', function ($data) {
                        return $data->rooms->name;
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="/student/student-user/'. $row->room_id . '" class="edit btn btn-primary btn-sm"><i class="fa-solid fa-circle-info"></i></a>';
                        return $btn;
                    })
                    ->make(true);
            }
        }
        $semester = Semester::all();
        return view('student.room.index', ['semester' => $semester]);
    }
}
