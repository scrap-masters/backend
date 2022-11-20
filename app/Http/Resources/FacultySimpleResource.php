<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Faculty;
use Illuminate\Http\Resources\Json\JsonResource;

class FacultySimpleResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Faculty $faculty */
        $faculty = $this->resource;

        return [
            "id" => $faculty->id,
            "externalId" => $faculty->externalId,
            "name" => $faculty->name,
        ];
    }
}
