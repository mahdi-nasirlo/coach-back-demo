<?php

namespace App\Services;

use App\Models\Collection;

class CollectionService
{
    public function getCollectionWithChild(?int $collection_id, int $collection_group_id)
    {

        $productServices = new ProductServices();

        $products = $productServices
            ->inCollection($collection_group_id, $collection_id)
            ->coacheInfo()
            ->getTranslation()
            ->query
            ->select(array_merge(
                [
                    "product_type"
                ],
                $productServices->meetingSelects,
                $productServices->productTranslation
            ))
            ->get();

        return Collection::query()
            ->with("translation")
            ->where("parent_id", $collection_id)
            ->where("collection_group_id", $collection_group_id)
            ->get()
            ->concat($products);

    }

    public function getBreadcrumbAttribute(Collection $collection)
    {
        return Collection::select(["id", "name"])
            ->whereAncestorOrSelf($collection)
            ->get();
    }

}
