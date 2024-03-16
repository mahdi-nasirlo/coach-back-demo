<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|max:125|min:3',
            'email' => "required|email|unique:users,email",
            'password' => "required|min:8|confirmed"
        ];
    }
}
