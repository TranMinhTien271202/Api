<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomStudent;
use App\Models\Semester;
use Illuminate\Http\Request;

class SyntheController extends Controller
{
    public function index(Request $request){
        $data = Semester::all();
        return view('teacher.synthe.index', ['data' => $data]);
    }
    public function room($id){
            $data = Room::where('semester_id',$id)->get();
            $semes = Semester::find($id);
            return view('teacher.synthe.room', ['data' => $data, 'semester' => $semes]);
    }
    public function student($id){
        $data = RoomStudent::where('room_id',$id)->get();
        $room = Room::find($id);
        return view('teacher.synthe.student', ['data' => $data, 'room' => $room]);
    }
}
