<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PharmacyBranchRequest extends FormRequest
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

                'location'=>'required|string',
                'latitude'=>'required',
                'longitude'=>'required',
                'whatsapp'=>'required',
                'email'=>'required|required',
                'mobile'=>'required',
                'phone'=>'required',
                'governorate_id'=>'required|exists:governorates,id',
                'city_id'=>'required|exists:cities,id',

            ];

            foreach (languages() as $language) {

            }
        } else {
            $rules = [

                'location'=>'required|string',
                'latitude'=>'required',
                'longitude'=>'required',
                'whatsapp'=>'required',
                'email'=>'required|required',
                'mobile'=>'required',
                'phone'=>'required',
                'pharmacy_id'=>'required|exists:pharmacies,id',
                'governorate_id'=>'required|exists:governorates,id',
                'city_id'=>'required|exists:cities,id',


            ];

            foreach (languages() as $language) {

            }
        }

        return  $rules;
    }
}
