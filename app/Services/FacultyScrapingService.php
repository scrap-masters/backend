<?php

declare(strict_types=1);

namespace App\Services;

use App\Spiders\FacultySpider;
use RoachPHP\Roach;

class FacultyScrapingService
{
    public function __construct(
        public Roach $roach,
    ) {}

    public function getFaculties(): array
    {
        return $this->roach->collectSpider(FacultySpider::class);
    }
}
