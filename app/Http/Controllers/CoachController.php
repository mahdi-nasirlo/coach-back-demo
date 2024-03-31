<?php

namespace App\Http\Controllers;

use App\Enums\CoachStatusEnum;
use App\Http\Requests\RegisterCoachRequest;
use App\Http\Resources\CoachListResource;
use App\Models\Coach;
use App\Services\ProductServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoachController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ProductServices $productServices)
    {
        $validate = $request->validate([
            "collection_id" => "required|numeric|exists:collections,id"
        ]);

        $coaches = $productServices
            ->inCollection(collection_group_id: null, collection_id: $validate["collection_id"])
            ->coacheInfo(collection_id: $validate["collection_id"])
            ->query
            ->select(array_merge(
                [
                    "product_type"
                ],
                $productServices->meetingSelects
            ))
            ->paginate();

//        return $this->respondWithSuccess($coaches);
        return CoachListResource::collection($coaches)
            ->additional([
                "success" => true,
                "message" => ""
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Coach $coach)
    {
        return $this->respondWithSuccess($coach);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coach $coach)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coach $coach)
    {
        //
    }

    public function register(RegisterCoachRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated["status"] = CoachStatusEnum::UNDONE;
        $validated["user_id"] = Auth::user()->id;

        Coach::query()->create($validated);

        return $this->respondWithSuccess('your registration successfully');
    }

}
