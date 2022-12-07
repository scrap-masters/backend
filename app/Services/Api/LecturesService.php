<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Http\Resources\LecturerTimetableResource;
use App\Models\Timetable;
use Illuminate\Support\Collection;

class LecturesService
{
    public function getAllLecturers(): Collection
    {
        return Timetable::getAllLecturers();
    }

    public function getPlanByLecturerByName(string $name): LecturerTimetableResource
    {
        $timetable = Timetable::getPlanByLecturerName($name);
        return new LecturerTimetableResource($timetable);
    }
}
