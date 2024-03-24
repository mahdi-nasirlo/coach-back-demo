<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CoachStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CoachCreateRequest;
use App\Models\Coach;
use App\Services\MeetingService;
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
    public function store(CoachCreateRequest $request, MeetingService $meetingService)
    {
        $coachData = $request->only([
            'name',
            'phone_number',
            'about_me',
            'resume',
            'job_experience',
            'education_record'
        ]);

        auth()->user()->coach->update($coachData);

        $meetingService->updateVariants($request->input("pricing"));

        return $this->respondWithSuccess();
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
