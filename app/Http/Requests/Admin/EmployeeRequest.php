<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
                'name' => 'required|unique:employees,name,'.$this->id,
                'email' => "required|email|unique:employees,email,".$this->id,
                'nickname' => 'required|unique:employees,nickname,'.$this->id,
                'phone' => 'required|unique:employees,phone,'.$this->id,
                'password' => 'required|min:6',
                'gender'=>'required|in:male,female',
                'type_id'=>'required|exists:types,id',
                'city_id'=>'required|exists:cities,id',
                'experience_id'=>'required|exists:experiences,id',
            ];
        }
        else{
            return [
                'name' => 'required|unique:employees,name',
                'email' => "required|email|unique:employees,email",
                'nickname' => 'required|unique:employees,nickname',
                'phone' => 'required|unique:employees,phone',
                'password' => 'required|min:6',
                'gender'=>'required|in:male,female',
                'type_id'=>'required|exists:types,id',
                'city_id'=>'required|exists:cities,id',
                'experience_id'=>'required|exists:experiences,id',

            ];
        }


    }
}
