<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Specialization;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecializationResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Specialization $specialization */
        $specialization = $this->resource;

        return [
            "id" => $specialization->id,
            "name" => $specialization->name,
            "slug" => $specialization->slug,
            "field" => new FieldSimpleResource($specialization->field),
        ];
    }
}
