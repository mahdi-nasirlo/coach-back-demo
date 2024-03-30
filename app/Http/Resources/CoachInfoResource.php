<?php

namespace App\Http\Resources;

use App\Models\Coach;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Coach
 * @property User $user
 */
class CoachInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @mixed Coach
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "phone_number" => $this->phone_number,
            "profile_image" => $this->media()->orderByDesc("created_at")->first()?->uuid,
            "about_me" => $this->about_me,
            "job_experience" => $this->job_experience,
            "education_record" => $this->education_record,
            "resume_file" => $this->resume_file,
            "status" => $this->status,
            "user" => $this->whenLoaded("user", fn() => [
                "user_name" => $this->user->name,
                "email" => $this->user->email
            ]),
            "prices" => $this->whenLoaded(
                "user",
                $this->user->prices
            )
        ];
    }

}
