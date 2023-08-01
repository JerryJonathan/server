<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role; 
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;
use DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::
        with('roles')->
        latest()->paginate(10);
        return new PostResource($users);
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return new PostResource($roles);
        // view('users.create',compact('roles'));
    }

    public function store(Request $request)
    {   
        //set validation
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|same:password',
            'role' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password_confirmation.required' => 'Confirm Password wajib diisi',
            'role.required' => 'Role wajib diisi',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
    
        $input = $request->all();
        $input['password'] = $input['password'];
    
        $user = User::create($input);
        $user->assignRole($request->input('role'));  

            // $user = User::create([
            //     'name'      => $request->name,
            //     'email' => $request->email,
            //     'password' => $request->password,
            //     'password_confirmation' => $request->password_confirmation,
            //     'role' => $request->role,
            // ]);
            return new PostResource($user);
    }

    public function show(Request $request, $id)
    {
        $user = User::find($id);

        return new PostResource($user);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return new PostResource('user','roles','userRole');
        // view('users.edit',compact('user','roles','userRole'));
    }

    public function profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
        ], 
        [
            'name.required' => 'Nama wajib diisi',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $id = Auth::user()->id;
        $input = $request->all();
        $user = User::find($id);
        $user->update($input);

        return new PostResource($user);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password'    => ['required', 'string', 'min:8', new MatchOldPassword],
            'newPassword' => 'required|string|min:8|different:password',
            'password_confirmation' => 'required|string|min:8|same:newPassword',
        ], 
        // [
        //     'password.required' => 'Password lama wajib diisi',
        //     'newPassword.required' => 'Password baru wajib diisi',
        //     'password_confirmation.required' => 'Konfirmasi Password wajib diisi',
        // ]
    );

        //response error validation
         if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // //  Match The Old Password
        //  if(!Hash::check($request->password, auth()->user()->password)){
        //     return response()->json("Your current password does not matches with the password you provided. Please try again.", 400);
        // }

        //  Update the new Password
        //  User::whereId(auth()->user()->id)->update([
            $user = User::find(auth()->user()->id);
            $user->password = $request->newPassword;
            $user->save();
            // 'password' => $request->password
            // $input = $request->all();
            // $request['password'] = $request['password']
        // ]);

        return response()->json("Password changed successfully", 200);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 400);
        // }

      
        // $user = User::find($id);
        // $user->update($input);

    }

    public function update(Request $request, $id)
    {   
        //set validation
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'role.required' => 'Role wajib diisi',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $input = $request->all();
        // if(!empty($input['password'])){ 
        //     $input['password'] = Hash::make($input['password']);
        // }else{
        //     $input = Arr::except($input,array('password'));    
        // }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('role'));

        //update to database
            // $user->update([
            //     'name'      => $request->name,
            //     'email' => $request->email,
            //     'password' => $request->password,
            //     'password_confirmation' => $request->password_confirmation,
            //     'role' => $request->role,
            // ]);
            return new PostResource($user);
    }

    public function destroy($id)
    {
        User::find($id)->delete();

        return new PostResource(null);
    }    

}
