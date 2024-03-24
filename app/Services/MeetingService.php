<?php

namespace App\Services;

use App\Enums\ProductStatusEnums;
use App\Enums\ProductTypeEnums;
use App\Models\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MeetingService
{
    public function getMeetingRecord()
    {
        return auth()->user()->products()->firstOrCreate([
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

        $validated = Validator::make($variants, [
            "*.price" => "required|numeric|min:0",
            "*.collection_id" => "required|numeric|min:0"
        ])->validate();

        $product = $this->getMeetingRecord();

        DB::transaction(function () use ($validated, $product) {

            foreach ($validated as $key => $value) {

                $price = [
                    "price" => $value["price"],
                    "attribute_data" => ["name" => Collection::query()->find($value["collection_id"])->name]
                ];

                $product->prices()->create($price);
                $product->collections()->attach($value["collection_id"]);
            }

        });

    }
}
