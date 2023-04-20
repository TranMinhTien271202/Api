<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Post;
use App\Models\PostType;
use App\Models\Room;
use App\Models\RoomStudent;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Post::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('type', function ($data) {
                    return $data->PostType->name;
                })
                ->editColumn('user', function ($data) {
                    return $data->user->email;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa-solid fa-pen-to-square"></i></a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa-solid fa-trash"></i></a>';

                    return $btn;
                })
                ->make(true);
        }
        $type = PostType::all();
        return view('admin.post.post', ['type' => $type]);
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
                'title' => 'required',
            ],
            [
                'name.title' => "Tên loại bài viết không được để trống.",
            ]
        );
        if ($validator->passes()) {
            $data =  Post::Create(
                [
                    'title' => $request->title,
                    'detail' => $request->detail,
                    'user_id' => $request->user,
                    'post_type' => $request->type

                ]
            );
            return response()->json(['success' => 'Product successfully.', 'data' => $request->all()]);
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
        $point = Post::find($id);
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
        Post::find($id)->delete();
        return response()->json(['status' => 1,'success' => 'xóa thành công.']);
    }

    public function post(){
        $data = Post::all();
        $nofiti = Notification::where('student_id', auth('student')->user()->id)->limit(5)->orderBy('id', 'DESC')->get();
        $nofitis = Notification::where('student_id', auth('student')->user()->id)->where('status', 0)->limit(5)->orderBy('id', 'DESC')->get();
        return view('student.post.index', ['data' => $data, 'nofiti' => $nofiti, 'nofitis' => $nofitis]);
    }
    public function detail($id){
        $data = Post::find($id);
        return view('student.post.post-detail', ['data' => $data]);
    }
}
