<?php

// namespace App\Http\Controllers\Api;

// use App\Models\User;
// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Hash;
// use Auth;

// class RegisterController extends Controller
// {
//     public function register(Request $request)
//     {      
        // var_dump($request->name);
        // $request->validate([
        //      'name' => ['required'],
        //      'email' => ['required', 'email', 'unique:users'],
        //      'password' => ['required', 'min:8', 'confirmed'],
        //      'password_confirmation' => ['required']
        //  ]);

        //  $user = User::create([
        //      'name' => $request->name,
        //      'email' => $request->email,
        //      'password' => Hash::make($request->password),
        //  ]);

        //  $token = $user->createToken('user_token')->plainTextToken;

        //  return response()->json([
        //     'msg' => 'Registered Successfully',
        //     'user' => $user,
        //     'token' => $token
        //  ], 200);

        // return response()->json([
        //     'success' => true,
        //     'data' => [
        //         'token' => $user->createToken($user->name())->plainTextToken,
        //         'name' => $user->name(),
        //     ],
        //     'message' => 'User logged in!'
        // ]);

//     }
// }
