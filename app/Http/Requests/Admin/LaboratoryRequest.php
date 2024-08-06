<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LaboratoryRequest extends FormRequest
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
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'cashback'=>'required|numeric',
                'service_price'=>'required|numeric',
                'discount'=>'required|numeric',

            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:laboratories,name,' . $this->id . ',id';
                $rules["desc.$language->abbreviation"] = 'required|unique:laboratories,desc,' . $this->id . ',id';

            }
        } else {
            $rules = [
                'work_from'=>'required',
                'work_to'=>'required',
                'location'=>'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'cashback'=>'required|numeric',
                'service_price'=>'required|numeric',
                'discount'=>'required|numeric',

            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:laboratories,name';
                $rules["desc.$language->abbreviation"] = 'required|unique:laboratories,desc';

            }
        }

        return  $rules;
    }
}
