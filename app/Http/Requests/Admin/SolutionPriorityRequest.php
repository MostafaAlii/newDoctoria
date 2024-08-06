<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SolutionPriorityRequest extends FormRequest
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
            ];

            foreach (languages() as $language) {
                $rules["value.$language->abbreviation"] = 'required|unique:solution_priorities,value,' . $this->id . ',id';
            }
        } else {
            $rules = [
            ];

            foreach (languages() as $language) {
                $rules["value.$language->abbreviation"] = 'required|unique:solution_priorities,value';
            }
        }

        return  $rules;
    }
}
