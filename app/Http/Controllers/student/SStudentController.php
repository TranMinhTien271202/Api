<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomStudent;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SStudentController extends Controller
{
    public function student($id)
    {
        $room = Room::where('id', $id)->first();
        $data = RoomStudent::where('room_id', $id)->paginate(5);
        return view('student.student.index', ['data' => $data, 'room' => $room]);
    }
}
