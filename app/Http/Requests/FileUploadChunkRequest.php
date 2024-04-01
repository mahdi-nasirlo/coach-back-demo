<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileUploadChunkRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "patch" => "required|numeric",
            "upload_length" => "required|numeric",
            "upload_name" => "required|string",
            "chunk" => "required|file"
        ];
    }
}
