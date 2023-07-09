<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RolesAndPermissionUpdateRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Admin\RolesAndPermissionRequest;
use App\Traits\AuthorizeChecked;

class RolesAndPermissionController extends Controller
{
    use AuthorizeChecked;
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
        $this->authorizeChecked('role-list');
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
        $this->authorizeChecked('role-create');
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

    public function update( $id, RolesAndPermissionUpdateRequest $request)
    {
        $this->authorizeChecked('role-edit');
    
        $role = Role::findOrFail($id);
    
        // Check if the requested role name is different from the existing role name
        if ($role->name !== $request->role) {
            // Check if a role with the requested name already exists
            $existingRole = Role::where('name', $request->role)->first();
            if ($existingRole) {
                return response()->json(['success' => false, 'error' => 'The role name is already taken.'], 422);
            }
    
            // Update the role's name
            $role->name = $request->role;
            $role->save();
        }
    
        $permissions = Permission::whereIn('name', $request->permissions)->get();
        $role->syncPermissions($permissions);
    
        return response()->json(['success' => true, 'data' => $role], 200);
    }
    public function destroy($id)
    {
        $this->authorizeChecked('role-delete');
   
        $role = Role::findOrFail($id);
        $role->syncPermissions([]);
        $role->delete();
        return response()->json(['success' => true, 'data' => 'Deleted role with name: '.$role->name], 200);
    }

}
