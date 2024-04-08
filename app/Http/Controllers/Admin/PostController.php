<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductStatusEnums;
use App\Enums\ProductTypeEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        //
    }

    public function store(PostCreateRequest $request)
    {
        $productData = [
            "name" => $request->input("title"),
            "user_id" => auth()->id(),
            "description" => $request->input("content"),
            "product_type" => ProductTypeEnums::POST->value,
            "shippable" => false,
            "status" => $request->input("status") ? ProductStatusEnums::PUBLISH->value : ProductStatusEnums::DRAFT->value,
            "attribute_data" => [
                "pay_content" => $request->input("pay_content"),
                "should_pay" => $request->input("should_pay")
            ]
        ];

        $product = Product::query()
            ->create($productData);

        $product->prices()->create([
            "price" => $request->input("price")
        ]);

        $collection_ids = collect($request->input("blog_category_id"))->pluck("value");
        $product->collections()->attach($collection_ids);

        return $this->respondWithSuccess($product);
    }

    public function show(Product $product)
    {
        //
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }
}
