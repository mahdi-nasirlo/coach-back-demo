<?php

namespace App\Services;

use App\Models\Attribute\AttributeGroup;
use Illuminate\Database\Eloquent\Collection;

class AttributeService
{

    public function getPageAttributeGroupWithChild(): Collection
    {
        return AttributeGroup::query()->with(["attributes"])->get();
    }
}
