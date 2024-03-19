<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CoachStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CoachController extends Controller
{

    public function index()
    {
        $coaches = Coach::query()->paginate();

        return $this->respondWithSuccess($coaches);
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
        if (CoachStatusEnum::isUndone($coach)) {

            $coach->update(["status" => CoachStatusEnum::PENDING]);

        }

        return $this->respondWithSuccess($coach, message: $coach->status == CoachStatusEnum::UNDONE);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coach $coach)
    {
        $validated = $request->validate([
            "status" => Rule::in([CoachStatusEnum::ACCEPTED->value, CoachStatusEnum::REJECTED->value])
        ]);

        $update = $coach->update($validated);

        return $this->response(success: $update);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coach $coach)
    {
        //
    }
}
