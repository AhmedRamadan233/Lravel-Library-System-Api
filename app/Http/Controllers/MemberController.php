<?php

namespace App\Http\Controllers;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Illuminate\Database\QueryException;
use App\Traits\ImageProcessing;
class MemberController extends Controller
{
    use ImageProcessing;
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

            if ($request->hasFile('image')) {
                if ($member->image) {
                    $this->deleteImage($member->image);
                }

                $imagePath = $this->saveImage($request->file('image'));
                $member->image = $imagePath;
                $member->image = asset('imagesfp/'.$imagePath);
                // http://localhost:8000/imagesfp/nR6HpdCr1688315046.jpg
                // $member->image ? $member->image = $member->image_url : null;

            }

            $member->save();
            $member->refresh();

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
                return $this->errorResponse('Member not found with ID: ' . $id, 404);
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
    
            if ($request->hasFile('image')) {
                if ($member->image) {
                    $this->deleteImage($member->image);
                }
            
                $imagePath = $this->saveImage($request->file('image'));
                $member->image = $imagePath;
                $member->image = asset('imagesfp/'.$imagePath);
            } elseif ($request->filled('delete_image')) {
                if ($member->image) {
                    $this->deleteImage($member->image);
                    $member->image = null;
                    $member->image = null;
                }
            }
            
            $member->save();
            
    
            return response()->json(['message' => 'Member updated successfully', 'member' => $member]);
        } catch (ValidationException $exception) {
            return response()->json(['message' => 'Failed to create member. Missing required field.', 'errors' => $exception->errors()], 400);
        }
        
            
        
    }
    
    // catch (ValidationException $exception) {
    //     return response()->json(['message' => 'Failed to create member. Missing required field.', 'errors' => $exception->errors()], 400);
    // }
    

    
    
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
