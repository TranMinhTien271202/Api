<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Point;
use App\Models\Room;
use App\Models\RoomStudent;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;

class ARoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->search) {
                $data = Room::with(['teachers', 'subjects', 'semesters'])
                    ->where('semester_id', $request->search)
                    ->select('rooms.*')->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('teachers', function ($data) {
                        return $data->teachers->name;
                    })
                    ->editColumn('subjects', function ($data) {
                        return $data->subjects->name;
                    })
                    ->editColumn('semesters', function ($data) {
                        return $data->semesters->name;
                    })
                    ->addColumn('action', function ($row) {

                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa-solid fa-pen-to-square"></i></a>';

                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa-solid fa-trash"></i></a>';

                        return $btn;
                    })
                    ->make(true);
            } else {
                $data = Room::with(['teachers', 'subjects', 'semesters'])
                    ->select('rooms.*')->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('teachers', function ($data) {
                        return $data->teachers->name;
                    })
                    ->editColumn('subjects', function ($data) {
                        return $data->subjects->name;
                    })
                    ->editColumn('semesters', function ($data) {
                        return $data->semesters->name;
                    })
                    ->addColumn('action', function ($row) {

                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa-solid fa-pen-to-square"></i></a>';

                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa-solid fa-trash"></i></a>';

                        $btn = $btn . ' <a href="/admin/admin-detail-room/' . $row->id . '"  data-id="' . $row->id . '" class="btn btn-info btn-sm"><i class="fa-solid fa-circle-info"></i></a>';
                        return $btn;
                    })
                    ->make(true);
            }
        }
        $subject = Subject::all();
        $semester = Semester::all();
        $teacher = Teacher::all();
        $data = Room::with(['teachers', 'subjects'])->select('rooms.*')->get();
        return view('admin.room.index', ['subject' => $subject, 'semester' => $semester, 'data' => $data, 'teacher' => $teacher]);
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
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'subject_id' => 'required',
                'semester_id' => 'required',
            ],
            [
                'name.required' => "Tên lớp không được để trống.",
                'semester_id.required' => 'Kỳ học không được để trống.',
                'subject_id.required' => 'Môn học không được để trống.',
            ]
        );
        if ($validator->passes()) {
            $data =  Room::updateOrCreate(
                ['id' => $request->_id],
                [
                    'name' => $request->name,
                    'teacher_id' => $request->teacher_id,
                    'subject_id' => $request->subject_id,
                    'semester_id' => $request->semester_id,
                ]
            );
            return response()->json(['success' => 'Thêm lớp học thành công.', $data]);
        }
        return response()->json(['message' => array_combine($validator->errors()->keys(), $validator->errors()->all()),]);
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
        $product = Room::find($id);
        return response()->json($product);
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
        $room_student = RoomStudent::where('room_id', $id)->first();
        $point = Point::where('room_id', $id)->first();
        if ($room_student == null && $point == null) {
            Room::find($id)->delete();
            return response()->json(['status' => 1, 'success' => 'Xóa thành công.']);
        } else {
            return response()->json(['status' => 2, 'success' => 'Xóa không thành công.']);
        }
    }
    public function detail($id, Request $request)
    {
        $data = RoomStudent::where('room_id', $id)->get();
        $room = Room::find($id);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('students', function ($data) {
                    return $data->students->name;
                })
                ->addColumn('action', function ($row) {

                    $btn = ' <a href="/admin/delete-room/' . $row->student_id . '" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>';

                    return $btn;
                })
                ->make(true);
        }
        return view('admin.room.detail', ['data' => $data, 'room' => $room]);
    }
    public function delete($id){
        $data = RoomStudent::where('student_id', $id)->first();
        $point = Point::where('student_id', $id)->where('room_id', $data->room_id)->delete();
        $room = RoomStudent::where('student_id', $id)->delete();
        return back();
    }
}
