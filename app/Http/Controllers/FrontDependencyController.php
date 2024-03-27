<?php

namespace App\Http\Controllers;

use App\Http\Resources\FrontMenuDependencyResource;
use App\Models\CollectionGroup;
use Illuminate\Http\Request;

class FrontDependencyController extends Controller
{

    public function getMenu()
    {
        $collectionGroup = collect(CollectionGroup::query()->get())->map(fn($item) => [
            "id" => $item->id,
            "label" => $item->name,
            "path" => "#!"
        ]);

        return $this->respondWithSuccess(FrontMenuDependencyResource::collection($collectionGroup));
    }
}
