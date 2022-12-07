<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\FacultyFieldsResource;
use App\Http\Resources\FacultyResource;
use App\Services\Api\FacultyService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FacultyController extends Controller
{
    public function __construct(
        public FacultyService $service,
    ) {}

    public function index(): ResourceCollection
    {
        return $this->service->getAllFaculties();
    }

    public function fieldsIndex(int $id): FacultyFieldsResource
    {
        return $this->service->getFieldsByFaculty($id);
    }

    public function show(int $id): FacultyResource
    {
        return $this->service->getFacultyById($id);
    }
}
