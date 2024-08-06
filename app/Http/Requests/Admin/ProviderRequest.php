<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProviderRequest extends FormRequest
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
                'work_from'=>'required',
                'work_to'=>'required',
                'location'=>'required|string',
                'about_us' => 'required',
                'latitude' => 'nullable',
                'longitude' => 'nullable',
                'phone' => 'nullable',
                'website_link' => 'nullable',
                'rating_value' => 'nullable',
                'num_of_raters' => 'nullable',
                'provider_type_id' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',


            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required';
                $rules["about_us.$language->abbreviation"] = 'nullable';
                $rules["desc.$language->abbreviation"] = 'required';

            }
        } else {
            $rules = [
                'work_from'=>'required',
                'work_to'=>'required',
                'location'=>'required|string',
                'provider_type_id' => 'required',
                'about_us' => 'nullable',
                'latitude' => 'nullable',
                'longitude' => 'nullable',
                'phone' => 'nullable',
                'website_link' => 'nullable',
                'rating_value' => 'nullable',
                'num_of_raters' => 'nullable',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',

            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required';
                $rules["about_us.$language->abbreviation"] = 'nullable';
                $rules["desc.$language->abbreviation"] = 'required';

            }
        }

        return  $rules;
    }
}
