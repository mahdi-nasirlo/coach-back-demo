<?php


use App\Http\Controllers\Admin\CoachController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\CollectionGroupController;
use Illuminate\Support\Facades\Route;

Route::apiResource("/collection-groups", CollectionGroupController::class);

Route::apiResource("/collection", CollectionController::class)->except("show");

Route::get("/collection/get-all", [CollectionController::class, "getAll"]);

Route::get("/collection/get-breadcrumb/{collection}", [CollectionController::class, "getBreadcrumb"]);

Route::apiResource("/coach", CoachController::class);
