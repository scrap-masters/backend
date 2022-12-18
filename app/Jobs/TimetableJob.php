<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Services\TimetableService;
use App\Spiders\Utils\Constants;
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
        $timetableService->scrapeTimetableBySlugDirection(
            str_replace(
                Constants::POLISH_LETTERS_TO_REPLACE,
                Constants::POLISH_LETTER_REPLACEMENTS,
                $this->specializationSlug,
            ),
        );
        $this->afterHandle();
    }
}
