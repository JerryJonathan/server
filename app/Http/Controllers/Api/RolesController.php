<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
// use App\Models\Role;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;

class RolesController extends Controller
{
    public function access() 
    {
        $role = \Auth::user()->role;
        $permission = Role::findByName($role,'sanctum');
        return new PostResource($permission->permissions);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $roles = Role::orderBy('id','DESC')->paginate(5);
        return new PostResource ($roles);
        // view('roles.index',compact('roles'))
        // ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function permission()
    {
        $permissions = Permission::get();
        return new PostResource($permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
         ], [
            'name.required' => 'Nama wajib diisi',
            'permission.required' => 'Permission wajib diisi',
        ]);
    
         //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // $input = $request->all();
        // $role = Role::create($input);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
    
        return new PostResource ($role);
        // (['status'=>'success']);
        // redirect()->route('roles.index')
        //                 ->with('success','Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
        ->where("role_has_permissions.role_id",$id)
        ->get();

        return new PostResource ($role, $rolePermissions);
        // view('roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role, $id)
    {
        $role = Role::find($id);
        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    
        return new PostResource 
        // ($role, $permissions, $rolePermissions);
        (['role' => $role, 'permissions' => $permissions, 'rolePermissions' => $rolePermissions], null); 
        
        // view('roles.edit', compact('role', 'rolePermissions', 'permissions'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'permission' => 'required',
         ], [
            'name.required' => 'Nama wajib diisi',
            'permission.required' => 'Permission wajib diisi',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $input = $request->all();

        $role = Role::find($id);

        $role->update($input);
        // $role->name = $request->input('name');
        // $role->save();    
        
        $role->syncPermissions($request->input('permission'));

        // $role->update([
        //     'name' => $request->name,
        //     'permission' => $request->permission,
        // ]);
    
        return new PostResource ($role);
        // (['status'=>'success']);
        // redirect()->route('roles.index')
        //                 ->with('success','Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();

        return new PostResource (null); 
        // redirect()->route('roles.index')
                        // ->with('success','Role deleted successfully');
    }

}
