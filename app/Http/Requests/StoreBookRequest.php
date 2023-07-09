<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Check if the user can make any permission as "edit"
        if ($this->user()->can('role-create')) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'author_id' => 'required|exists:authers,id',
            'publisher' => 'required|string',
            'publishing_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'edition' => 'required|string',
            'pages' => 'required|integer',
            'num_of_copies' => 'required|integer',
            'available' => 'required|integer',
            'shelf_num' => 'required|integer',
            'num_of_borrowing' => 'required|integer',
            'num_of_reading' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        
    }
}
