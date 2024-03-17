<?php

namespace App\Services;

use App\Models\Store\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class CollectionService
{
    public function getCollectionWithChild(?int $collection_id, int $collection_group_id): EloquentCollection|array
    {
        return Collection::query()
            ->where("parent_id", $collection_id)
            ->where("collection_group_id", $collection_group_id)
            ->get();
    }

    public function getBreadcrumbAttribute(Collection $collection)
    {
        return Collection::select(["id", "name"])
            ->whereAncestorOrSelf($collection)
            ->get();
    }

}
