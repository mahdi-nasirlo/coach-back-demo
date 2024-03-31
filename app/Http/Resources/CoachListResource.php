<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CoachListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $media = new Media([
            "disk" => $this->media_disk,
            "id" => $this->media_id ,
            "file_name" => $this->media_filename
        ]);

        return [
            "name" => $this->product_type,
            "coach_id" => $this->coach_id,
            "coach_name" => $this->coach_name,
            "attribute_data" => $this->attribute_data,
            "profile_image" => $media->original_url,
            "price" => $this->price
        ];
    }
}
