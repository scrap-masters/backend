<?php

declare(strict_types=1);

namespace Tests\Unit\Commands;

use App\Jobs\ScheduleScrapingTimetable;
use App\Jobs\SpecializationJob;
use Tests\TestCase;

class ScrapTimetableTest extends TestCase
{
    public function testTimetableJobsDispatchSuccess(): void
    {
        $this->expectsJobs(SpecializationJob::class);
        $this->expectsJobs(ScheduleScrapingTimetable::class);
        $this->artisan("timetable:all");
    }
}
