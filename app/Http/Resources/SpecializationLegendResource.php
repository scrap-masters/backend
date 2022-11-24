<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Specialization;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecializationLegendResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Specialization $specialization */
        $specialization = $this->resource;

        return [
            "id" => $specialization->id,
            "legend" => SpecializationLegendRowResource::collection($specialization->getLegend()),
        ];
    }
}
