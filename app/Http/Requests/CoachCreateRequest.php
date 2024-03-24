<?php

namespace App\Http\Requests;

use App\Enums\CoachStatusEnum;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class CoachCreateRequest extends FormRequest
{

    public function authorize(): bool
    {
        $status = auth()->user()?->coach?->status;

        return $status == CoachStatusEnum::ACCEPTED->value;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "profile_image" => "required|numeric", //|exists:temporary_files,folder
            "name" => "required|string|max:125",
            'phone_number' => [
                'required',
                Rule::unique("coaches", "phone_number")
                    ->ignore(auth()->user()->coach->id),
                'regex:/^09(1[0-93[1-92[1-9])-?[0-9]{3}-?[0-9]{4}$/i'
            ],
            "about_me" => 'required|string|min:24',
            "pricing.*.collection_id" => "required|numeric|exists:collections,id",
            "pricing.*.price" => "required|numeric",
            "resume" => "nullable|string|min:12",
            "job_experience" => "nullable|string|min:12",
            "education_record" => "nullable|string|min:12",
        ];
    }

    protected function failedAuthorization(): void
    {
        $status = auth()->user()?->coach?->status;

        Log::info(auth()->user());

        $message = match ($status) {
            CoachStatusEnum::INACTIVE->value => "please active your coaching profile.",
            CoachStatusEnum::PENDING->value => "Your coaching profile information is being checked.",
            CoachStatusEnum::REJECTED->value => "Your coaching profile information has been rejected, please correct it.",
            default => "your not have coaching profile please submit data as teacher",
        };

        throw new AuthorizationException($message);
    }
}
