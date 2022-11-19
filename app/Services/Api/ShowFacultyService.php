<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Http\Resources\FacultyResource;
use App\Models\Faculty;

class ShowFacultyService
{
    public function show(Faculty $faculty): FacultyResource
    {
        return new FacultyResource($faculty);
    }
}
