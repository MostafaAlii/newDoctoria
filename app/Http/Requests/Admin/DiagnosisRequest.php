<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DiagnosisRequest extends FormRequest
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
            ];

            foreach (languages() as $language) {
                $rules["diagnosis.$language->abbreviation"] = 'required|unique:diagnoses,diagnosis,' . $this->id . ',id';
            }
        } else {
            $rules = [
            ];

            foreach (languages() as $language) {
                $rules["diagnosis.$language->abbreviation"] = 'required|unique:diagnoses,diagnosis';
            }
        }

        return  $rules;
    }
}
