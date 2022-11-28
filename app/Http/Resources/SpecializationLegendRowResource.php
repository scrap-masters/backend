<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Legend;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecializationLegendRowResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Legend $legend */
        $legend = $this->resource;

        return [
            "id" => $legend->id,
            "slug" => $legend->slug,
            "fullName" => $legend->fullName,
        ];
    }
}
