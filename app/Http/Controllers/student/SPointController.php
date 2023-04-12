<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Point;
use App\Models\Semester;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SPointController extends Controller
{
    public function index(Request $request)
    {
        $data = Point::where('student_id', auth('student')->user()->id)->groupby('subject_id')->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('subject', function ($data) {
                    return $data->subjects->name;
                })
                ->editColumn('subject-code', function ($data) {
                    return $data->subjects->subject_code;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/student/student-point/' . $row->subject_id . '" class="edit btn btn-primary btn-sm"><i class="fa-solid fa-circle-info"></i></a>';
                    return $btn;
                })
                ->make(true);
        }
        return view('student.point.index', ['data' => $data]);
    }
    public function point($id)
    {
        $user = auth('student')->user()->id;
        $day = Carbon::now()->format('Y/m/d');
        $subject = Subject::where('id', $id)->first();
        $data = Point::where('subject_id', $id)->where('student_id', $user)->paginate(10);
        return view('student.point.student-point', ['data' => $data, 'subject' => $subject]);
    }
}
