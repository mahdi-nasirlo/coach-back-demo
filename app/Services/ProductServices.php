<?php

namespace App\Services;

use App\Enums\ProductTypeEnums;
use App\Models\Product;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class ProductServices
{
    public array $meetingSelects;

    public Builder $query;

    public function __construct()
    {
        $this->meetingSelects = [
            DB::raw("(CASE WHEN product_type='" . ProductTypeEnums::MEET->value . "' THEN coach_translations.`coach_id` END) as coach_id"),
            DB::raw("(CASE WHEN product_type='" . ProductTypeEnums::MEET->value . "' THEN coach_translations.`name` END) as coach_name")
        ];

        $this->query = Product::query();
    }

    public function coacheInfo()
    {
        $this
            ->query
            ->leftJoin("coaches", function (JoinClause $join) {
                $join->on("coaches.user_id", "=", "products.user_id");
                $join->where("products.product_type", "=", "meet");
            })
            ->leftJoin("coach_translations", "coach_translations.coach_id", "=", "coaches.id");

        return $this;
    }

    public function inCollection(int $collection_group_id, ?int $collection_id = null)
    {
        return $this
            ->query
            ->leftJoin("collection_product", "collection_product.product_id", "=", "products.id")
            ->leftJoin("collections", "collections.id", "=", "collection_product.collection_id")
            ->where("collections.collection_group_id", "=", $collection_group_id)
            ->where("collections.id", "=", $collection_id);
    }

}
