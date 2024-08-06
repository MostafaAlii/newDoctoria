<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
                'main_service_id'=>'required|exists:main_services,id',
                'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'slug'=>'nullable|unique:categories,slug,'.$this->id,

            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:categories,name,' . $this->id . ',id';
            }
        } else {
            $rules = [
                'main_service_id'=>'required|exists:main_services,id',
                'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'slug'=>'required|unique:categories,slug',



            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:categories,name';
            }
        }

        return  $rules;
    }
}
