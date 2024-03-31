<?php

namespace App\Services;

use App\Enums\ProductTypeEnums;
use App\Models\Coach;
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
            DB::raw("(CASE WHEN product_type='" . ProductTypeEnums::MEET->value . "' THEN media.`disk` END) as media_disk"),
            DB::raw("(CASE WHEN product_type='" . ProductTypeEnums::MEET->value . "' THEN media.`id` END) as media_id"),
            DB::raw("(CASE WHEN product_type='" . ProductTypeEnums::MEET->value . "' THEN prices.`price` END) as price"),
            DB::raw("(CASE WHEN product_type='" . ProductTypeEnums::MEET->value . "' THEN media.`file_name` END) as media_filename"),
            DB::raw("(CASE WHEN product_type='" . ProductTypeEnums::MEET->value . "' THEN coach_translations.`coach_id` END) as coach_id"),
            DB::raw("(CASE WHEN product_type='" . ProductTypeEnums::MEET->value . "' THEN coach_translations.`name` END) as coach_name")
        ];

        $this->query = Product::query();
    }

    public function coacheInfo(?int $collection_id = null): static
    {
        $this
            ->query
//            ->hasManyThrough(related: Price::class, through: Product::class, secondKey: "priceable_id")
            ->leftJoin("coaches", function (JoinClause $join) {
                $join->on("coaches.user_id", "=", "products.user_id");
                $join->where("products.product_type", "=", ProductTypeEnums::MEET->value);
            })
            ->leftJoin("coach_translations", function (JoinClause $join) {
                $join->on("coach_translations.coach_id", "=", "coaches.id");
                $join->where("products.product_type", "=", ProductTypeEnums::MEET->value);
            })
            ->leftJoin("media", function (JoinClause $join) {
                $join->on("media.model_id", "=", "coaches.id");
                $join->where("media.model_type", "=", Coach::class);
                $join->limit(1);
            })
            ->leftJoin("prices", function (JoinClause $join) use ($collection_id) {
                $join->on("prices.priceable_id", "=", "collection_product.product_id");
                $join->when($collection_id, function () use ($join, $collection_id) {
                    $join->whereJsonContains("attribute_data", ["collection_id" => $collection_id]);
                });
            });

        return $this;
    }

    public function inCollection(?int $collection_group_id, ?int $collection_id = null)
    {
        $this
            ->query
            ->leftJoin("collection_product", "collection_product.product_id", "=", "products.id")
            ->leftJoin("collections", "collections.id", "=", "collection_product.collection_id")
            ->when(
                $collection_group_id,
                fn(Builder $query) => $query->where("collections.collection_group_id", "=", $collection_group_id)
            )
            ->when(
                $collection_id,
                fn(Builder $query) => $query->where("collections.id", "=", $collection_id)
            );

        return $this;
    }

}
