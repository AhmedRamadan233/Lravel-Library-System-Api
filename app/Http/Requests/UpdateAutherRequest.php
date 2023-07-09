<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAutherRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            // 'email' => 'required|email|unique:authers,email,' . $this->route('auther')->id,
            'email' => 'required|email|unique:authers,email,' . ($this->route('auther') ? $this->route('auther')->id : ''),

            'password' => 'nullable|string|min:6',
            'gender' => 'nullable|in:male,female,other',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
