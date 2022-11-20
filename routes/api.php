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
        Route::get("/faculties/{faculty}/fields", "fieldsIndex");
        Route::get("/faculties/{faculty}", "show");
    });
    Route::controller(FieldController::class)->group(function (): void {
        Route::get("/fields", "index");
        Route::get("/fields/{field}/specializations", "specializationsIndex");
        Route::get("/fields/{field}", "show");
    });
    Route::controller(SpecializationController::class)->group(function (): void {
        Route::get("/specializations", "index");
        Route::get("/specializations/{specialization}", "show");
    });
});
