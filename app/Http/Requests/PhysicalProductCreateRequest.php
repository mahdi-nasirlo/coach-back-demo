<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PhysicalProductCreateRequest extends FormRequest
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
            "name" => "required|string|max:125",
            "brand" => "nullable|string|max:64",
            "short_description" => "nullable|string|max:1024",
            "description" => "required|string|min:10",
            "image_cover" => "required|exists:temporary_files,folder",
            "collection_ids" => "required|array|min:1",
            "collection_ids.*.id" => "required|numeric|exists:collections,id",
            "price" => "required|numeric|min:0",
            "in_stock" => "required|numeric|min:0"
        ];
    }
}
