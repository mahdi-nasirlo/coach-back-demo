<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostListResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            "title" => $this->name,
            "excerpt" => $this->description,
            "postedAt" => $this->created_at,
            "author" => [
                "name" => $this->user->name
            ],
            "category" =>  collect($this->collections)->map(fn($collection) => ["title" => $collection->name]),
            "views" => 243,
        ];
    }
}
