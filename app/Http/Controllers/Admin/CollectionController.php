<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Services\CollectionService;
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

    public function getAll(): JsonResponse
    {
        $collection = Collection::select(["id", "name", "collection_group_id"])
            ->with(["group:id,name"])
            ->get();

        return $this->respondWithSuccess($collection);
    }

    /**
     * @LRDparam name required|string|min:3
     * @LRDparam collection_group_id required|exists:collection_groups,id
     * @LRDparam image nullable|string|max:256
     * @LRDparam desc nullable|string
     */
    public function store(Request $request, CollectionService $collectionService): JsonResponse
    {
        $validate = $request->validate([
            "name" => "required|string|min:3|max:125",
            "desc" => "nullable|string",
            "collection_group_id" => "required|exists:collection_groups,id",
            "image" => "nullable|string|max:256",
            "parent_id" => "nullable|exists:collections,id",
        ]);

        Collection::create($validate);

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
