<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Jobs\ScheduleScrapingTimetable;
use App\Services\TimetableService;
use Mockery\MockInterface;
use Tests\TestCase;

class ScheduleScrapingTimetableTest extends TestCase
{
    public function testScheduleStartScrapingSuccess(): void
    {
        $this->mock(TimetableService::class, function (MockInterface $mock): void {
            $mock->shouldReceive("scheduleStartScraping")
                ->once();
        });

        ScheduleScrapingTimetable::dispatch();
    }
}
