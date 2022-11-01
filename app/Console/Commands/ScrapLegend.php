<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Spiders\LegendSpider;
use Illuminate\Console\Command;
use RoachPHP\Roach;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ScrapLegend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "timetable:legend";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Start scraping a legend of timetable";

    public function handle(): int
    {
        Roach::startSpider(LegendSpider::class);
        return CommandAlias::SUCCESS;
    }
}
