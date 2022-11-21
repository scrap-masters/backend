<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Http\Resources\FacultyFieldsResource;
use App\Http\Resources\FacultyResource;
use App\Http\Resources\FacultySimpleResource;
use App\Models\Faculty;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FacultyService
{
    public function getAllFaculties(): ResourceCollection
    {
        $faculties = Faculty::query()->get();
        return FacultySimpleResource::collection($faculties);
    }

    public function getFieldsByFaculty(int $facultyId): FacultyFieldsResource
    {
        $faculty = Faculty::findByFacultyId($facultyId);
        return new FacultyFieldsResource($faculty);
    }

    public function getFacultyById(int $facultyId): FacultyResource
    {
        $faculty = Faculty::findByFacultyId($facultyId);
        return new FacultyResource($faculty);
    }
}
