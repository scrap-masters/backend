<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\FacultyResource;
use App\Models\Faculty;
use App\Services\Api\IndexFacultiesService;
use App\Services\Api\ShowFacultyService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FacultyController extends Controller
{
    public function index(): ResourceCollection
    {
        $service = new IndexFacultiesService();

        return $service->index();
    }

    public function show(Faculty $faculty): FacultyResource
    {
        $service = new ShowFacultyService();

        return $service->show($faculty);
    }
}
