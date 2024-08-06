<?php

namespace App\Http\Requests\Admin\Gc;

use Illuminate\Foundation\Http\FormRequest;

class MedicationTimeRequest extends FormRequest
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
                'time' => 'required|date_format:H:i|unique:gc_medication_times,time,'.$this->id,
            ];

        } else {
            $rules = [
                'time' => 'required|date_format:H:i|unique:gc_medication_times,time',
            ];


        }

        return  $rules;
    }
}
