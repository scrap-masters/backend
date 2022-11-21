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

    public function getSpecializationsByFieldId(int $fieldId): FieldSpecializationsResource
    {
        $field = Field::findByFieldId($fieldId);
        return new FieldSpecializationsResource($field);
    }

    public function getFieldById(int $fieldId): FieldResource
    {
        $field = Field::findByFieldId($fieldId);
        return new FieldResource($field);
    }
}
