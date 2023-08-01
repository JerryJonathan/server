<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role; 

class AuthController extends Controller
{
    public function register(request $request) {
    //      $validator = $request->validate( [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|string|min:8',
    //         'password_confirmation' => 'required|same:password'
    //     ]
    // );

        $validator = Validator::make($request -> all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|same:password',
            'role' => 'required'
        ]
    );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => null
            ]);
        }

    //     User::create([
    //         'name' => $_REQUEST->name,
    //         'email' => $_REQUEST->email,
    //         'password' => Hash:make($_REQUEST->password),
    //     ]);

    //     return response()->json(['msg' -> 'Registrasi Sukses']);
    // }

        $input = $request->all();
        $input['password'] = $request -> password;
        $user = User::create($input);
        $user->assignRole('user'); 

        $success['token'] = $user->createToken('auth_token')->plainTextToken;
        $success['name'] = $user->name;

        return response()->json([
            'success' => true,
            'message' => 'Registrasi Berhasil',
            'data' => $success 
        ]);
    }
    public function login(Request $request)
    {
        // $_REQUEST->validate([
        //     'email' => 'required|email',
        //     'password' => 'required',
        // ]);

        // $user= User::where('email', $request->email)->first();
        
        // if ($user) {
        //     if (Hash::check($request->password, $user->password)) {
        //         return response()->json([
        //             'success' => false,
        //             'message' => 'Sukses. ',
        //             'data' => null
        //         ]);
        //     }else{
        //         return response()->json([
        //             'success' => false,
        //             'message' => 'Password salah. ',
        //             'data' => null
        //         ]);
        //     }

        // }else{
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Email salah. ',
        //         'data' => null
        //     ]);
        // }


        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $auth = Auth::user();
            $success['token'] = $auth->createToken('auth_token')->plainTextToken;
            $success['name'] = $auth->name;
            $success['email'] = $auth->email;

            return response()->json([
                'success' => true,
                'message' => 'Login Berhasil',
                'data' => $success
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah. Silakan masukkan email dan password anda kembali.',
                'data' => null
            ]);
        }
    }

    public function auth() {
        return Auth::user();
    }

    // public function auth() {
    //     if (auth()->user()->role == 'admin') {
    //         return 
    //     }
    // }

    public function logout() {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'Logout Berhasil'
        ]);
    }

    // public function user(Request $request)
    // {
    //     $user = User::find(Auth::user()->id);

    //     return response()->json([
    //         'data' => $user
    //     ]);
    // }

    // private function guard()
    // {
    //     return Auth::guard();
    // }
}