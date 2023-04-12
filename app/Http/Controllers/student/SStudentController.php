<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\RoomStudent;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SStudentController extends Controller
{
    public function student($id)
    {
        $data = RoomStudent::where('room_id', $id)->paginate(5);
        return view('student.student.index', ['data' => $data]);
    }
}
