<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Http\Resources\FieldResource;
use App\Http\Resources\FieldSpecializationsResource;
use App\Models\Field;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FieldService
{
    public function getAllFields(): ResourceCollection
    {
        $fields = Field::query()->get();

        return FieldResource::collection($fields);
    }

    public function getSpecializationsByField(Field $field): FieldSpecializationsResource
    {
        return new FieldSpecializationsResource($field);
    }

    public function getFieldById(Field $field): FieldResource
    {
        return new FieldResource($field);
    }
}
