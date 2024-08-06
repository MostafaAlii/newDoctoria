<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class InsuranceCompanyRequest extends FormRequest
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
                'phone' => "required|unique:insurance_companies,phone,".$this->id,
                'name' => 'required',
                'check'=>'required|in:api,code',
                'address' => 'nullable',
                'api'=>'required',
            ];
        }
        else{
            return [
                'phone' => "required|unique:insurance_companies,phone",
                'name' => 'required',
                'check'=>'required|in:api,code',
                'address' => 'nullable',
                'api'=>'required',

            ];
        }
    }
}
