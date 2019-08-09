<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            "password" => "required",
            "c_password" => "required|same:password"
        ];
    }

    function messages()
    {
        return [
            'c_password.same' => "Confirm password must match with password"
        ];
    }
}
