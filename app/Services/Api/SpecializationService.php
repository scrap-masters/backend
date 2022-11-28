<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Http\Resources\SpecializationLegendResource;
use App\Http\Resources\SpecializationResource;
use App\Http\Resources\SpecializationTimetableResource;
use App\Models\Specialization;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SpecializationService
{
    public function getAllSpecializations(): ResourceCollection
    {
        $specializations = Specialization::query()->get();
        return SpecializationResource::collection($specializations);
    }

    public function getTimetableBySpecialization(int $specializationId): SpecializationTimetableResource
    {
        $specialization = Specialization::findBySpecializationId($specializationId);
        return new SpecializationTimetableResource($specialization);
    }

    public function getLegendBySpecialization(int $specializationId): SpecializationLegendResource
    {
        $specialization = Specialization::findBySpecializationId($specializationId);
        return new SpecializationLegendResource($specialization);
    }

    public function getSpecializationById(int $specializationId): SpecializationResource
    {
        $specialization = Specialization::findBySpecializationId($specializationId);
        return new SpecializationResource($specialization);
    }
}
