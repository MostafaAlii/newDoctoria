<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProviderTypeRequest extends FormRequest
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
                'slug' => 'required',
            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required';
            }
        } else {
            $rules = [
                'slug' => 'required',
            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required';
            }
        }

        return  $rules;
    }
}
