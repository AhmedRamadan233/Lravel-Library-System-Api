<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Admin\RolesAndPermissionRequest;


class RolesAndPermissionController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware('auth:api');
    //     $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
    //     $this->middleware('permission:role-create', ['only' => ['store']]);
    //     $this->middleware('permission:role-edit', ['only' => ['update']]);
    //     $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    // }
    public function index(Request $request)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return response()->json([
            'roles' => $roles,
            "permissions" =>$permissions,
            'message' => 'Roles retrieved successfully'
        ]);
    }

    public function store(RolesAndPermissionRequest $request)
    {
        $data = $request->validated();
        
        $role = Role::create([
            'name' => $data['role'],
            'guard_name' => 'web'
        ])->givePermissionTo($data['permissions']);
        
        app()['cache']->forget('spatie.permission.cache');
        
        return response()->json([
            'success' => "created a new roles",
            'data' => $role
        ], 200);
    }


    public function destroy($id)
    {
   
            $role = Role::findOrFail($id);
            $role->syncPermissions([]);
            $role->delete();
            return response()->json(['success' => true, 'data' => 'Deleted role with name: '.$role->name], 200);
    }

}
