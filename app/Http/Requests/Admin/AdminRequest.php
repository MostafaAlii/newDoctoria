<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->id){
            return [
                'email' => "required|unique:admins,email,".$this->id,
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'name' => 'required',
                'password' => 'nullable|min:6',
                'is_active'=>'nullable|in:0,1',
                'role_id' => 'required',

            ];
        }
        else{
            return [
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'name' => 'required',
                'email' => "required|email|unique:admins",
                'password' => 'required|min:6',
                'is_active'=>'nullable|in:0,1',
                'role_id' => 'required',

            ];
        }
    }


    public function messages()
    {
        return [
            'name.required' => 'Please enter admin name.',
            'email.required' => 'Please enter email address.',
            'email.unique' => 'Email address was used before',
            'password.required' => 'Please enter a password.',
            'password.min' => 'Your password must be at least :min characters long.',
        ];
    }
}
