<?php

// namespace App\Http\Controllers\Api;

// use App\Models\User;
// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Hash;
// use Auth;

// class LoginController extends Controller
// {
//     public function login(Request $request)
//     {
//         $request->validate([
//             'email' => ['required'],
//             'password' => ['required']
//         ]);

//         if (Auth::attempt($request->only('email', 'password'))) {
//             return response()->json(Auth::user(), 200);
//         }

        /* throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.']
        ]); */
//     }

//     public function logout()
//     {
//         Auth::logout();
//     }
// }
