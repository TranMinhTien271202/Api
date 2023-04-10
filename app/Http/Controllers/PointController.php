<?php

namespace App\Http\Controllers;

use App\Models\Point;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Student;
use App\Models\Subject;
use Yajra\Datatables\Datatables;
class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Point::with(['teachers', 'subjects', 'students','rooms'])->where('teacher_id', '=', auth('teacher')->user()->id)->select('points.*')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('teachers', function ($data) {
                    return $data->teachers->name;
                })
                ->editColumn('subjects', function ($data) {
                    return $data->subjects->name;
                })
                ->editColumn('students', function ($data) {
                    return $data->students->name;
                })
                ->editColumn('rooms', function ($data) {
                    return $data->rooms->name;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa-solid fa-pen-to-square"></i></a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa-solid fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $student = Student::all();
        $subject = Subject::all();
        $room = Room::all();
        // $data = Room::with(['teachers','subjects'])->select('rooms.*')->get();
        return view('teacher.point.index', ['student' => $student, 'subject' => $subject , 'room' => $room]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data =  Point::updateOrCreate(
            ['id' => $request->_id],
            [
                'value' => $request->value,
                'teacher_id' => $request->teacher_id,
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'room_id' => $request->room_id,

            ]
        );
        return response()->json(['success' => 'Product successfully.', $request->all()]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $point = Point::find($id);
        return response()->json($point);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Point::find($id)->delete();
        return response()->json(['success' => 'Product deleted successfully.']);
    }
}
