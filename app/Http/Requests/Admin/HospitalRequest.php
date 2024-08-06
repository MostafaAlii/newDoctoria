<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HospitalRequest extends FormRequest
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
                $rules["name.$language->abbreviation"] = 'required|unique:hospitals,name,' . $this->id . ',id';
                $rules["about_us.$language->abbreviation"] = 'nullable|unique:hospitals,about_us,' . $this->id . ',id';
                $rules["desc.$language->abbreviation"] = 'required|unique:hospitals,desc,' . $this->id . ',id';

            }
        } else {
            $rules = [
                'work_from'=>'required',
                'work_to'=>'required',
                'location'=>'required|string',
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
                $rules["name.$language->abbreviation"] = 'required|unique:hospitals,name';
                $rules["about_us.$language->abbreviation"] = 'nullable|unique:hospitals,about_us';
                $rules["desc.$language->abbreviation"] = 'required|unique:hospitals,desc';

            }
        }

        return  $rules;
    }
}
