<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Traits\ImageProcessing;
use App\Traits\AuthorizeChecked ;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    use ImageProcessing , AuthorizeChecked , HasRoles;
    private function isEmpty($value)
    {
        return $value->count() === 0;
    }
    public function getAllUsers(Request $request)
    {
        $this->authorizeChecked(['list-superAdmin']);
        $filters = $request->query();

        $getAllUsers = User::filter($filters)->paginate();

        if ($this->isEmpty($getAllUsers)) {
            return response()->json('User collection is empty');
        }
        
        return response()->json(['users' => $getAllUsers]);
    }
   
    public function getAllAdmin(Request $request)
    {

        $this->authorizeChecked(['list-admin']);
      
        $filters = $request->query();

        $getAllAdmin = User::role('admin')->filter($filters)->paginate();

        if ($this->isEmpty($getAllAdmin)) {
            return response()->json('admin collection is empty');
        }
        
        return response()->json(['admins' => $getAllAdmin]);
    }

    public function getAllSuperAdmin(Request $request)
    {

        $this->authorizeChecked(['list-SuperAdmin']);
      
        $filters = $request->query();

        $getAllSuperAdmin = User::role('super admin')->filter($filters)->paginate();

        if ($this->isEmpty($getAllSuperAdmin)) {
            return response()->json('SuperAdmin collection is empty');
        }
        
        return response()->json(['SuperAdmins' => $getAllSuperAdmin]);
    }


    public function getAllEmployee(Request $request)
    {

        $this->authorizeChecked(['list-employee']);
      
        $filters = $request->query();

        $getAllEmployee = User::role('employee')->filter($filters)->paginate();

        if ($this->isEmpty($getAllEmployee)) {
            return response()->json('admin collection is empty');
        }
        
        return response()->json(['empoleey' => $getAllEmployee]);
    }

    public function getAllMember(Request $request)
    {

        $this->authorizeChecked(['list-admin']);
      
        $filters = $request->query();

        $getAllMember = User::role('member')->filter($filters)->paginate();

        if ($this->isEmpty($getAllMember)) {
            return response()->json('member collection is empty');
        }
        
        return response()->json(['members' => $getAllMember]);
    }
   
    public function getUserData()
    {
        $user = Auth::user();
        
        // Check if the user is authenticated
        if ($user) {
            return response()->json(['user' => $user]);
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   


    
    public function updateUser(UpdateUserRequest $request, $id)
    {
        // $this->authorizeChecked('');
        $user = User::findOrFail($id);
        $validatedData = $request->validated();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->phone_number = $request->input('phone_number');
        $user->address = $request->input('address');
        $user->password = $request->input('password');
        $user->gender = $request->input('gender');
        $user->birth_date = $request->input('birth_date');
       // Update the user's role if it's different from the current role
        if ($request->has('role') && isset($validatedData['role']) && $user->role !== $validatedData['role']) {
            $role = Role::where('name', $validatedData['role'])->first();
            if ($role) {
                $user->syncRoles([$role->name]);
            }
        }

    
        $user->fill($validatedData);
    
        if ($request->hasFile('image')) {
            if ($user->image) {
                $this->deleteImage($user->image); // Delete old image
            }
    
            $imagePath = $this->saveImage($request->file('image')); // Save new image
            $user->image = $imagePath;
        }
    
        $user->save();
    
        // Assuming $user->image is the filename of the image
        $user->image_url = asset('images/Users/' . $user->image);
    
        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }
    
    
    public function deleteUser($id)
    {
        // $this->authorizeChecked('delete-user');
        $user = User::findOrFail($id);
        if ($user->image) {
            $this->deleteImage($user->image); // Delete the associated image
        }
        $user->delete();
        return response()->json(['data' => 'Deleted User with ID: '.$id], 200);
    }
}
