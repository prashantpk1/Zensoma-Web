<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Validation\Rule;
use App\Models\User;


class SubAdminRequest extends FormRequest
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
            // 'first_name' => ['required','string','min:3','max:32'],
            // 'last_name' => ['required','string','min:3','max:32'],
            'name' => ['required','string','min:3','max:32'],
            'role_name' => ['required','string'],
            'phone' => ['required','digits_between:8,12'],
            'gender' => ['required'],
            'profile_image' => ['required'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required'],
            'admin_commission' => ['required','numeric'],
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

        ];
    }
}
