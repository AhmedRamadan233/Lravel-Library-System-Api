<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Check if the user can make any permission as "edit"
        if ($this->user()->can('add-member')) {
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
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'gender' => 'nullable|in:male,female,other',
            'hire_date' => 'nullable|date',
            'salary' => 'nullable|numeric',
            'birth_date' => 'nullable|date',
            'image' => 'nullable|image',
            'role' => 'nullable|in:employee,member,admin,super admin',
        ];
    }
}
