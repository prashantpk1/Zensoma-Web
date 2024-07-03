<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
            // 'first_name' => ['required', 'string', 'max:255'],
            // 'last_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required'],
            'gender' => ['required'],

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
            // 'blog_image.required' => __('validation.required', ['attribute' => 'Blog Image']),
            // 'key.required' => __('validation.required', ['attribute' => 'Blog Key']),
            // 'language_name.required' => __('validation.required', ['attribute' => 'Language Name']),
        ];
    }
}
