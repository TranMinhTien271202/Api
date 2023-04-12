<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\Room;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Subject::latest()->get();

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
        return view('teacher.subject.index');
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
                'subject_code' => 'required'
            ],
            [
                'name.required' => "Tên môn học không được để trống.",
                'subject_code.required' => 'Mã môn học không được để trống.',
            ]
        );
        if ($validator->passes()) {
            if ($request->ajax()) {
                $data =  Subject::updateOrCreate(
                    ['id' => $request->_id],
                    [
                        'name' => $request->name,
                        'email' => $request->email,
                        'subject_code' => $request->subject_code,
                    ]
                );
                return response()->json(['success' => 'Product successfully.', $data]);
            }
        }
        return response()->json([
            'message' => array_combine($validator->errors()->keys(), $validator->errors()->all()),
        ]);
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
        $product = Subject::find($id);
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
        $room = Room::where('subject_id', $id)->first();
        $point = Point::where('subject_id', $id)->first();
        if ($room == null && $point == null) {
            Subject::find($id)->delete();
            return response()->json(['status' => 1, 'success' => 'Xóa thành công.']);
        } else {
            return response()->json(['status' => 2, 'error' => 'Xóa không hành công.']);
        }
    }
}
