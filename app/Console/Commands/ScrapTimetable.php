<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\ScheduleScrapingTimetable;
use App\Jobs\SpecializationJob;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ScrapTimetable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "timetable:all";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Start scraping a legend of timetable";

    public function handle(): int
    {
        SpecializationJob::dispatch()->onQueue(SpecializationJob::getDefaultQueueName());
        ScheduleScrapingTimetable::dispatch()->onQueue(ScheduleScrapingTimetable::getDefaultQueueName());
        return CommandAlias::SUCCESS;
    }
}
