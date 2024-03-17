<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute\Attribute;
use App\Models\Attribute\AttributeGroup;
use App\Models\CollectionGroup;
use App\Services\CollectionGroupService;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CollectionGroupController extends Controller
{
    public function index(CollectionGroupService $collectionGroupService): JsonResponse
    {
        return $this->respondWithSuccess(data: $collectionGroupService->getCollectionGroup());
    }

    /**
     * @LRDparam name required|string|min:3
     */
    public function store(Request $request, CollectionGroupService $collectionGroupService): JsonResponse
    {
        $rules = RuleFactory::make([
            "%name%" => "required|string|min:3",
            "handle" => "required|string|min:3"
        ]);

        $validate = $request->validate($rules);

        $create = CollectionGroup::query()->create($validate);

        $attributeGroup = $collectionGroupService->getCollectionGroup();

        return $this->respondWithSuccess(data: $attributeGroup);
    }

    /**
     * Display the specified resource.
     */
    public function show(CollectionGroup $test)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CollectionGroup $test)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CollectionGroup $test)
    {

    }
}
