<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\SpecializationResource;
use App\Http\Resources\SpecializationTimetableResource;
use App\Services\Api\SpecializationService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SpecializationController extends Controller
{
    public function __construct(
        public SpecializationService $service,
    ) {}

    public function index(): ResourceCollection
    {
        return $this->service->getAllSpecializations();
    }

    public function timetableIndex(int $specializationId): SpecializationTimetableResource
    {
        return $this->service->getTimetableBySpecialization($specializationId);
    }

    public function show(int $specializationId): SpecializationResource
    {
        return $this->service->getSpecializationById($specializationId);
    }
}
