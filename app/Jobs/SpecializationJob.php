<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Spiders\FacultySpider;
use RoachPHP\Roach;
use Throwable;

class SpecializationJob extends AbstractJob
{
    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        $this->beforeHandle();
        Roach::startSpider(FacultySpider::class);
        $this->afterHandle();
    }
}
