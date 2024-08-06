<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:sliders,name,' . $this->id . ',id';
                $rules["desc.$language->abbreviation"] = 'required|unique:sliders,desc,' . $this->id . ',id';

            }
        } else {
            $rules = [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',

            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:sliders,name';
                $rules["desc.$language->abbreviation"] = 'required|unique:sliders,desc';

            }
        }

        return  $rules;
    }
}
