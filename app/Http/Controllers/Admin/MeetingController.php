<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CoachStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\MeetingCreateRequest;
use App\Services\MeetingService;
use Illuminate\Http\Request;

class MeetingController extends Controller
{

    public function __construct(public MeetingService $meetingService)
    {
    }

    public function index()
    {
        //
    }

    public function store(MeetingCreateRequest $request)
    {
        $meet = $this->meetingService->getMeetingRecord();

        return $this->respondWithSuccess(auth()->user()?->coach->status == CoachStatusEnum::ACCEPTED->value);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
