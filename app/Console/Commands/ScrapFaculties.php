<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Spiders\FacultySpider;
use Illuminate\Console\Command;
use RoachPHP\Roach;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ScrapFaculties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "faculty:list";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Start scraping faculties";

    public function handle(): int
    {
        Roach::startSpider(FacultySpider::class);
        return CommandAlias::SUCCESS;
    }
}
