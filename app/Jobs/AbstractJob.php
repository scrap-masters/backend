<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AbstractJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /** The maximum number of unhandled exceptions to allow before failing. */
    public int $maxExceptions = 2;

    public static function getDefaultQueueName(): string
    {
        return config("queue.queues.default");
    }

    protected function beforeHandle(): void
    {
        Log::info("Running job " . static::class);
    }

    protected function afterHandle(string $suffix = ""): void
    {
        Log::info(
            sprintf(
                "Finished job %s. %s",
                static::class,
                $suffix,
            ),
        );
    }
}
