<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules()
    {
        return [
            "title" => "required",
            "snapshort" => "required",
            "content" => "required",
            "state" => "required",
            "image" => "required|mimes:jpeg,jpg,png"
        ];
    }
}
