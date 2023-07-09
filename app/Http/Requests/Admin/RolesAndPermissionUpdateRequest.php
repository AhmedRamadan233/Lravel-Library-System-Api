<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RolesAndPermissionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Check if the user can make any permission as "edit"
        if ($this->user()->can('role-edit')) {
            return true;
        }
        return false;
    }
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'role' => ['required', 'unique:roles,name', 'max:60'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ];
    }
    
}
