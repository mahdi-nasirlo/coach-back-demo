<?php

namespace App\Http\Controllers;

use App\Models\CollectionGroup;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FrontDependencyController extends Controller
{

    public function getMenu()
    {
        $collectionGroup = collect(
            CollectionGroup::query()
                ->with([
                    "translations",
                    "collections" => fn(HasMany $query) => $query->with("translations")->whereNull("parent_id")
                ])
                ->get()
        )
            ->map(fn($item) => [
                "id" => $item->id,
                "label" => $item->name,
                "path" => "#!",
                "submenu" => $item->collections?->map(fn($submenu) => [
                    "id" => $submenu->id,
                    "label" => $submenu->name,
                    "path" => "#!",
                ])
            ]);

        return $this->respondWithSuccess($collectionGroup);
    }
}
