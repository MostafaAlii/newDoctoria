<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
{


    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {

        if ($this->id){
            $rules= [
                'name' => 'required',
                'email' => "required|email|unique:doctors,email,".$this->id,
                'nickname' => 'required|unique:doctors,nickname,'.$this->id,
                'phone' => 'required|unique:patients,phone|unique:doctors,phone,' . $this->id,
                'private_number' => 'required',

                'password' => 'nullable|min:6',
                'gender'=>'required|in:male,female',
                'specialization_id'=>'required|exists:specializations,id',
                'sub_specialization_id'=>'required|exists:specializations,id',
                'governorate_id'=>'required|exists:governorates,id',
                'city_id'=>'required|exists:cities,id',
                'latitude'=>'required',
                'longitude'=>'required',
                'experience_years'=>'nullable',
                'lang'=>'required',
                'weight'=>'required',
                'location'=>'required',
                'is_popular'=>'required|in:0,1',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'service_price_online'=>'required|numeric',
                'service_price_home'=>'required|numeric',

            ];

            foreach (languages() as $language) {
                $rules["about.$language->abbreviation"] = 'nullable|unique:doctors,about,' . $this->id . ',id';
            }
        }
        else{
            $rules= [
                'name' => 'required',
                'email' => "required|email|unique:doctors,email",
                'nickname' => 'required|unique:doctors,nickname',
                'phone' => 'required|unique:patients,phone|unique:doctors,phone',
                'private_number' => 'required',
                'password' => 'required|min:6',
                'gender'=>'required|in:male,female',
                'specialization_id'=>'required|exists:specializations,id',
                'sub_specialization_id'=>'required|exists:specializations,id',
                'governorate_id'=>'required|exists:governorates,id',
                'city_id'=>'required|exists:cities,id',
                'lang'=>'required',
                'weight'=>'required',
                'location'=>'required',
                'is_popular'=>'required|in:0,1',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'service_price_online'=>'required|numeric',
                'service_price_home'=>'required|numeric',
                'latitude'=>'required',
                'longitude'=>'required',
                'experience_years'=>'nullable',




            ];

            foreach (languages() as $language) {
                $rules["about.$language->abbreviation"] = 'nullable|unique:doctors,about';
            }
        }

        return $rules;

    }
}
