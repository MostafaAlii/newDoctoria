<?php

namespace App\Http\Requests\Admin\Sc;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        if ($this->id) {
            $rules = [
                'have_request'=>'required',
                'sessions_non'=>'required',
                'sc_type_id'=>'nullable|exists:sc_types,id',
                'experience_id'=>'nullable|exists:experiences,id',
                'price'=>'required|numeric',
            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:sc_services,name,' . $this->id . ',id';
                $rules["description.$language->abbreviation"] = 'required|unique:sc_services,description,' . $this->id . ',id';

            }
        } else {
            $rules = [
                'have_request'=>'required',
                'sessions_non'=>'required',
                'sc_type_id'=>'nullable|exists:sc_types,id',
                'experience_id'=>'nullable|exists:experiences,id',
                'price'=>'required|numeric',
            ];

            foreach (languages() as $language) {
                $rules["name.$language->abbreviation"] = 'required|unique:sc_services,name';
                $rules["description.$language->abbreviation"] = 'required|unique:sc_services,description';

            }
        }

        return  $rules;
    }
}
