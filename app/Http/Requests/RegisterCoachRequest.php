<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterCoachRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return is_null(auth()->user()?->coach);
    }

    protected function failedAuthorization(): void
    {
        throw new AuthorizationException("you all ready is registered");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:5',
            'phone_number' => [
                'required',
                'unique:coaches,phone_number',
                'regex:/^09(1[0-93[1-92[1-9])-?[0-9]{3}-?[0-9]{4}$/i'
            ],
            'about_me' => 'required|string|min:24',
            'resume_file' => 'nullable|string'
        ];
    }
}
