<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomStudent;
use App\Models\Student;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class RoomStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = RoomStudent::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa-solid fa-pen-to-square"></i></a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa-solid fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $student = Student::all();
        $room = Room::all();
        return view('teacher.room-student.index', ['student' => $student,'room' => $room]);
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
        $data =  RoomStudent::updateOrCreate(
            ['id' => $request->_id],
            [
                'teacher_id' => $request->teacher_id,
                'student_id' => $request->student_id,
                'room_id' => $request->room_id,
            ]
        );
        return response()->json(['success' => 'Product successfully.', $data]);
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
        $product = RoomStudent::find($id);
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
        RoomStudent::find($id)->delete();
        return response()->json(['success' => 'Product deleted successfully.']);
    }
}
