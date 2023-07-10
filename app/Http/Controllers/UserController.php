<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Traits\ImageProcessing;
use App\Traits\AuthorizeChecked ;
class UserController extends Controller
{
    use ImageProcessing , AuthorizeChecked;
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
        
        return response()->json(['authors' => $getAllUsers]);
    }
   
    public function getAllAdmin(Request $request)
    {

        $this->authorizeChecked(['list-admin']);
      
        $filters = $request->query();

        $getAllAdmin = User::filter($filters)->where('role', 'admin')->paginate();

        if ($this->isEmpty($getAllAdmin)) {
            return response()->json('admin collection is empty');
        }
        
        return response()->json(['admins' => $getAllAdmin]);
    }


    public function getAllEmployee(Request $request)
    {

        $this->authorizeChecked(['list-admin']);
      
        $filters = $request->query();

        $getAllEmployee = User::filter($filters)->where('role', 'empolyee')->paginate();

        if ($this->isEmpty($getAllEmployee)) {
            return response()->json('admin collection is empty');
        }
        
        return response()->json(['empoleey' => $getAllEmployee]);
    }

    public function getAllMember(Request $request)
    {

        $this->authorizeChecked(['list-admin']);
      
        $filters = $request->query();

        $getAllMember = User::filter($filters)->where('role', 'member')->paginate();

        if ($this->isEmpty($getAllMember)) {
            return response()->json('member collection is empty');
        }
        
        return response()->json(['members' => $getAllMember]);
    }
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
    public function createUser(StoreUserRequest $request)
    {
        $this->authorizeChecked('add-user');
        $validatedData = $request->validated();
        // Save the User's image and get the image path
        $imagePath = $this->saveImage($request->file('image'));
        $User = new User();
        $User->first_name = $request->input('first_name');
        $User->last_name = $request->input('last_name');
        $User->email = $request->input('email');
        $User->phone_number = $request->input('phone_number');
        $User->address = $request->input('address');
        $User->password = $request->input('password');
        $User->gender = $request->input('gender');
        $User->birth_date = $request->input('birth_date');
        $User->image = $imagePath; // Save the image path to the User model
        $User->save();
        $User->image_url = asset('imagesfp/Users/' . $User->image);
        return response()->json(['message' => 'User created successfully', 'User' => $User], 201);
    }
    
    public function updateUser(UpdateUserRequest $request, $id)
    {
        $this->authorizeChecked('update-user');
        $User = User::findOrFail($id);
        $validatedData = $request->validated();
        $User->first_name = $request->input('first_name');
        $User->last_name = $request->input('last_name');
        $User->phone_number = $request->input('phone_number');
        $User->address = $request->input('address');
        $User->password = $request->input('password');
        $User->gender = $request->input('gender');
        $User->birth_date = $request->input('birth_date');
        if ($request->hasFile('image')) {
            if ($User->image) {
                $this->deleteImage($User->image); // Delete old image
            }
    
            $imagePath = $this->saveImage($request->file('image')); // Save new image
            $User->image = $imagePath;
        }
        $User->save();
        // Assuming $User->image is the URL of the image
        $User->image_url = asset('imagesfp/Users/' . $User->image);
        return response()->json(['message' => 'User created successfully', 'User' => $User], 200);
        
    }
    
    public function deleteUser($id)
    {
        $this->authorizeChecked('delete-user');
        $User = User::findOrFail($id);
        if ($User->image) {
            $this->deleteImage($User->image); // Delete the associated image
        }
        $User->delete();
        return response()->json(['data' => 'Deleted User with ID: '.$id], 200);
    }
}
