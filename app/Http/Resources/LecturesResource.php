<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Timetable;
use Illuminate\Http\Resources\Json\JsonResource;

class LecturesResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Timetable $timetable */
        $timetable = $this->resource;

        return [
            "name" => $timetable,
        ];
    }
}
