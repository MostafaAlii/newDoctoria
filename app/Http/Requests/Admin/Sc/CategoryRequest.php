<?php

namespace App\Http\Requests\Admin\Sc;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'color'=>'required',
                'main_service_id'=>'nullable|exists:main_services,id'
            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:sc_categories,name,' . $this->id . ',id';
                $rules["details.$language->abbreviation"] = 'required|unique:sc_categories,details,' . $this->id . ',id';

            }
        } else {
            $rules = [
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'color'=>'required',
                'main_service_id'=>'nullable|exists:main_services,id'

            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:sc_categories,name';
                $rules["details.$language->abbreviation"] = 'required|unique:sc_categories,details';

            }
        }

        return  $rules;
    }
}
