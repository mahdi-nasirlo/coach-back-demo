<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Services\CollectionService;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * @LRDparam collection_group_id required|numeric|exists:collection_groups,id
     * @LRDparam collection_id nullable|numeric|exists:collections,id
     */
    public function index(Request $request, CollectionService $collectionService): JsonResponse
    {
        $validate = $request->validate([
            "collection_group_id" => "required|numeric|exists:collection_groups,id",
            "collection_id" => "nullable|numeric|exists:collections,id"
        ]);

        $collection = $collectionService->getCollectionWithChild(
            collection_id: $validate["collection_id"] ?? null,
            collection_group_id: $validate["collection_group_id"]
        );

        return $this->respondWithSuccess($collection);
    }

    public function getAll(Request $request): JsonResponse
    {
        $validate = $request->validate([
            "collection_group_id" => "nullable|exists:collection_groups,id"
        ]);

        $collection = Collection::query()
            ->when($validate["collection_group_id"], fn($builder) => $builder
                ->where("collection_group_id", $request->input("collection_group_id")))
            ->with(["group"])
            ->get();

        return $this->respondWithSuccess($collection);
    }

    /**
     * @LRDparam fa.name required|string|min:3
     * @LRDparam fa.description nullable|string|min:3
     * @LRDparam en.name required|string|min:3
     * @LRDparam en.description nullable|string|min:3
     * @LRDparam collection_group_id required|exists:collection_groups,id
     * @LRDparam image nullable|string|max:256
     * @LRDparam desc nullable|string
     */
    public function store(Request $request, CollectionService $collectionService): JsonResponse
    {
        $rules = RuleFactory::make([
            "%name%" => "required|string|min:3|max:125",
            "%description%" => "nullable|string",
            "collection_group_id" => "required|exists:collection_groups,id",
            "image" => "nullable|string|max:256",
            "parent_id" => "nullable|exists:collections,id",
        ]);

        $validate = $request->validate($rules);

        Collection::query()->create($validate);

        $collection = $collectionService->getCollectionWithChild(
            collection_id: $request->has("parent_id") ? $validate["parent_id"] : null,
            collection_group_id: $validate["collection_group_id"]
        );

        return $this->respondWithSuccess(data: $collection);
    }

    public function update(Request $request, Collection $collection, CollectionService $collectionService)
    {

    }

    public function destroy(Collection $collection): JsonResponse
    {
        $delete = $collection->delete();

        return $this->response($delete);
    }

    public function getBreadcrumb(Request $request, Collection $collection, CollectionService $collectionService): JsonResponse
    {
        $breadcrumb = $collectionService->getBreadcrumbAttribute(collection: $collection);

        return $this->respondWithSuccess($breadcrumb);
    }
}
