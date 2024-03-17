<?php

namespace App\Services;

use App\Models\CollectionGroup;
use Illuminate\Database\Eloquent\Collection;

class CollectionGroupService
{
    public function getCollectionGroup(): Collection
    {
        return CollectionGroup::query()->get();
    }
}
