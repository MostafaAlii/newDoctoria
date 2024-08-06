<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SelectProviderRequest extends FormRequest
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
                'slug'=>'nullable|unique:select_providers,slug,'.$this->id,

            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:select_providers,name,' . $this->id . ',id';
            }
        } else {
            $rules = [
                'slug'=>'required|unique:select_providers,slug',

            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:select_providers,name';
            }
        }

        return  $rules;
    }
}
