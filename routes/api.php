<?php

declare(strict_types=1);

use App\Http\Controllers\FacultyController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\LecturesController;
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
        Route::get("/faculties/{id}/fields", "fieldsIndex");
        Route::get("/faculties/{id}", "show");
    });
    Route::controller(FieldController::class)->group(function (): void {
        Route::get("/fields", "index");
        Route::get("/fields/{id}/specializations", "specializationsIndex");
        Route::get("/fields/{id}", "show");
    });
    Route::controller(SpecializationController::class)->group(function (): void {
        Route::get("/specializations", "index");
        Route::get("/specializations/{id}/timetable", "timetableIndex");
        Route::get("/specializations/{id}/legend", "legendIndex");
        Route::get("/specializations/{id}", "show");
    });
    Route::controller(LecturesController::class)->group(function (): void {
        Route::get("/lecturers", "index");
        Route::get("/lecturers/{name}", "getPlanForLecturerByName");
    });
});
