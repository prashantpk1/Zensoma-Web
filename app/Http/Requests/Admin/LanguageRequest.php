<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'language_code' => 'required|string|min:2|max:5',
            'language_name' => 'required|string|min:2|max:50',
        ];
    }


    /**
     * Method messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'language_code.required' => __('validation.required', ['attribute' => 'Language Code']),
            'language_name.required' => __('validation.required', ['attribute' => 'Language Name']),
        ];
    }
}
