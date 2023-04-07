<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function profile()
    {
        $data = Teacher::find(auth('teacher')->user()->id);
        return view('teacher.auth.profile', ['data' => $data]);
    }
    public function profilePost(Request $request)
    {
        $data = Teacher::find(auth('teacher')->user()->id);
        if ($request->hasFile('image')) {
            $image = $request->image;
            $avatarName = $image->hashName();
            $path_image = $image->storeAs('images/users', $avatarName);
            $data->update([
                'image' => $path_image,
                'name' => $request->name,
                'phone' => $request->phone
            ]);
        }else{
            $data->update([
                'image' => $data->image,
                'name' => $request->name,
                'phone' => $request->phone
            ]);
        }
        return response()->json(['success' => 'Product logged in successfully.', $data]);
    }
}
