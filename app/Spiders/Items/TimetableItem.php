<?php

declare(strict_types=1);

namespace App\Spiders\Items;

use RoachPHP\ItemPipeline\AbstractItem;
use Symfony\Component\DomCrawler\Crawler;

final class TimetableItem extends AbstractItem
{
    public function __construct(
        public readonly Crawler $days,
        public readonly Crawler $groups,
        public readonly Crawler $hours,
        public readonly Crawler $lessonRooms,
        public readonly Crawler $lessons,
    ) {}
}
