<?php

namespace App\Services;

use App\Enums\ProductStatusEnums;
use App\Enums\ProductTypeEnums;
use App\Models\Coach;
use App\Models\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MeetingService
{

    public Coach $coach;

    public function __construct(Coach $coach)
    {
        $this->coach = $coach;
    }

    public function getMeetingRecord(): Model
    {
        return $this->coach->user->products()->firstOrCreate([
            "user_id" => auth()->id(),
            "product_type" => ProductTypeEnums::MEET->value,
            "status" => ProductStatusEnums::DRAFT->value
        ]);
    }

    public function getVariantsCount()
    {
        return $this->getMeetingRecord()->variants->count();
    }

    public function updateVariants($variants): void
    {

        $validated = Validator::validate($variants, [
            "*.price" => "required|numeric|min:0",
            "*.collection_id" => "required|numeric|min:0"
        ]);

        $product = $this->getMeetingRecord();

        $prices = $product->prices()->count();

        if ($prices) {
            $product->prices()->delete();
            $product->collections()->detach();
        }

        DB::transaction(function () use ($validated, $product) {

            foreach ($validated as $key => $value) {

                $collection = Collection::query()->find($value["collection_id"]);

                $price = [
                    "price" => $value["price"],
                    "attribute_data" => [
                        "collection_name" => $collection->name,
                        "collection_id" => $collection->id
                    ]
                ];

                $product->prices()->create($price);
                $product->collections()->attach($value["collection_id"]);
            }

        });

    }
}
