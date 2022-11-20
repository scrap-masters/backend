<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\AbstractJob;
use App\Jobs\TimetableJob;
use App\Models\Specialization;
use App\Spiders\LegendSpider;
use App\Spiders\TimetableSpider;
use App\Spiders\Utils\Constants;
use Illuminate\Bus\Batch;
use Illuminate\Support\Collection;
use RoachPHP\Roach;

class TimetableService extends AbstractBatchingService
{
    protected const BATCH_NAME = TimetableJob::class;

    public function __construct(
        ?Batch $currentBatch = null,
    ) {
        parent::__construct($currentBatch);
    }

    /**
     * @throws Exception\BatchException
     */
    public function scheduleStartScraping(): void
    {
        /** @var Collection<int, AbstractJob> $jobs */
        $jobs = Specialization::query()->pluck("slug")->map(fn(string $slug) => new TimetableJob($slug));
        $this->pushJobsToBatch($jobs);
    }

    public function scrapeTimetableBySlugDirection(?string $specializationSlug): void
    {
        Roach::startSpider(LegendSpider::class, context: [Constants::SPECIALIZATIONS_SLUG => $specializationSlug]);
        Roach::startSpider(TimetableSpider::class, context: [Constants::SPECIALIZATIONS_SLUG => $specializationSlug]);
    }
}
