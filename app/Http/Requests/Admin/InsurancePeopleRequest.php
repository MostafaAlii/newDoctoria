<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class InsurancePeopleRequest extends FormRequest
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
                'phone' => "required|unique:insurance_people,phone,".$this->id,
                'name' => 'required',
                'status'=>'nullable|in:active,expire',
                'address' => 'nullable',
            ];
        }
        else{
            return [
                'phone' => "required|unique:insurance_people,phone",
                'name' => 'required',
                'status'=>'nullable|in:active,expire',
                'address' => 'nullable',
            ];
        }
    }
}
