<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Semester;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Semester::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('start_date', function ($data) {
                    return date('d-m-Y', strtotime($data->start_date));
                })
                ->editColumn('end_date', function ($data) {
                    return date('d-m-Y', strtotime($data->end_date));
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa-solid fa-pen-to-square"></i></a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa-solid fa-trash"></i></a>';

                    $btn = $btn . ' <a href="/teacher/syn-room/ ' . $row->id . '" data-toggle="tooltip"  data-id="' . $row->id . '" class="btn btn-info btn-sm"><i class="fa-solid fa-circle-info"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('teacher.semester.index');
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
        $data =  Semester::updateOrCreate(
            ['id' => $request->_id],
            [
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]
        );
        return response()->json(['success' => 'Product successfully.', $data]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Semester::find($id);
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
        $room = Room::where('semester_id', $id)->first();
        if ($room == null) {
            Semester::find($id)->delete();
            return response()->json(['success' => 'Semester deleted successfully.']);
        }else{
            return response()->json(['success' => 'Semester deleted false.']);
        }
    }
}
