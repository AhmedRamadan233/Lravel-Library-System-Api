<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Illuminate\Database\QueryException;

class MemberController extends Controller
{
    private function isEmpty($value)
    {
        return $value->count() === 0;
    }
    private function errorResponse($message, $statusCode)
    {
        return response()->json(['data' => $message], $statusCode);
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
        try {
            $validatedData = $request->validated();
            $member = new Member();
            
            $member->first_name = $request->post('first_name');
            $member->last_name = $request->post('last_name');
            $member->email = $request->post('email');
            $member->phone_number = $request->post('phone_number');
            $member->address = $request->post('address');
            $member->password = $request->post('password');
            $member->gender = $request->post('gender');
            $member->birth_date = $request->post('birth_date');
            $member->image = $request->post('image');
            
            $member->save();
            
            return response()->json(['message' => 'Member created successfully', 'member' => $member], 201);
        } catch (QueryException $exception) {
            return response()->json(['message' => 'Failed to create member. Missing required field.'], 400);
        }
    }


    public function updateMember(UpdateMemberRequest $request, $id)
{
    try {
        $member = Member::find($id);

        if (!$member) {
            return $this->errorResponse('Member not found with ID: '.$id, 404);
        }

        $validatedData = $request->validated();
        $member->first_name = $request->post('first_name');
        $member->last_name = $request->post('last_name');
        $member->email = $request->post('email');
        $member->phone_number = $request->post('phone_number');
        $member->address = $request->post('address');
        $member->password = $request->post('password');
        $member->gender = $request->post('gender');
        $member->birth_date = $request->post('birth_date');
        $member->image = $request->post('image');

        $member->save();

        return response()->json(['message' => 'Member updated successfully', 'member'=>$member]);
    } catch (QueryException $exception) {
        return response()->json(['message' => 'Failed to update member. Missing required field.'], 400);
    }
}

    
    
    public function deleteMember($id)
    {
        try {
            $member = Member::find($id);
    
            if (!$member) {
                return $this->errorResponse('Member not found with ID: '.$id, 404);
            }
    
            $member->delete();
    
            return response()->json(['data' => 'Deleted Member with ID: '.$id], 200);
        } catch (QueryException $exception) {
            return response()->json(['message' => 'Failed to delete member.'], 500);
        }
    }
    
}
