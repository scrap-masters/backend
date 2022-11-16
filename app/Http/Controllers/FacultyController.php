<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\IndexFacultiesService;
use Illuminate\Http\JsonResponse;

class FacultyController extends Controller
{
    public function get(): JsonResponse
    {
        $service = new IndexFacultiesService();
        $faculties = $service->index();

        return new JsonResponse(["faculties" => $faculties]);
    }
}
