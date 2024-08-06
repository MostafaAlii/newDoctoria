<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
        if ($this->id) {
            $rules = [
                'price'=>'required|regex:/^\d+(\.\d{1,2})?$/',
                'count'=>'required|array',
                'count.*'=>'required|numeric',
                'main_service_id'=>'required|array',
                'main_service_id.*'=>'required|exists:main_services,id',
            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:packages,name,' . $this->id . ',id';
            }
        } else {
            $rules = [
                'price'=>'required|regex:/^\d+(\.\d{1,2})?$/',
                'count'=>'required|array',
                'count.*'=>'required|numeric',
                'main_service_id'=>'required|array',
                'main_service_id.*'=>'required|exists:main_services,id',

            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:packages,name';
            }
        }

        return  $rules;
    }
}
