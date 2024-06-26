<?php


use App\Http\Controllers\Admin\CoachController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\CollectionGroupController;
use App\Http\Controllers\Admin\MeetingController;
use App\Http\Controllers\Admin\PhysicalProductController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\FileManagementController;
use Illuminate\Support\Facades\Route;

Route::group(["name" => "file-management.", "prefix" => "/file-management"], function () {

    Route::Post("", [FileManagementController::class, "store"])->name("upload");

    Route::get("{filename}", [FileManagementController::class, "fetch"])->name("fetch");

    Route::post("/chunk/store", [FileManagementController::class, "chunkStore"]);

    Route::post("/chunk/update", [FileManagementController::class, "chunkUpdate"]);

});

Route::apiResource("/collection-groups", CollectionGroupController::class);

Route::apiResource("/collection", CollectionController::class)->except("show");

Route::get("/collection/get-all", [CollectionController::class, "getAll"]);

Route::get("/collection/get-breadcrumb/{collection}", [CollectionController::class, "getBreadcrumb"]);

Route::apiResource("/coach", CoachController::class)->except(["destroy", "store"]);

Route::post("/coach/change-status/{coach}", [CoachController::class, "changeStatus"]);

Route::apiResource("/meeting", MeetingController::class);

Route::apiResource("/physicalProduct", PhysicalProductController::class);

Route::apiResource("/post", PostController::class);
