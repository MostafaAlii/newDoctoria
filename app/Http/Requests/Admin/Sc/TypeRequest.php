<?php

namespace App\Http\Requests\Admin\Sc;

use Illuminate\Foundation\Http\FormRequest;

class TypeRequest extends FormRequest
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
                'sc_category_id'=>'nullable|exists:sc_categories,id',
                'status'=>'required|in:1,0',
                'have_experience'=>'required',
            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:sc_types,name,' . $this->id . ',id';
                $rules["details.$language->abbreviation"] = 'required|unique:sc_types,details,' . $this->id . ',id';

            }
        } else {
            $rules = [
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'color'=>'required',
                'sc_category_id'=>'nullable|exists:sc_categories,id',
                'status'=>'required|in:1,0',
                'have_experience'=>'required',

            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:sc_types,name';
                $rules["details.$language->abbreviation"] = 'required|unique:sc_types,details';

            }
        }

        return  $rules;
    }
}
