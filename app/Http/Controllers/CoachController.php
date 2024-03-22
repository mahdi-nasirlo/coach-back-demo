<?php

namespace App\Http\Controllers;

use App\Enums\CoachStatusEnum;
use App\Http\Requests\RegisterCoachRequest;
use App\Models\Coach;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoachController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
