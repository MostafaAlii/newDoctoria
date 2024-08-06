<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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

        if ($this->id){
            return [
                'name' => 'required|unique:patients,name,'.$this->id,
                'refer_code' => "nullable|unique:patients,refer_code,".$this->id,
                'nickname' => 'required|unique:patients,nickname,'.$this->id,
                'phone' => 'required|unique:patients,phone,' . $this->id . '|unique:doctors,phone',
                'gender'=>'required|in:male,female',
                'postcode'=>'nullable|unique:patients,postcode,'.$this->id,
                'city_id'=>'required|exists:cities,id',
                'nationality_id'=>'required|exists:nationalities,id',
                'package_id'=>'nullable||exists:packages,id',
                'address'=>'required',
                'status'=>'required|in:0,1',
                'email' => 'required|unique:patients,email,'.$this->id,
                'password'=>'nullable',


            ];
        }
        else{
            return [
                'name' => 'required|unique:patients,name',
                'refer_code' => "nullable|unique:patients,refer_code",
                'nickname' => 'required|unique:patients,nickname',
                'phone' => 'required|unique:patients,phone|unique:doctors,phone',
                'gender'=>'required|in:male,female',
                'postcode'=>'nullable|unique:patients,postcode',
                'city_id'=>'required|exists:cities,id',
                'nationality_id'=>'required|exists:nationalities,id',
                'package_id'=>'nullable||exists:packages,id',
                'address'=>'required',
                'status'=>'required|in:0,1',
                'email' => 'required|unique:patients,email',
                'password'=>'required',

            ];
        }


    }
}
