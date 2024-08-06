<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
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
                'code'                  => 'required|string|unique:vouchers,code,' . $this->id . ',id',
                'start_at'              => 'required|date',
                'end_at'                => 'required|date',
                'count_consultations'   => 'required',
            ];

        } else {
            $rules = [
                'code'                  => 'required|string|unique:vouchers,code',
                'start_at'              => 'required|date',
                'end_at'                => 'required|date',
                'count_consultations'   => 'required',
            ];
        }

        return  $rules;

    }
}
