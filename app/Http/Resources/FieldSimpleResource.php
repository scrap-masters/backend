<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Field;
use Illuminate\Http\Resources\Json\JsonResource;

class FieldSimpleResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Field $field */
        $field = $this->resource;

        return [
            "id" => $field->id,
            "name" => $field->name,
            "slug" => $field->slug,
            "isFullTime" => $field->isFullTime,
        ];
    }
}
