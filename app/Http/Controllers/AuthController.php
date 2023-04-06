<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\Promise\all;

class AuthController extends Controller
{
    public function index()
    {
        return view('admin.auth.login');
    }
    public function register()
    {
        return view('admin.auth.register');
    }
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|unique:users',
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
            $user =  User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            return response()->json(['success' => 'Product saved successfully.', $user]);
        }

        return response()->json([
            'message' => array_combine($validator->errors()->keys(), $validator->errors()->all()),
        ]);
    }
    public function login(Request $request)
    {
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
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    return response()->json(['success' => 'Đăng nhập thành công.']);
                }
                return response()->json(['success' => 'Đăng nhập không thành công.']);
            }
        }
        return response()->json([
            'message' => array_combine($validator->errors()->keys(), $validator->errors()->all()),
        ]);
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.index');
    }
    public function profile()
    {
        $data = User::find(Auth::user()->id);
        // return response()->json(['success' => 'Product logged in successfully.', $data]);
        return view('admin.user.profile', ['data' => $data]);
    }
    public function updateProfile(Request $request)
    {
        $data = User::find(Auth::user()->id);
        $data->update($request->all());
        return response()->json(['success' => 'Product logged in successfully.', $data]);
    }
}
