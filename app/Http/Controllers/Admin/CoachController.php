<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CoachStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CoachUpdateRequest;
use App\Http\Resources\CoachInfoResource;
use App\Models\Coach;
use App\Models\TemporaryFile;
use App\Services\MeetingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CoachController extends Controller
{

    public function index(): JsonResponse
    {
        $coaches = Coach::query()->paginate();

        return $this->respondWithSuccess($coaches);
    }

    /**
     * Display the specified resource.
     */
    public function show(Coach $coach)
    {
        if (CoachStatusEnum::isUndone($coach)) {

            $coach->update(["status" => CoachStatusEnum::PENDING]);

        }

        $coach->load(["user.prices"]);

        return $this->respondWithSuccess(new CoachInfoResource($coach), message: $coach->status == CoachStatusEnum::UNDONE);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CoachUpdateRequest $request, Coach $coach): JsonResponse
    {
        $coachData = $request->only([
            'name',
            'phone_number',
            'about_me',
            'resume',
            'job_experience',
            'education_record'
        ]);

        $coach->update($coachData);

        $tmpFile = TemporaryFile::query()
            ->where("folder", $request->input("profile_image"))
            ->first();

        if ($tmpFile) {

            $pathToFile = $tmpFile->absolutFilePath();

            $coach->media()->delete();

            $coach
                ->addMedia($pathToFile)
                ->withCustomProperties(['mime-type' => 'image/jpeg'])
                ->preservingOriginal()
                ->toMediaCollection();

            $tmpFile->delete();

        }

        (new MeetingService($coach))->updateVariants($request->input("prices"));

        return $this->respondWithSuccess();
    }

    public function changeStatus(Request $request, Coach $coach): JsonResponse
    {
        $validated = $request->validate([
            "status" => Rule::in([CoachStatusEnum::ACCEPTED->value, CoachStatusEnum::REJECTED->value])
        ]);

        $update = $coach->update($validated);

        return $this->response(success: $update);
    }
}
