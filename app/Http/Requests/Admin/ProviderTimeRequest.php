<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProviderTimeRequest extends FormRequest
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
        return [

            'from_time'=>'required|array',
            'from_time.*'=>'required',
            'to_time'=>'required|array',
            'to_time.*'=>'required',
            'type'=>'nullable|array',
            'type.*'=>'nullable|in:online,offline,home',
            'day_id'=>'required|array',
            'day_id.*'=>'required|exists:days,id',
            'category_id'=>'nullable|array',
            'category_id.*'=>'nullable|exists:categories,id',
        ];
    }
}
