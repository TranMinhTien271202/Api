<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SyntheController extends Controller
{
    public function index(Request $request){
        $data = Semester::all();
        return view('teacher.synthe.index', ['data' => $data]);
    }
}
