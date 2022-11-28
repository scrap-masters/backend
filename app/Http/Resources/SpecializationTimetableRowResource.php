<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Timetable;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecializationTimetableRowResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Timetable $timetable */
        $timetable = $this->resource;

        return [
            "id" => $timetable->id,
            "legend_id" => $timetable->legend?->id,
            "start" => $timetable->start,
            "end" => $timetable->end,
            "group" => $timetable->group,
            "lecturer" => $timetable->lecturer,
            "lesson" => $timetable->lesson,
            "title" => $timetable->title,
            "type" => $timetable->type,
            "room" => $timetable->lessonRoom,
        ];
    }
}
