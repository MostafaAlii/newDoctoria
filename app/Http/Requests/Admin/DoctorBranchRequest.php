<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DoctorBranchRequest extends FormRequest
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
                'phone' => 'required',
                'latitude'=>'required',
                'longitude'=>'required',
                'location'=>'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'price'=>'required|numeric',

            ];

            foreach (languages() as $language) {
                $rules["about.$language->abbreviation"] = 'nullable';
            }
        }
        else{
            $rules= [
                'name' => 'required',
                'phone' => 'required',
                'latitude'=>'required',
                'longitude'=>'required',
                'location'=>'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'price'=>'required|numeric',



            ];

            foreach (languages() as $language) {
                $rules["about.$language->abbreviation"] = 'nullable';
            }
        }

        return $rules;

    }
}
