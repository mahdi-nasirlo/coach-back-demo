<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatusEnums;
use App\Enums\ProductTypeEnums;
use App\Http\Resources\PostListResource;
use App\Models\Product;
use App\Services\ProductServices;
use Illuminate\Support\Facades\Request;

class PostController extends Controller
{

    public function index(Request $request, ProductServices $productServices)
    {

        $post = $productServices
            ->getTranslation()
//            ->inCollection(collection_group_id: null, collection_id: 10)
            ->query
            ->with("user:id,name", "collections.translations")
            ->where("status", ProductStatusEnums::PUBLISH->value)
            ->where("product_type", ProductTypeEnums::POST)
            ->paginate();
//        $post = Product::query()
//            ->with("user:id,name", )
//            ->paginate();

//        return $post;
        return PostListResource::collection($post);
    }

    public function show(Product $product)
    {
        //
    }

}
