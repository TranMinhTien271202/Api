<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeacherLoginController extends Controller
{
    public function index()
    {
        return view('teacher.auth.login');
    }
    public function login(Request $request)
    {
        // return $request->all();
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ],
            [
                'email.required' => "Email không được để trống.",
                'email.email' => "Email không đúng định dạng.",
                'password.required' => 'Mật khẩu không được để trống.',
            ]
        );
        if ($validator->passes()) {
            if ($request->ajax()) {
                if (auth('teacher')->attempt(['email' => $request->email, 'password' => $request->password])) {
                    return response()->json([ 'status' => 1 ,'success' => 'Đăng nhập thành công.']);
                }
                return response()->json([ 'status' => 2 ,'error' => 'Đăng nhập không thành công.']);
            }
        }
        return response()->json([
            'message' => array_combine($validator->errors()->keys(), $validator->errors()->all()),
        ]);
    }

    public function register()
    {
        return view('teacher.auth.register');
    }
    public function registerPost(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|unique:teachers',
                'name' => 'required',
                'password' => 'required'
            ],
            [
                'email.required' => "Email không được để trống.",
                'email.email' => "Email không đúng định dạng.",
                'email.unique' => "Email đã tồn tại",
                'password.required' => 'Mật khẩu không được để trống.',
                'name.required' => 'Tên không được để trống.'
            ]
        );
        if ($validator->passes()) {
            $teacher =  Teacher::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            return response()->json(['success' => 'Product saved successfully.', $teacher]);
        }

        return response()->json([
            'message' => array_combine($validator->errors()->keys(), $validator->errors()->all()),
        ]);
    }
    public function logout(){
        auth('teacher')->logout();
        return response()->json(['success' => 'You have been logged out']);
    }
}
