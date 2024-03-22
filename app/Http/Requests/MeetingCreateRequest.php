<?php

namespace App\Http\Requests;

use App\Enums\CoachStatusEnum;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class MeetingCreateRequest extends FormRequest
{

    public function authorize(): bool
    {
        $status = auth()->user()?->coach?->status;

        return true;
//        return $status == CoachStatusEnum::ACCEPTED->value;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "collection_id" => "required|exists:collections,id",
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
