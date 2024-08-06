<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RadiologyCenterRequest extends FormRequest
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
                'location'=>'required',
                'fromTime'=>'required',
                'toTime'=>'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'cashback'=>'required|numeric',
                'service_price'=>'required|numeric',
                'discount'=>'required|numeric',


            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:radiology_centers,name,' . $this->id . ',id';
                $rules["desc.$language->abbreviation"] = 'required|unique:radiology_centers,desc,' . $this->id . ',id';

            }
        } else {
            $rules = [
                'location'=>'required',
                'fromTime'=>'required',
                'toTime'=>'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'cashback'=>'required|numeric',
                'service_price'=>'required|numeric',
                'discount'=>'required|numeric',


            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:radiology_centers,name';
                $rules["desc.$language->abbreviation"] = 'required|unique:radiology_centers,desc';

            }
        }

        return  $rules;
    }
}
