<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Http\Resources\FacultySimpleResource;
use App\Models\Faculty;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IndexFacultiesService
{
    public function index(): ResourceCollection
    {
        $faculties = Faculty::query()->get();

        return FacultySimpleResource::collection($faculties);
    }
}
