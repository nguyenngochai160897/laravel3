<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title" => "required",
            "snapshort" => "required",
            "content" => "required",
            "state" => "required",
            "image" => "mimes:jpeg,jpg,png"
        ];
    }
}
