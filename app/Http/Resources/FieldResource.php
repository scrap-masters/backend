<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Field;
use Illuminate\Http\Resources\Json\JsonResource;

class FieldResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Field $field */
        $field = $this->resource;

        return [
            "id" => $field->id,
            "name" => $field->name,
            "year" => $field->year,
            "slug" => $field->slug,
            "isFullTime" => $field->isFullTime,
            "faculty" => new FacultySimpleResource($field->faculty),
            "specializations" => SpecializationSimpleResource::collection($field->specializations),
        ];
    }
}
