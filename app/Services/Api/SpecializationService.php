<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Http\Resources\SpecializationResource;
use App\Models\Specialization;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SpecializationService
{
    public function getAllSpecializations(): ResourceCollection
    {
        $specializations = Specialization::query()->get();
        return SpecializationResource::collection($specializations);
    }

    public function getSpecializationById(int $specializationId): SpecializationResource
    {
        $specialization = Specialization::findBySpecializationId($specializationId);
        return new SpecializationResource($specialization);
    }
}
