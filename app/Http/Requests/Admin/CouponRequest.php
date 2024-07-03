<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest
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
            'coupon_code' => ['required', 'string', 'max:255'],
            'coupon_type' => ['required', 'string', 'max:255'],
            'coupon_value' => ['required', 'integer'],
            'expired_date' => ['required'],
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
