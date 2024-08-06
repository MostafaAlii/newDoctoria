<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NationalityRequest extends FormRequest
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
                'phone_code' => 'required|unique:nationalities,phone_code,' . $this->id,
                'country_code' => 'required|unique:nationalities,country_code,' . $this->id,
            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:nationalities,name,' . $this->id . ',id';
                $rules["nickname.$language->abbreviation"] = 'required|unique:nationalities,nickname,' . $this->id . ',id';
                $rules["country_name.$language->abbreviation"] = 'required|unique:nationalities,country_name,' . $this->id . ',id';

            }
        } else {
            $rules = [
                'phone_code' => 'required|unique:nationalities,phone_code',
                'country_code' => 'required|unique:nationalities,country_code',
            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:nationalities,name';
                $rules["nickname.$language->abbreviation"] = 'required|unique:nationalities,nickname';
                $rules["country_name.$language->abbreviation"] = 'required|unique:nationalities,country_name';

            }
        }

        return $rules;



    }
}
