<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CustomizedNotificationRequest extends FormRequest
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
            'title' => 'required',
            'content' => 'required',
            'notification_type' => 'required',
            'user_type' => 'required',
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
            // 'title.required' => __('validation.required', ['attribute' => 'Language Code']),
            // 'language_name.required' => __('validation.required', ['attribute' => 'Language Name']),
        ];
    }
}
