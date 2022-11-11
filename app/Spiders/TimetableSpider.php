<?php

declare(strict_types=1);

namespace App\Spiders;

use App\Spiders\Items\TimetableItem;
use App\Spiders\Processors\TimetableProcessor;
use App\Spiders\Utils\Constants;
use Generator;
use RoachPHP\Http\Response;
use Symfony\Component\DomCrawler\Crawler;

class TimetableSpider extends Spider
{
    public array $itemProcessors = [
        TimetableProcessor::class,
    ];

    public function parse(Response $response): Generator
    {
        $items = $response->each(function (Crawler $crawler) {
            return new TimetableItem(
                days: $crawler->filter(Constants::SELECTOR_TO_DAY),
                groups: $crawler->filter(Constants::SELECTOR_TO_GROUPS),
                hours:  $crawler->filter(Constants::SELECTOR_TO_HOURS),
                lessonRooms: $crawler->filter(Constants::SELECTOR_TO_LESSON_ROOM),
                lessons: $crawler->filter(Constants::SELECTOR_TO_LESSONS),
            );
        });

        foreach ($items as $item) {
            yield $this->item($item);
        }
    }
}