<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\AbstractJob;
use App\Services\Exception\BatchException;
use Illuminate\Bus\Batch;
use Illuminate\Bus\PendingBatch;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Throwable;

abstract class AbstractBatchingService
{
    protected const BATCH_NAME = "";

    public function __construct(
        protected ?Batch $currentBatch = null,
    ) {}

    /**
     * @param Collection<int, AbstractJob> $jobs
     *
     * @throws BatchException
     */
    protected function pushJobsToBatch(Collection $jobs): void
    {
        if (empty($this->currentBatch)) {
            $this->initBatch($jobs);
        } else {
            $this->currentBatch->add($jobs);
        }
    }

    /**
     * @throws BatchException
     */
    protected function pushJobToBatch(AbstractJob $job): void
    {
        if (empty($this->currentBatch)) {
            throw new BatchException(
                "Cannot initialize batch with 1 job as it's risky operation - batch might close unexpectedly before appending another jobs",
            );
        }
        $this->currentBatch->add($job);
    }

    /**
     * @param Collection<int, AbstractJob> $jobs
     *
     * @throws BatchException
     */
    protected function initBatch(
        Collection $jobs,
    ): Batch {
        if (empty(static::BATCH_NAME)) {
            throw new BatchException("Cannot initialize batch without a name. Service does not have set BATCH_NAME const.");
        }

        try {
            $this->currentBatch = $this->defineBatch($jobs)->dispatch();
        } catch (Throwable $e) {
            throw new BatchException(previous: $e);
        }

        return $this->currentBatch;
    }

    /**
     * @param Collection<int, AbstractJob> $jobs
     */
    protected function defineBatch(Collection $jobs): PendingBatch
    {
        return Bus::batch($jobs)->name(static::BATCH_NAME)->allowFailures();
    }
}
