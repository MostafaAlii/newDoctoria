<?php

namespace App\Http\Requests\Admin\Gc;

use Illuminate\Foundation\Http\FormRequest;

class BloodSugarUnitRequest extends FormRequest
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
                $rules["unit.$language->abbreviation"] = 'required|unique:gc_blood_sugar_units,unit,' . $this->id . ',id';
            }
        } else {
            $rules = [
            ];

            foreach (languages() as $language) {
                $rules["unit.$language->abbreviation"] = 'required|unique:gc_blood_sugar_units,unit';
            }
        }

        return  $rules;
    }
}
