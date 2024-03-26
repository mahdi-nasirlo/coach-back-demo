<?php

namespace App\Http\Resources;

use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Coach
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
            "name" => $this->name,
            "about_me" => $this->about_me,
            "job_experience" => $this->job_experience,
            "education_record" => $this->education_record,
            "resume_file" => $this->resume_file,
            "phone_number" => $this->phone_number,
            "status" => $this->status
        ];
    }
}
