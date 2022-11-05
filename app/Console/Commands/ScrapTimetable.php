<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Spiders\LegendSpider;
use App\Spiders\Timetable2Spider;
use App\Spiders\TimetableSpider;
use Illuminate\Console\Command;
use RoachPHP\Roach;
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
        Roach::startSpider(TimetableSpider::class);
        return CommandAlias::SUCCESS;
    }
}
