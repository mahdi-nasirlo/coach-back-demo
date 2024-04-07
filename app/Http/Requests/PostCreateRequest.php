<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<>|string>
     */
    public function rules(): array
    {
        return [
            "title" => "required|string|min:4|max:64",
            "status" => "required|boolean",
            "price" => "required|string|min_digits:0",
            "pay_content" => "nullable|string",
            "content" => "required|string|min:24",
            "blog_category_id" => "required|exists:collections,id",
            "image" => [
                "required" ,
                "exists:temporary_files,folder",
//                Rule::in(TemporaryFile::$imageTypes)
            ],
            "attachment" => ["array"],
            "attachment.*" => [
                "required" ,
                "exists:temporary_files,folder",
//                Rule::in(array_merge(
//                    TemporaryFile::$imageTypes,
//                    TemporaryFile::$videoTypes,
//                    TemporaryFile::$audioTypes
//                ))
            ]
        ];
    }
}
