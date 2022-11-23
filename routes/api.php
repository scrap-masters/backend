<?php

declare(strict_types=1);

use App\Http\Controllers\FacultyController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\SpecializationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix("/v1")->group(function (): void {
    Route::controller(FacultyController::class)->group(function (): void {
        Route::get("/faculties", "index");
        Route::get("/faculties/{facultyId}/fields", "fieldsIndex")->where("facultyId", "[0-9]+");
        Route::get("/faculties/{facultyId}", "show")->where("facultyId", "[0-9]+");
    });
    Route::controller(FieldController::class)->group(function (): void {
        Route::get("/fields", "index");
        Route::get("/fields/{fieldId}/specializations", "specializationsIndex")->where("fieldId", "[0-9]+");
        Route::get("/fields/{fieldId}", "show")->where("fieldId", "[0-9]+");
    });
    Route::controller(SpecializationController::class)->group(function (): void {
        Route::get("/specializations", "index");
        Route::get("/specializations/{specializationId}/timetable", "timetableIndex")->where("specializationId", "[0-9]+");
        Route::get("/specializations/{specializationId}", "show")->where("specializationId", "[0-9]+");
    });
});
