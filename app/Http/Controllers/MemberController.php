<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Traits\ImageProcessing;
class MemberController extends Controller
{
    use ImageProcessing;
    private function isEmpty($value)
    {
        return $value->count() === 0;
    }
    public function getAllMembers(Request $request)
    {
        $getAllMembers = Member::query()->paginate(5);

        if ($this->isEmpty($getAllMembers)) {
            return response()->json('Member collection is empty');
        }
        
        return response()->json(['authors' => $getAllMembers]);
    }
    public function createMember(StoreMemberRequest $request)
    {
        $validatedData = $request->validated();
        // Save the member's image and get the image path
        $imagePath = $this->saveImage($request->file('image'));
        $member = new Member();
        $member->first_name = $request->input('first_name');
        $member->last_name = $request->input('last_name');
        $member->email = $request->input('email');
        $member->phone_number = $request->input('phone_number');
        $member->address = $request->input('address');
        $member->password = $request->input('password');
        $member->gender = $request->input('gender');
        $member->birth_date = $request->input('birth_date');
        $member->image = $imagePath; // Save the image path to the member model
        $member->save();
        $member->image_url = asset('imagesfp/members/' . $member->image);
        return response()->json(['message' => 'Member created successfully', 'member' => $member], 201);
    }
    
    public function updateMember(UpdateMemberRequest $request, $id)
    {
        $member = Member::findOrFail($id);
        $validatedData = $request->validated();
        $member->first_name = $request->input('first_name');
        $member->last_name = $request->input('last_name');
        $member->email = $request->input('email');
        $member->phone_number = $request->input('phone_number');
        $member->address = $request->input('address');
        $member->password = $request->input('password');
        $member->gender = $request->input('gender');
        $member->birth_date = $request->input('birth_date');
        if ($request->hasFile('image')) {
            if ($member->image) {
                $this->deleteImage($member->image); // Delete old image
            }
    
            $imagePath = $this->saveImage($request->file('image')); // Save new image
            $member->image = $imagePath;
        }
        $member->save();
        // Assuming $member->image is the URL of the image
        $member->image_url = asset('imagesfp/members/' . $member->image);
        return response()->json(['message' => 'Member created successfully', 'member' => $member], 200);
        
    }
    
    public function deleteMember($id)
    {
        $member = Member::findOrFail($id);
        if ($member->image) {
            $this->deleteImage($member->image); // Delete the associated image
        }
        $member->delete();
        return response()->json(['data' => 'Deleted Member with ID: '.$id], 200);
    }
    
}
