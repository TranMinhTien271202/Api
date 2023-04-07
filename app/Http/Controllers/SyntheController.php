<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Semester;
use Illuminate\Http\Request;

class SyntheController extends Controller
{
    public function index(Request $request){
        $data = Semester::all();
        return view('teacher.synthe.index', ['data' => $data]);
    }
    public function room($id){
            $data = Room::where('id',$id)->get();
            return view('teacher.synthe.room', ['data' => $data]);
    }
}
