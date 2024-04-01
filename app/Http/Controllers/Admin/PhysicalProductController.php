<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductStatusEnums;
use App\Enums\ProductTypeEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\PhysicalProductCreateRequest;
use App\Models\Product;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhysicalProductController extends Controller
{

    public function index(Request $request)
    {
        $coaches = Product::translatedIn(app()->getLocale())
            ->select(["id", "stock", "status", "sku"])
            ->with("translation")
            ->physical()
            ->paginate();

        return $this->respondWithSuccess($coaches);
    }


    public function store(PhysicalProductCreateRequest $request)
    {
        DB::transaction(function () use ($request) {

            $product = Product::query()->create([
                "user_id" => auth()->id(),
                "name" => $request->name,
                "description" => $request->description,
                "attribute_data" => ["short_description" => $request->input("short_description")],
                "shippable" => true,
                "product_type" => ProductTypeEnums::PRODUCT->value,
                "status" => ProductStatusEnums::DRAFT->value,
                "stock" => $request->in_stock
            ]);

            $product->prices()->create(["price" => $request->price]);

            $collection_ids = collect($request->input("collection_ids"))
                ->pluck("id");

            $product->collections()->attach($collection_ids);

            $tmpFile = TemporaryFile::query()
                ->where("folder", $request->input("image_cover"))
                ->first();

            if ($tmpFile) {

                $pathToFile = $tmpFile->absolutFilePath();

                $product->media()->delete();

                $product
                    ->addMedia($pathToFile)
                    ->withCustomProperties(['mime-type' => 'image/jpeg'])
                    ->preservingOriginal()
                    ->toMediaCollection();

                $tmpFile->delete();

            }

        });

        return $this->respondWithSuccess();
    }


    public function show(Product $product)
    {
        //
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
