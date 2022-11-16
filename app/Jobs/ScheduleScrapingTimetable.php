<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Services\TimetableService;
use Illuminate\Bus\Batchable;
use Throwable;

class ScheduleScrapingTimetable extends AbstractJob
{
    use Batchable;

    /**
     * @throws Throwable
     */
    public function handle(TimetableService $timetableService): void
    {
        $this->beforeHandle();
        $timetableService->scheduleStartScraping();
        $this->afterHandle();
    }
}
