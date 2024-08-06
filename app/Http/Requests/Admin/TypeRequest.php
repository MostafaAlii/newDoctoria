<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TypeRequest extends FormRequest
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
                'category_id' => 'required|exists:categories,id',
            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:types,name,' . $this->id . ',id';
            }
        } else {
            $rules = [
                'category_id' => 'required|exists:categories,id',
            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:types,name';
            }
        }

        return  $rules;
    }
}
