<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Service\TimetableService;
use Illuminate\Bus\Batchable;
use Throwable;

class TimetableJob extends AbstractJob
{
    use Batchable;

    public function __construct(
        private readonly ?string $specializationSlug = null,
    ) {}

    /**
     * @throws Throwable
     */
    public function handle(TimetableService $timetableService): void
    {
        $this->beforeHandle();
        $timetableService->scrapeTimetableBySlugDirection($this->specializationSlug);
        $this->afterHandle();
    }
}
